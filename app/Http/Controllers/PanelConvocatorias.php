<?php

namespace App\Http\Controllers;

use App\Http\Requests\PerfilDatosPersonalesRequest;
use App\Http\Requests\PerfilEstudiosRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Repositories\ArangoDB;
use ArangoDBClient\Exception as ArangoException;
use ArangoDBClient\ClientException as ArangoClientException;
use ArangoDBClient\ServerException as ArangoServerException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;


class PanelConvocatorias extends Controller
{
    protected $EdgeHandler;
    protected $ArangoDB;
    private $collection = 'usuario_convocatoria';
    private $controller = 'PanelConvocatorias';
    private $page;
    private $path;
    private $perPage = 25;

    /**
     * Industrias constructor.
     * @param ArangoDB $ArangoDB
     */
    public function __construct(ArangoDB $ArangoDB)
    {
        $this->ArangoDB = $ArangoDB;
        ArangoException::enableLogging();
        $this->page = LengthAwarePaginator::resolveCurrentPage('page');
        $this->path = LengthAwarePaginator::resolveCurrentPath();
    }

    /**
     * Listado de Convocatorias
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function Index(Request $request){
        $query = '
        FOR convocatoria IN convocatorias
            FOR quien IN quien
                FILTER convocatoria.quien == quien._key AND convocatoria.activo == "Si"
                SORT convocatoria._key ASC LIMIT '.($this->perPage*($this->page-1)).', '.$this->perPage.'
                RETURN merge(convocatoria, {quien_nombre: quien.nombre} )
        ';
        $convocatorias = $this->ArangoDB->Query($query);
        if($request->get('total')!=''){
            $total = $request->get('total');
        }else{
            $total = $this->ArangoDB->Query('FOR doc IN '.$this->collection.' COLLECT WITH COUNT INTO length RETURN length');
            $total = (int)$total[0];
        }
        $datos = $this->ArangoDB->Pagination($convocatorias, $total, $this->PaginationQuery());
        return view('panel.convocatorias.list', compact('convocatorias','total'));
    }

    /**
     * Estudios para el Perfil del Usuario
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function Ver($key){
        //Obteniendo Convocatoria
        $query = '
            FOR convocatoria IN convocatorias
            FILTER convocatoria._key=="'.$key.'"
            FOR users IN users
                FOR entidad IN entidades
                    FOR quien IN quien
                        FILTER convocatoria.responsable == users._key AND convocatoria.entidad  == entidad._key AND convocatoria.quien  == quien._key
                        RETURN merge(convocatoria, {responsable: {username: users.username, nombre: CONCAT(users.nombre," ", users.apellidos)}}, {entidad: entidad.nombre}, {quien: quien.nombre} )';
        $item = $this->ArangoDB->Query($query);
        $item = $item[0];

        //Emprendimientos
        $emprendimientos = $this->ArangoDB->Query('FOR doc IN emprendimientos FILTER doc.userKey == "'.auth()->user()->_key.'" FILTER doc.convocatoria==null RETURN {_key: doc._key, nombre:doc.nombre}',true);
        $emprendimientos = $this->ArangoDB->SelectFormat($emprendimientos, '_key', 'nombre');

        return view('panel.convocatorias.view', compact('item','emprendimientos'));
    }

    /**
     * Listado de Convocatorias
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function Aplicaciones(Request $request){
        $query = '
        FOR convocatoria IN convocatorias
            FOR users IN users
                FOR entidad IN entidades
                    FOR quien IN quien
                        FILTER convocatoria.responsable == users._key AND convocatoria.entidad  == entidad._key
                        RETURN merge(convocatoria, {responsable: {username: users.username, nombre: CONCAT(users.nombre," ", users.apellidos)}}, {entidad: entidad.nombre} )
        ';
        $data = $this->ArangoDB->Query($query);
        if($request->get('total')!=''){
            $total = $request->get('total');
        }else{
            $total = $this->ArangoDB->Query('FOR doc IN '.$this->collection.' COLLECT WITH COUNT INTO length RETURN length');
            $total = (int)$total[0];
        }
        $datos = $this->ArangoDB->Pagination($data, $total, $this->PaginationQuery());
        return view('panel.'.$this->collection.'.list', compact('datos','total'));
    }

    /**
     * Guardar Datos Personales del Perfil
     * @param PerfilDatosPersonalesRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ArangoClientException
     * @throws ArangoException
     */
    public function Aplicar($key, PerfilDatosPersonalesRequest $request){

        $document = [];
        $document['biografia'] = $request->get('biografia');
        $document['sexo'] = $request->get('sexo');
        $document['fecha_nacimiento'] = $request->get('fecha_nacimiento');
        $document['a_que_se_dedica'] = $request->get('a_que_se_dedica');
        $document['linkedin'] = $request->get('linkedin');
        $document['pais'] = $request->get('pais');
        if($request->get('estado_otro')!=''){
            $document['estado'] = null;
            $document['estado_otro'] = $request->get('estado_otro');
        }else{
            $document['estado'] = $request->get('estado');
            $document['estado_otro'] = null;
        }
        $document['ciudad'] = $request->get('ciudad');
        $document['userKey'] = auth()->user()->_key;

        // Creando Nuevo Registro
        if($request->get('id')==''){
            $documentId = $this->ArangoDB->Save($this->collection, $document);

            //Creando Edge
            $this->ArangoDB->CreateEdge(['label' => 'hasPerfil', 'created_time'=>now()], 'hasPerfil', 'users/'.auth()->user()->_key, $documentId);
        }else{
            // Actualizando Registro
            $documentId = $request->get('id');
            $this->ArangoDB->Update($this->collection, $this->collection.'/'.$request->get('id'), $document);
        }

        // Guardando Imagen de Avatar
        if($_FILES['foto']['size'] != 0 && $_FILES['foto']['error'] == 0){
            $img = Image::make($_FILES['foto']['tmp_name']);
            $img->fit(300, 300)->save(public_path('/users_pics/user_'. auth()->user()->_key .'.jpg', 100));
        }

        Session::flash('status_success', 'Datos Personales Guardados');
        return redirect()->action($this->controller.'@Estudios');
    }

    /**
     * Regresar variables para paginacion
     * @return array
     */
    public function PaginationQuery(){
        return ['page'=>$this->page, 'perPage' => $this->perPage, 'path'=>$this->path];
    }

}