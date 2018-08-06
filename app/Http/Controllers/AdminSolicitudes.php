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
    private $perPage = 25;

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
        $query = '
        FOR doc IN usuario_convocatoria
            FOR conv IN convocatorias
                FOR usuario IN users
                    FOR emp IN emprendimientos
                        FILTER doc.responsable_id == "'.auth()->user()->_key.'" AND conv._key  == doc.convocatoria_id AND emp._key == doc.emprendimiento_id AND usuario._key == doc.userKey
                        SORT doc._key ASC LIMIT '.($this->perPage*($this->page-1)).', '.$this->perPage.'
                        RETURN merge(doc, {convocatoria: conv}, {emprendimiento: emp}, {usuario: usuario} )
        ';
        $data = $this->ArangoDB->Query($query);
        if($request->get('total')!=''){
            $total = $request->get('total');
        }else{
            $total = $this->ArangoDB->Query('FOR doc IN '.$this->collection.' COLLECT WITH COUNT INTO length RETURN length');
            $total = (int)$total[0];
        }
        $datos = $this->ArangoDB->Pagination($data, $total, $this->PaginationQuery());
        return view('admin.solicitudes.list', compact('datos','total'));
    }


    /**
     * Editar la Solicitud
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function Edit($id){
        $query = '
        FOR doc IN usuario_convocatoria
            FOR conv IN convocatorias
                FOR emp IN emprendimientos
                    FOR usuario IN users
                        FILTER doc._key == "'.$id.'" AND conv._key  == doc.convocatoria_id AND emp._key == doc.emprendimiento_id AND usuario._key == doc.userKey
                        RETURN merge(doc, {convocatoria: conv}, {emprendimiento: emp}, {usuario: usuario})
        ';
        $sol = $this->ArangoDB->Query($query);
        $solicitud = $sol[0];
        $item = $solicitud->emprendimiento;


        /*** Datos Generales **/
        //Obteniendo listado de socios seleccionados
        if($id!=''){
            if($item->socios!='') {
                $query = [];
                foreach ($item->socios as $k => $v) {
                    $query[]= "doc._key=='" . $v . "' ";
                }
                $query = implode('OR ', $query);
                $socios = $this->ArangoDB->Query(
                    "FOR doc IN users
                            FILTER $query
                            return {'id':doc._key, 'nombre': CONCAT(doc.nombre,' ',doc.apellidos,' (',doc.email,')')}"
                    , true);
                $socios = $this->ArangoDB->SelectFormat($socios, 'id', 'nombre');
            }else{
                $socios = [];
            }
        }else{
            $socios = [];
        }

        // Obteniendo Industrias
        $industrias = $this->ArangoDB->Query('FOR doc IN industrias RETURN doc');

        // Obteniendo Etapas
        $etapas = $this->ArangoDB->Query('FOR doc IN etapas RETURN doc', true);
        $etapas = $this->ArangoDB->SelectFormat($etapas, '_key', 'nombre');

        // Paises
        $paises = $this->paises;

        //Niveles
        $nivel_tlr = $this->nivel_tlr;

        /*** Ventas **/
        // Obteniendo Modelos de Ventas
        $modelos_ventas = $this->modelos_ventas;

        // Meses Anteriores
        if(isset($item->ventas) && $item->ventas!=null){
            $_meses = $this->getItemMeses($item->ventas);
            $montos = $_meses['montos'];
            $meses = $_meses['meses_items'];
        }else{
            $meses = $this->getMeses($this->meses_montos, time());
        }
        $n_meses = $this->n_meses;

        return view('admin.solicitudes.edit',
            compact('solicitud','item','socios','industrias','etapas','paises','nivel_tlr','montos','modelos_ventas','meses','n_meses')
        );
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