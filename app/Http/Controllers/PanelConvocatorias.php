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
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ArangoClientException
     * @throws ArangoException
     */
    public function Aplicar($key, Request $request){

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
        $emprendimiento = $this->ArangoDB->Query('FOR doc IN emprendimientos FILTER doc._key=="'.$request->get('emprendimiento').'" AND doc.userKey == "'.auth()->user()->_key.'" RETURN doc');
        $emprendimiento = $emprendimiento[0];

        return view('panel.convocatorias.aplicar', compact('item','emprendimiento'));
    }

    /**
     * Regresar variables para paginacion
     * @return array
     */
    public function PaginationQuery(){
        return ['page'=>$this->page, 'perPage' => $this->perPage, 'path'=>$this->path];
    }

}