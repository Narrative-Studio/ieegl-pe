<?php

namespace App\Http\Controllers;

use App\Mail\SolicitudEmail;
use Illuminate\Http\Request;
use App\Repositories\ArangoDB;
use ArangoDBClient\Exception as ArangoException;
use ArangoDBClient\ClientException as ArangoClientException;
use ArangoDBClient\ServerException as ArangoServerException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;


class AdminSolicitudes extends Controller
{
    protected $DocumentHandler;
    protected $CollectionHandler;
    protected $ArangoDB;
    private $collection = 'usuario_convocatoria';
    private $controller = 'AdminSolicitudes';
    private $page;
    private $path;
    private $perPage = 50;

    /**
     * Solicitud constructor.
     * @param ArangoDB $ArangoDB
     */
    public function __construct(ArangoDB $ArangoDB)
    {
        $this->ArangoDB = $ArangoDB;
        //$this->DocumentHandler = $ArangoDB->DocumentHandler();
        //$this->CollectionHandler = $ArangoDB->CollectionHandler();
        ArangoException::enableLogging();
        $this->middleware('auth:admin');
        $this->page = LengthAwarePaginator::resolveCurrentPage('page');
        $this->path = LengthAwarePaginator::resolveCurrentPath();
    }

    /**
     * Listado de Solicitudes
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function Index(Request $request){
        $query_convo = ($request->get('convocatoria')!='')?' AND doc.convocatoria_id=="'.$request->get('convocatoria').'"':'';
        $query_user = (auth()->user()->isAdmin != 1)?'doc.responsable_id == "'.auth()->user()->_key.'" AND':'';
        $query = '
        FOR doc IN usuario_convocatoria
            FOR conv IN convocatorias
                FOR emp IN emprendimientos
                    FOR usuario IN users
                        FILTER '.$query_user.' conv._key  == doc.convocatoria_id AND usuario._key == doc.userKey AND emp._key == doc.emprendimiento_id '.$query_convo.'
                        SORT doc._key ASC LIMIT '.($this->perPage*($this->page-1)).', '.$this->perPage.'
                        RETURN merge(doc, {convocatoria: conv}, {usuario: usuario}, {emprendimiento: emp.nombre} )
        ';
        $data = $this->ArangoDB->Query($query);
        if($request->get('total')!=''){
            $total = $request->get('total');
        }else{
            $total = $this->ArangoDB->Query('
            FOR doc IN usuario_convocatoria
                FOR conv IN convocatorias
                    FOR usuario IN users
                        FILTER '.$query_user.' conv._key  == doc.convocatoria_id AND usuario._key == doc.userKey '.$query_convo.'
                        SORT doc._key ASC COLLECT WITH COUNT INTO length RETURN length
            ');
            $total = (int)$total[0];
        }
        // Lista de Convocatorias
        $query = '
            FOR doc IN convocatorias
                FILTER '.$query_user.' 1==1
                SORT doc.nombre ASC
                RETURN {_key: doc._key, nombre: doc.nombre}
        ';
        $convocatorias = $this->ArangoDB->Query($query, true);
        $convocatorias = $this->ArangoDB->SelectFormat($convocatorias, '_key','nombre');

        $datos = $this->ArangoDB->Pagination($data, $total, $this->PaginationQuery());
        return view('admin.solicitudes.list', compact('datos','total','convocatorias'));
    }


    /**
     * Editar la Solicitud
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function Edit($id){
        $preguntas_solicitud = [];
        $query = '
        FOR doc IN usuario_convocatoria
            FOR conv IN convocatorias
                FOR usuario IN users
                    FILTER doc._key == "'.$id.'" AND conv._key  == doc.convocatoria_id AND usuario._key == doc.userKey
                    RETURN merge(doc, {convocatoria: conv}, {usuario: usuario})
        ';
        $sol = $this->ArangoDB->Query($query);
        $solicitud = $sol[0];

        if( $solicitud->convocatoria->quien!='6375236') {
            $query = '
                FOR emp IN emprendimientos
                    FILTER emp._key == "' . $solicitud->emprendimiento_id . '"
                    RETURN emp
            ';
            $emp = $this->ArangoDB->Query($query);
            $item = $emp[0];

            // Obteniendo Industrias
            $industrias = $this->ArangoDB->Query('FOR doc IN industrias SORT doc.nombre ASC RETURN doc', true);
            $industrias = $this->ArangoDB->SelectFormat($industrias, '_key', 'nombre');

            // Obteniendo Etapas
            $etapas = $this->ArangoDB->Query('FOR doc IN etapas SORT doc.nombre ASC RETURN doc', true);
            $etapas = $this->ArangoDB->SelectFormat($etapas, '_key', 'nombre');

            //Niveles
            $nivel_tlr = $this->nivel_tlr;

            // Obteniendo Terminos
            $terminos = $this->ArangoDB->Query('FOR doc IN terminos RETURN doc', true);
            $terminos = $this->ArangoDB->SelectFormat($terminos, '_key', 'nombre');

            // Como te enteraste
            $enteraste = $this->como_te_enteraste;

            // Obteniendo Universidades
            $universidades = $this->ArangoDB->Query('FOR doc IN universidades RETURN doc', true);
            $universidades = $this->ArangoDB->SelectFormat($universidades, '_key','nombre');

            // Estudiando
            $estudiando = $this->estudiando;

            // Paises
            $paises = $this->paises;

            // Estados
            $estados = $this->estados;

            //Campus TEC
            $campus = $this->campus;

            if(isset($solicitud->preguntas)) $preguntas_solicitud = json_decode(json_encode($solicitud->preguntas), true);

            return view('admin.solicitudes.edit',
                compact('solicitud', 'item', 'preguntas_solicitud','industrias','etapas','nivel_tlr','terminos','enteraste','universidades','estudiando','campus','paises','estados')
            );
        }else{
            return view('admin.solicitudes.edit',
                compact('solicitud')
            );
        }
    }

    static function returnRespuestas($preg, $array){
        $r = [];
        foreach ($preg as $p){ $r[] = $array[$p];}
        return implode(', ',$r);
    }

    /**
     * Guardar Solicitud
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ArangoClientException
     * @throws ArangoException
     */
    public function Save(Request $request){

        $aprobacion = '';
        $data = [];
        $document = [];
        $document['aprobado'] = $request->get('aprobado');
        $document['comentarios'] = $request->get('comentarios');
        $document['pago'] = $request->get('pago');
        $document['fecha_aprobacion'] = now();

        // Actualizando Registro
        $documentId = $this->ArangoDB->Update($this->collection, $this->collection.'/'.$request->get('id'), $document);
        $key = $request->get('id');
        Session::flash('status_success', 'Registro Actualizado');

        // Si se eligió enviar correo al usuario
        if($request->get('enviar')==1){
            // Obeniendo solicitud, convocatoria, emprendimiento y usuario.
            $query = '
                FOR doc IN usuario_convocatoria
                    FOR conv IN convocatorias
                        FOR emp IN emprendimientos
                            FOR usuario IN users
                                FILTER doc._key == "'.$key.'" AND conv._key  == doc.convocatoria_id AND emp._key == doc.emprendimiento_id AND usuario._key == doc.userKey
                                RETURN merge(doc, {convocatoria: conv}, {emprendimiento: emp}, {usuario: usuario})
                ';
            $sol = $this->ArangoDB->Query($query);
            $item = $sol[0];

            if($item->aprobado=='1') $aprobacion = '<span style="color:#FFAB00;">Pendiente</span>';
            if($item->aprobado=='4') $aprobacion = '<span style="color:#ffd95d;">Pendiente de Pago</span>';
            if($item->aprobado=='2') $aprobacion = '<span style="color:#880000;">Rechazada</span>';
            if($item->aprobado=='3') $aprobacion = '<span style="color:#008000;">Aprobada</span>';

            $data['nombre'] = $item->usuario->nombre;
            $data['apellidos'] = $item->usuario->apellidos;
            $data['email'] = $item->usuario->email;
            $data['convocatoria'] = $item->convocatoria->nombre;
            $data['aprobacion'] = $aprobacion;
            $data['mensaje'] = $item->comentarios;

            // Enviando con actualización de solicitud
            Mail::to($data['email'])
                ->send(new SolicitudEmail($data));

            Session::flash('status_success', 'Registro Actualizado y Correo Enviado');
        }

        return redirect()->action($this->controller.'@Index');
    }

    /**
     * Borrar registro de Solicitud
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws ArangoException
     */
    public function Delete($id){
        try {
            $result = $this->ArangoDB->Delete($this->collection, $this->collection.'/'.$id);
        } catch (ArangoServerException $e) {
            Session::flash('status_error', $e->getMessage());
            return redirect()->action($this->controller.'@Index');
        }
        Session::flash('status_success', 'Registro Borrado');
        return redirect()->action($this->controller.'@Index');
    }

    /**
     * Regresar variables para paginacion
     * @return array
     */
    public function PaginationQuery(){
        return ['page'=>$this->page, 'perPage' => $this->perPage, 'path'=>$this->path];
    }

    /**
     * Regresa valores del item para las tablas de montos
     * @param $valores
     * @return array
     */
    public function getItemMeses($valores){
        $m = json_encode($valores);
        $m = json_decode($m,true);

        $meses_item = [];
        foreach ($m as $k=>$v){
            foreach ($v as $key=>$val){
                $meses_item[$k][] = $key;
            }
            asort($meses_item[$k]);
        }
        return ['montos'=>$m, 'meses_items'=>$meses_item];
    }
}