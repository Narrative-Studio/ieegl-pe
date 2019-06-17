<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmprendimientosClientesRequest;
use App\Http\Requests\EmprendimientosDatosGeneralesRequest;
use App\Http\Requests\EmprendimientosFinancieraRequest;
use App\Http\Requests\EmprendimientosInversionRequest;
use App\Http\Requests\EmprendimientosMediosDigitalesRequest;
use App\Http\Requests\EmprendimientosMercadoRequest;
use App\Http\Requests\EmprendimientosUsuariosRequest;
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
use Illuminate\Support\Facades\Input;
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

    /**
     * Listado de Emprendimientos del Usuario
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function Index(){

        $data = $this->ArangoDB->Query('FOR doc IN perfiles FILTER doc.userKey == "'.auth()->user()->_key.'" RETURN doc');
        if(count($data)<1){
            return redirect()->action('PanelPerfiles@Index');
        }else{
            $niveles = $this->nivel_tlr;
            $emprendimientos = $this->ArangoDB->Query('FOR doc IN emprendimientos FILTER doc.userKey == "'.auth()->user()->_key.'"  OR  "'.auth()->user()->_key.'" IN doc.socios SORT doc._key desc RETURN doc');
            return view('panel.emprendimientos.lista',compact('emprendimientos','niveles'));
        }
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
        $industrias = $this->ArangoDB->Query('FOR doc IN industrias SORT doc.nombre ASC RETURN doc');

        // Obteniendo Etapas
        $etapas = $this->ArangoDB->Query('FOR doc IN etapas SORT doc.nombre ASC RETURN doc', true);
        $etapas = $this->ArangoDB->SelectFormat($etapas, '_key', 'nombre');

        // Paises
        $paises = $this->paises;

        //Niveles
        $nivel_tlr = $this->nivel_tlr;

        $enteraste = $this->como_te_enteraste;

        return view('panel.' . $this->collection . '.datos-generales', compact('item','etapas', 'industrias', 'paises', 'nivel_tlr','socios','enteraste'));
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
        $document['investigacion_desarrollo'] = $request->get('investigacion_desarrollo');
        $document['nivel_tlr'] = $request->get('nivel_tlr');
        $document['numero_socios'] = $request->get('numero_socios');
        $document['socios'] = $request->get('socios');
        $document['como_te_enteraste'] = $request->get('como_te_enteraste');
        $document['diferenciador_modelo_negocio'] = $request->get('diferenciador_modelo_negocio');
        $document['prototipo_o_mvp'] = $request->get('prototipo_o_mvp');
        $document['como_te_enteraste_cual'] = $request->get('como_te_enteraste_cual');
        $document['module_datos'] = true;
        $document['created_at'] = date('Y-m-d H:i:s');

        if($request->get('id')==''){
            // Agregando variable de modulos
            $document['module_medios'] = false;
            $document['module_ventas'] = false;
            $document['module_mercado'] = false;
            $document['module_financiera'] = false;
            $document['module_inversion'] = false;
            $document['convocatoria'] =  null;

            // Creando Nuevo Registro
            $documentId = $this->ArangoDB->Save($this->collection, $document);
            //Creando Edge
            $this->ArangoDB->CreateEdge(['label' => 'hasEmprendimiento', 'created_time'=>now()], 'hasEmprendimiento', 'users/'.auth()->user()->_key, $documentId);
        }else{
            // Actualizando Registro
            if($this->getUserKey($request->get('id'))!=auth()->user()->_key) abort(404);
            $documentId = $request->get('id');
            $this->ArangoDB->Update($this->collection, $this->collection.'/'.$request->get('id'), $document);
        }

        $key = str_replace('emprendimientos/','', $documentId);

        Session::flash('status_success', 'Datos Personales Guardados');
        return redirect()->action($this->controller.'@MediosDigitales', ['id'=>$key]);
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

        if($this->getUserKey($request->get('id'))!=auth()->user()->_key) abort(404);

        $documentId = $request->get('id');
        $document = [];
        $document['sitio_web'] = $request->get('sitio_web');
        $document['red_social'] = $request->get('red_social');
        $document['video'] = $request->get('video');
        $document['module_medios'] = true;

        // Guardando Logo del Emprendimiento
        if($_FILES['logo']['size'] != 0 && $_FILES['logo']['error'] == 0){
            $ext = Input::file('logo')->getClientOriginalExtension();
            $img = Image::make($_FILES['logo']['tmp_name']);
            $file_name = '/emprendimientos_pics/logo_'.$documentId.'.'.$ext;
            $img->save(public_path($file_name, 100));
            $document['logo_file'] = $file_name;
        }

        // Guardando Presentacion
        if($_FILES['presentacion']['size'] != 0 && $_FILES['presentacion']['error'] == 0){
            $ext = Input::file('presentacion')->getClientOriginalExtension();
            $file_name = 'presentacion_'.$documentId.'.'.$ext;
            $request->file('presentacion')->move(public_path('/emprendimientos_pdf/'),$file_name);
            $document['presentacion_file'] = '/emprendimientos_pdf/'.$file_name;
        }
        $this->ArangoDB->Update($this->collection, $this->collection.'/'.$documentId, $document);

        Session::flash('status_success', 'Medios Digitales Guardados');
        return redirect()->action($this->controller.'@Mercado', ['id'=>$documentId]);
    }

    /**
     * Mercado del Emprendimiento
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function Mercado($id)
    {
        // Montos de clientes si es que existe el registro
        $montos_clientes = [];

        //Obteniendo el Emprendimiento
        $item = $this->getItem($id);

        // Meses Anteriores
        if(isset($item->clientes) && $item->clientes!=null){
            $_meses_clientes = $this->getItemMeses($item->clientes);
            $montos_clientes = $_meses_clientes['montos'];
            $meses_clientes = $_meses_clientes['meses_items'];
        }else{
            $meses_clientes = $this->getMeses($this->meses_montos, time());
        }
        $n_meses_clientes = $this->n_meses;

        // Montos de usuarios si es que existe el registro
        $montos_usuarios = [];

        //Obteniendo el Emprendimiento
        $item = $this->getItem($id);

        // Meses Anteriores
        if(isset($item->usuarios) && $item->usuarios!=null){
            $_meses_usuarios = $this->getItemMeses($item->usuarios);
            $montos_usuarios = $_meses_usuarios['montos'];
            $meses_usuarios = $_meses_usuarios['meses_items'];
        }else{
            $meses_usuarios = $this->getMeses($this->meses_montos, time());
        }
        $n_meses_usuarios = $this->n_meses;

        return view('panel.' . $this->collection . '.mercado', compact('item','meses_clientes','n_meses_clientes','montos_clientes','meses_usuarios','n_meses_usuarios','montos_usuarios'));
    }

    /**
     * Guardar datos de Mercado de Emprendimiento
     * @param EmprendimientosMercadoRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ArangoClientException
     * @throws ArangoException
     */
    public function SaveMercado(EmprendimientosMercadoRequest $request){

        if($this->getUserKey($request->get('id'))!=auth()->user()->_key) abort(404);

        $document = [];
        $document['tiene_usuarios'] = $request->get('tiene_usuarios');
        $document['tiene_clientes'] = $request->get('tiene_clientes');
        $document['module_mercado'] = true;

        if($request->get('tiene_clientes')=="Si"){

            $clientes = [];
            foreach($_REQUEST as $r=>$v){
                if(preg_match('/mes_[0-9]+_[0-9]+/', $r)){ // obteniendo solo variables request de los clientes
                    $ex = explode("_", $r);
                    $clientes[$ex[2]][$ex[1]] = str_replace(',','',$v);
                }
            }
            $document['clientes'] = $clientes;
            $document['clientes_activos'] = $request->get('clientes_activos');
            $document['caracteristicas_clientes'] = $request->get('caracteristicas_clientes');

        }else{
            $document['clientes_activos'] = null;
            $document['clientes'] = null;
        }

        if($request->get('tiene_usuarios')=="Si"){

            $usuarios = [];
            foreach($_REQUEST as $r=>$v){
                if(preg_match('/mes_[0-9]+_[0-9]+/', $r)){ // obteniendo solo variables request de los usuarios
                    $ex = explode("_", $r);
                    $usuarios[$ex[2]][$ex[1]] = str_replace(',','',$v);
                }
            }
            $document['usuarios'] = $usuarios;
            $document['usuarios_activos'] = $request->get('usuarios_activos');
            $document['caracteristicas_usuarios'] = $request->get('caracteristicas_usuarios');

        }else{
            $document['usuarios_activos'] = null;
            $document['usuarios'] = null;
        }

        $documentId = $request->get('id');
        $this->ArangoDB->Update($this->collection, $this->collection.'/'.$documentId, $document);

        Session::flash('status_success', 'Clientes Guardados');
        return redirect()->action($this->controller.'@Inversion', ['id'=>$documentId]);
    }

    /**
     * Inversiones del Emprendimiento
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function Inversion($id)
    {

        //Obteniendo el Emprendimiento
        $item = $this->getItem($id);

        // Obteniendo los meses del año
        $meses_inversion = $this->n_meses;
        unset($meses_inversion[0]);

        // Vehiculos de Inversion
        $vehiculos = $this->vehiculos_inversion;

        // Obteniendo Etapas
        $terminos = $this->ArangoDB->Query('FOR doc IN terminos RETURN doc', true);
        $terminos = $this->ArangoDB->SelectFormat($terminos, '_key', 'nombre');

        return view('panel.' . $this->collection . '.inversion', compact('item','meses_inversion', 'vehiculos', 'terminos'));
    }

    /**
     * Guardar datos de Inversion de Emprendimiento
     * @param EmprendimientosInversionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ArangoClientException
     * @throws ArangoException
     */
    public function SaveInversion(EmprendimientosInversionRequest $request){

        if($this->getUserKey($request->get('id'))!=auth()->user()->_key) abort(404);

        $document = [];
        $document['levantado_capital'] = $request->get('levantado_capital');
        $document['recibido_inversion'] = $request->get('recibido_inversion');
        $document['buscando_capital'] = $request->get('buscando_capital');
        $document['recibido_capital_cuanto'] = str_replace(',','',$request->get('recibido_capital_cuanto'));
        $document['recibido_inversion_cuanto'] = str_replace(',','',$request->get('recibido_inversion_cuanto'));
        $document['capital_cuanto'] = str_replace(',','',$request->get('capital_cuanto'));
        $document['module_inversion'] = true;

        /*if($request->get('invertido_capital')=="Si"){
            // Si ha tenido inversion de capital de socios
            $capital = $request->get('capital');
            $cc = [];
            foreach($capital as $cap){
                $cap['monto'] = str_replace(',','',$cap['monto']);
                $cc[] = $cap;
            }
            $document['capital'] = $cc;
        }else{
            $document['capital'] = null;
        }*/
        // Si ha recibido inversion
        /*if($request->get('recibido_inversion')=="Si"){
            $document['recibido_inversion_dequien'] = $request->get('recibido_inversion_dequien');
            $document['recibido_inversion_cuanto'] = str_replace(',','',$request->get('recibido_inversion_cuanto'));
            $document['recibido_inversion_como'] = $request->get('recibido_inversion_como');
            $document['recibido_inversion_fecha_levantaron_capital'] = $request->get('recibido_inversion_fecha_levantaron_capital');
            $document['recibido_inversion_vehiculo'] = $request->get('recibido_inversion_vehiculo');
        }else{
            $document['recibido_inversion_dequien'] = null;
            $document['recibido_inversion_cuanto'] = null;
            $document['recibido_inversion_como'] = null;
            $document['recibido_inversion_fecha_levantaron_capital'] = null;
            $document['recibido_inversion_vehiculo'] = null;
        }
        // Si esta buscando capital
        if($request->get('buscando_capital')=="Si"){
            $document['capital_cuanto'] = str_replace(',','',$request->get('capital_cuanto'));
            $document['vehiculo_inversion'] = $request->get('vehiculo_inversion');
        }else{
            $document['capital_cuanto'] = null;
            $document['vehiculo_inversion'] = null;
        }*/

        $documentId = $request->get('id');
        $this->ArangoDB->Update($this->collection, $this->collection.'/'.$documentId, $document);

        Session::flash('status_success', 'Inversión Guardada');
        return redirect()->action($this->controller.'@Financiera', ['id'=>$documentId]);
    }

    /**
     * Informacion Financiera del Emprendimiento
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function Financiera($id)
    {

        // Montos de ventas si es que existe el registro
        $montos = [];

        //Obteniendo el Emprendimiento
        $item = $this->getItem($id);

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

        return view('panel.' . $this->collection . '.financiera', compact('item','meses','n_meses','montos','modelos_ventas'));
    }

    /**
     * uardar datos de Informacion Financiera de Emprendimiento
     * @param EmprendimientosVentasRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ArangoClientException
     * @throws ArangoException
     */
    public function SaveFinanciera(EmprendimientosFinancieraRequest $request){

        if($this->getUserKey($request->get('id'))!=auth()->user()->_key) abort(404);

        $documentId = $request->get('id');
        $document = [];
        $document['lanzar_producto'] = $request->get('lanzar_producto');
        $document['fecha_lanzamiento'] = $request->get('fecha_lanzamiento');
        $document['realizado_ventas'] = $request->get('realizado_ventas');
        $document['patente_ip'] = $request->get('patente_ip');
        $document['socio_exit_empresa'] = $request->get('socio_exit_empresa');
        $document['mes1'] = $request->get('mes1');
        $document['mes2'] = $request->get('mes2');
        $document['mes3'] = $request->get('mes3');
        $document['module_financiera'] = true;


        // Guardando Cédula de Identificación Fiscal del Emprendimiento
        if($_FILES['cedula_identificacion']['size'] != 0 && $_FILES['cedula_identificacion']['error'] == 0){
            $ext = Input::file('cedula_identificacion')->getClientOriginalExtension();
            $file_name = 'cedula_'.$documentId.'.'.$ext;
            $request->file('cedula_identificacion')->move(public_path('/emprendimientos_pics/'),$file_name);
            $document['cedula_file'] = '/emprendimientos_pics/'.$file_name;
        }
        $this->ArangoDB->Update($this->collection, $this->collection.'/'.$documentId, $document);

        Session::flash('status_success', 'Información Financiera Guardada');
        return redirect()->action($this->controller.'@Final', ['id'=>$documentId]);
    }

    /**
     * Paso Final del Emprendimiento
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function Final($id)
    {
        //Obteniendo el Emprendimiento
        $item = $this->getItem($id);

        return view('panel.' . $this->collection . '.final', compact('item'));
    }


    /**
     * Obtener Item desde Arango
     * @param $id
     * @return mixed
     * @throws ArangoException
     */
    public function getItem($id){
        $data = $this->ArangoDB->Query('FOR doc IN emprendimientos FILTER doc._key=="'.$id.'" AND (doc.userKey == "'.auth()->user()->_key.'" or "'.auth()->user()->_key.'" IN doc.socios) RETURN doc');
        return $data[0];
    }

    /**
     * Obtener UserKey del Emprendimiento
     * @param $id
     * @return mixed
     * @throws ArangoException
     */
    public function getUserKey($id){
        $data = $this->ArangoDB->Query('FOR doc IN emprendimientos FILTER doc._key=="'.$id.'" RETURN doc.userKey');
        return (count($data)<1)?false:$data[0];
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

    public function DeleteFile(Request $request){
        $file = $request->get('file');
        $seccion = $request->get('seccion');
        unlink(public_path($file)) or die("Couldn't delete file");
        Session::flash('status_success', 'Archivo borrado');
        return redirect()->action($this->controller.'@'.$seccion, ['id'=>$request->get('key')]);
    }
}
