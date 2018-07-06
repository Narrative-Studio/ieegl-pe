<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmprendimientosDatosGeneralesRequest;
use App\Http\Requests\EmprendimientosMediosDigitalesRequest;
use App\Http\Requests\EmprendimientosVentasRequest;
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

class PanelEmprendimientos extends Controller
{
    protected $EdgeHandler;
    protected $ArangoDB;
    private $collection = 'emprendimientos';
    private $controller = 'PanelEmprendimientos';
    private $page;
    private $path;
    private $perPage = 25;

    /**
     * Emprendimientos constructor.
     * @param ArangoDB $ArangoDB
     */
    public function __construct(ArangoDB $ArangoDB)
    {
        $this->ArangoDB = $ArangoDB;
        ArangoException::enableLogging();
        $this->page = LengthAwarePaginator::resolveCurrentPage('page');
        $this->path = LengthAwarePaginator::resolveCurrentPath();
    }

    public function Index(){
        //return view('panel.'.$this->collection.'.datos-personales', compact('paises','estados', 'item'));
    }

    /**
     * Datos Generales del Emprendimiento
     * @param string $id (optional)
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function DatosGenerales($id="")
    {
        //Obteniendo el Emprendimiento
        $item = ($id!='')?$this->getItem($id):[];

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

        return view('panel.' . $this->collection . '.datos-generales', compact('item','etapas', 'industrias', 'paises', 'nivel_tlr','socios'));
    }

    /**
     * Guardar Datos Generales Emprendimiento
     * @param EmprendimientosDatosGeneralesRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ArangoClientException
     * @throws ArangoException
     */
    public function SaveDatosGenerales(EmprendimientosDatosGeneralesRequest $request){
        $document = [];
        $document['userKey'] = auth()->user()->_key;
        $document['nombre'] = $request->get('nombre');
        $document['descripcion'] = $request->get('descripcion');
        $document['fecha_fundacion'] = $request->get('fecha_fundacion');
        $document['numero_colaboradores'] = $request->get('numero_colaboradores');
        $document['pais'] = $request->get('pais');
        $document['ciudad'] = $request->get('ciudad');
        $document['industria_o_sector'] = $request->get('industria_o_sector');
        $document['etapa_emprendimiento'] = $request->get('etapa_emprendimiento');
        $document['mercado_cliente'] = $request->get('mercado_cliente');
        $document['problema_soluciona'] = $request->get('problema_soluciona');
        $document['competencia'] = $request->get('competencia');
        $document['diferencia_competencia'] = $request->get('diferencia_competencia');
        $document['patente_ip'] = $request->get('patente_ip');
        $document['investigacion_desarrollo'] = $request->get('investigacion_desarrollo');
        $document['nivel_tlr'] = $request->get('nivel_tlr');
        $document['numero_socios'] = $request->get('numero_socios');
        $document['socio_exit_empresa'] = $request->get('socio_exit_empresa');
        $document['socios'] = $request->get('socios');
        $document['module_datos'] = true;

        if($request->get('id')==''){
            // Agregando variable de modulos
            $document['module_medios'] = false;
            $document['module_ventas'] = false;

            // Creando Nuevo Registro
            $documentId = $this->ArangoDB->Save($this->collection, $document);
            //Creando Edge
            $this->ArangoDB->CreateEdge(['label' => 'hasEmprendimiento', 'created_time'=>now()], 'hasEmprendimiento', 'users/'.auth()->user()->_key, $documentId);
        }else{
            // Actualizando Registro
            $documentId = $request->get('id');
            $this->ArangoDB->Update($this->collection, $this->collection.'/'.$request->get('id'), $document);
        }

        $key = str_replace('emprendimientos/','', $documentId);

        // Guardando Logo del Emprendimiento
        if($_FILES['logo']['size'] != 0 && $_FILES['logo']['error'] == 0){
            $img = Image::make($_FILES['logo']['tmp_name']);
            $img->save(public_path('/emprendimientos_pics/logo_'.$key .'.jpg', 100));
        }
        // Guardando Cédula de Identificación Fiscal del Emprendimiento
        if($_FILES['cedula_identificacion']['size'] != 0 && $_FILES['cedula_identificacion']['error'] == 0){
            $img = Image::make($_FILES['cedula_identificacion']['tmp_name']);
            $img->save(public_path('/emprendimientos_pics/cedula_'.$key .'.jpg', 100));
        }

        Session::flash('status_success', 'Datos Personales Guardados');
        return redirect()->action($this->controller.'@MediosDigitales', ['id'=>$documentId]);
    }

    /**
     * Search de Socios por nombre,apellidos e email
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ArangoException
     */
    public function SearchSocios(Request $request){
        $usuarios = $this->ArangoDB->Query(
            'FOR doc IN users 
                    FILTER doc.isAdmin==0 
                    AND doc.validated==1 
                    AND doc.active==1 
                    AND (LOWER(CONCAT(doc.nombre," ",doc.apellidos)) LIKE "%'.strtolower($request->get('term')).'%" OR LOWER(doc.email) LIKE "%'.strtolower($request->get('term')).'%") 
                    RETURN doc', true);
        $data = [];
        foreach ($usuarios as $u){
            $data['results'][] = ['id'=>$u['_key'], 'text'=>$u['nombre'].' '.$u['apellidos'].' ('.$u['email'].')'];
        }
        return response()->json($data);

    }

    /**
     * Medios Digitales del Emprendimiento
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function MediosDigitales($id)
    {
        //Obteniendo el Emprendimiento
        $item = $this->getItem($id);

        return view('panel.' . $this->collection . '.medios-digitales', compact('item'));
    }

    /**
     * Guardar Medios Digitales del Emprendimiento
     * @param EmprendimientosMediosDigitalesRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ArangoClientException
     * @throws ArangoException
     */
    public function SaveMediosDigitales(EmprendimientosMediosDigitalesRequest $request){
        $document = [];
        $document['sitio_web'] = $request->get('sitio_web');
        $document['red_social'] = $request->get('red_social');
        $document['video'] = $request->get('video');
        $document['module_medios'] = true;

        $documentId = $request->get('id');
        $this->ArangoDB->Update($this->collection, $this->collection.'/'.$documentId, $document);

        Session::flash('status_success', 'Medios Digitales Guardados');
        return redirect()->action($this->controller.'@Ventas', ['id'=>$documentId]);
    }

    /**
     * Ventas del Emprendimiento
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function Ventas($id)
    {
        // Montos de ventas si es que existe el registro
        $montos = [];

        //Obteniendo el Emprendimiento
        $item = $this->getItem($id);

        // Obteniendo Modelos de Ventas
        $modelos_ventas = $this->modelos_ventas;

        // Meses Anteriores
        if($item->ventas!=null){
            $_meses = $this->getItemMeses($item->ventas);
            $montos = $_meses['montos'];
            $meses = $_meses['meses_items'];
        }else{
            $meses = $this->getMeses($this->meses_montos, time());
            //$meses = $this->getMeses($this->meses_montos, strtotime("2018-02-01"));
        }
        $n_meses = $this->n_meses;

        return view('panel.' . $this->collection . '.ventas', compact('item','modelos_ventas','meses','n_meses','montos'));
    }

    /**
     * Guardar datos de Ventas de Emprendimiento
     * @param EmprendimientosVentasRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ArangoClientException
     * @throws ArangoException
     */
    public function SaveVentas(EmprendimientosVentasRequest $request){
        $document = [];
        $document['lanzar_producto'] = $request->get('lanzar_producto');
        $document['module_ventas'] = true;

        if($request->get('lanzar_producto')=="Si"){

            $document['fecha_lanzamiento'] = $request->get('fecha_lanzamiento');
            $document['modelo_ventas'] = $request->get('modelo_ventas');
            $document['realizado_ventas'] = $request->get('realizado_ventas');

            if($request->get('realizado_ventas')=="Si"){

                $ventas = [];
                foreach($_REQUEST as $r=>$v){
                    if(preg_match('/mes_[0-9]+_[0-9]+/', $r)){ // obteniendo solo variables request de las ventas
                        $ex = explode("_", $r);
                        $ventas[$ex[2]][$ex[1]] = str_replace(',','',$v);
                    }
                }
                $document['ventas'] = $ventas;
                $document['venta_total_año_pasado'] = $request->get('venta_total_año_pasado');

            }else{
                $document['venta_total_año_pasado'] = null;
                $document['ventas'] = null;
            }
        }else{
            $document['fecha_lanzamiento'] = null;
            $document['modelo_ventas'] = null;
            $document['realizado_ventas'] = null;
            $document['venta_total_año_pasado'] = null;
            $document['ventas'] = null;
        }

        $documentId = $request->get('id');
        $this->ArangoDB->Update($this->collection, $this->collection.'/'.$documentId, $document);

        Session::flash('status_success', 'Ventas Guardadas');
        return redirect()->action($this->controller.'@Ventas', ['id'=>$documentId]);
    }

    /**
     * Obtener Item desde Arango
     * @param $id
     * @return mixed
     * @throws ArangoException
     */
    public function getItem($id){
        $data = $this->ArangoDB->Query('FOR doc IN emprendimientos FILTER doc._key=="'.$id.'" AND doc.userKey == "'.auth()->user()->_key.'" RETURN doc');
        return $data[0];
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
