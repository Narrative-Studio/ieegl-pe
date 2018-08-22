<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmprendimientosClientesRequest;
use App\Http\Requests\EmprendimientosDatosGeneralesRequest;
use App\Http\Requests\EmprendimientosFinancieraRequest;
use App\Http\Requests\EmprendimientosInversionRequest;
use App\Http\Requests\EmprendimientosMediosDigitalesRequest;
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
        $niveles = $this->nivel_tlr;
        $emprendimientos = $this->ArangoDB->Query('FOR doc IN emprendimientos FILTER doc.userKey == "'.auth()->user()->_key.'" RETURN doc');
        return view('panel.emprendimientos.lista',compact('emprendimientos','niveles'));
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
        $document['investigacion_desarrollo'] = $request->get('investigacion_desarrollo');
        $document['nivel_tlr'] = $request->get('nivel_tlr');
        $document['numero_socios'] = $request->get('numero_socios');
        $document['socio_exit_empresa'] = $request->get('socio_exit_empresa');
        $document['socios'] = $request->get('socios');
        $document['como_te_enteraste'] = $request->get('como_te_enteraste');
        $document['diferenciador_modelo_negocio'] = $request->get('diferenciador_modelo_negocio');
        $document['module_datos'] = true;

        if($request->get('id')==''){
            // Agregando variable de modulos
            $document['module_medios'] = false;
            $document['module_ventas'] = false;
            $document['module_clientes'] = false;
            $document['module_usuarios'] = false;
            $document['module_financiera'] = false;
            $document['module_inversion'] = false;
            $document['convocatoria'] =  null;

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
        $document = [];
        $document['sitio_web'] = $request->get('sitio_web');
        $document['red_social'] = $request->get('red_social');
        $document['video'] = $request->get('video');
        $document['module_medios'] = true;

        $documentId = $request->get('id');
        $this->ArangoDB->Update($this->collection, $this->collection.'/'.$documentId, $document);

        // Guardando Logo del Emprendimiento
        if($_FILES['logo']['size'] != 0 && $_FILES['logo']['error'] == 0){
            $img = Image::make($_FILES['logo']['tmp_name']);
            $img->save(public_path('/emprendimientos_pics/logo_'.$documentId.'.jpg', 100));
        }

        // Guardando Presentacion PDF
        if($_FILES['presentacion']['size'] != 0 && $_FILES['presentacion']['error'] == 0){
            $request->file('presentacion')->move(public_path('/emprendimientos_pdf/'),'presentacion_'.$documentId.'.pdf');
        }

        Session::flash('status_success', 'Medios Digitales Guardados');
        return redirect()->action($this->controller.'@Clientes', ['id'=>$documentId]);
    }

    /**
     * Clientes/Usuarios del Emprendimiento
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function Clientes($id)
    {
        // Montos de clientes si es que existe el registro
        $montos = [];

        //Obteniendo el Emprendimiento
        $item = $this->getItem($id);

        // Meses Anteriores
        if(isset($item->clientes) && $item->clientes!=null){
            $_meses = $this->getItemMeses($item->clientes);
            $montos = $_meses['montos'];
            $meses = $_meses['meses_items'];
        }else{
            $meses = $this->getMeses($this->meses_montos, time());
        }
        $n_meses = $this->n_meses;

        return view('panel.' . $this->collection . '.clientes', compact('item','meses','n_meses','montos'));
    }

    /**
     * Guardar datos de Clientes/Usuarios de Emprendimiento
     * @param EmprendimientosClientesRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ArangoClientException
     * @throws ArangoException
     */
    public function SaveClientes(EmprendimientosClientesRequest $request){
        $document = [];
        $document['tiene_clientes'] = $request->get('tiene_clientes');
        $document['module_clientes'] = true;

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

        $documentId = $request->get('id');
        $this->ArangoDB->Update($this->collection, $this->collection.'/'.$documentId, $document);

        Session::flash('status_success', 'Clientes Guardados');
        return redirect()->action($this->controller.'@Usuarios', ['id'=>$documentId]);
    }

    /**
     * Usuarios/Usuarios del Emprendimiento
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function Usuarios($id)
    {
        // Montos de usuarios si es que existe el registro
        $montos = [];

        //Obteniendo el Emprendimiento
        $item = $this->getItem($id);

        // Meses Anteriores
        if(isset($item->usuarios) && $item->usuarios!=null){
            $_meses = $this->getItemMeses($item->usuarios);
            $montos = $_meses['montos'];
            $meses = $_meses['meses_items'];
        }else{
            $meses = $this->getMeses($this->meses_montos, time());
        }
        $n_meses = $this->n_meses;

        return view('panel.' . $this->collection . '.usuarios', compact('item','meses','n_meses','montos'));
    }

    /**
     * Guardar datos de Usuarios/Usuarios de Emprendimiento
     * @param EmprendimientosUsuariosRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ArangoClientException
     * @throws ArangoException
     */
    public function SaveUsuarios(EmprendimientosUsuariosRequest $request){
        $document = [];
        $document['tiene_usuarios'] = $request->get('tiene_usuarios');
        $document['module_usuarios'] = true;

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

        Session::flash('status_success', 'Usuarios Guardados');
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
            //$meses = $this->getMeses($this->meses_montos, strtotime("2018-02-01"));
        }
        $n_meses = $this->n_meses;



        // Montos de información financiera si es que existe el registro
        /*$montos = [];

        //Obteniendo el Emprendimiento
        $item = $this->getItem($id);

        // Meses Anteriores
        if(isset($item->financiera) && $item->financiera!=null){
            $_meses = $this->getItemMeses($item->financiera);
            $montos = $_meses['montos'];
            $meses = $_meses['meses_items'];
        }else{
            $meses = $this->getMeses($this->meses_montos, time());
        }
        $n_meses = $this->n_meses;*/

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
        $document = [];
        $document['lanzar_producto'] = $request->get('lanzar_producto');
        $document['module_ventas'] = true;

        if($request->get('lanzar_producto')=="Si"){

            $document['fecha_lanzamiento'] = $request->get('fecha_lanzamiento');
            $document['fecha_fundacion'] = $request->get('fecha_fundacion');
            $document['modelo_ventas'] = $request->get('modelo_ventas');
            $document['realizado_ventas'] = $request->get('realizado_ventas');
            $document['patente_ip'] = $request->get('patente_ip');
            $document['socio_exit_empresa'] = $request->get('socio_exit_empresa');
            $document['gasto_mensual'] = $request->get('gasto_mensual');
            $document['pierde_dinero'] = $request->get('pierde_dinero');

            if($request->get('realizado_ventas')=="Si"){

                $ventas = [];
                foreach($_REQUEST as $r=>$v){
                    if(preg_match('/mes_[0-9]+_[0-9]+/', $r)){ // obteniendo solo variables request de las ventas
                        $ex = explode("_", $r);
                        $ventas[$ex[2]][$ex[1]] = str_replace(',','',$v);
                    }
                }
                $document['ventas'] = $ventas;

            }else{
                $document['gasto_mensual'] = null;
                $document['pierde_dinero'] = null;
                $document['ventas'] = null;
                $document['socio_exit_empresa'] = null;
            }
        }else{
            $document['fecha_lanzamiento'] = null;
            $document['fecha_fundacion'] =null;
            $document['modelo_ventas'] = null;
            $document['patente_ip'] = null;
            $document['realizado_ventas'] = null;
            $document['gasto_mensual'] = null;
            $document['pierde_dinero'] = null;
            $document['ventas'] = null;
            $document['socio_exit_empresa'] = null;
        }

        $documentId = $request->get('id');
        $this->ArangoDB->Update($this->collection, $this->collection.'/'.$documentId, $document);

        // Guardando Cédula de Identificación Fiscal del Emprendimiento
        if($_FILES['cedula_identificacion']['size'] != 0 && $_FILES['cedula_identificacion']['error'] == 0){
            $img = Image::make($_FILES['cedula_identificacion']['tmp_name']);
            $img->save(public_path('/emprendimientos_pics/cedula_'.$documentId .'.jpg', 100));
        }

        Session::flash('status_success', 'Ventas Guardadas');
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
        $meses = $this->n_meses;
        unset($meses[0]);

        // Vehiculos de Inversion
        $vehiculos = $this->vehiculos_inversion;

        // Obteniendo Etapas
        $terminos = $this->ArangoDB->Query('FOR doc IN terminos RETURN doc', true);
        $terminos = $this->ArangoDB->SelectFormat($terminos, '_key', 'nombre');

        return view('panel.' . $this->collection . '.inversion', compact('item','meses', 'vehiculos', 'terminos'));
    }

    /**
     * Guardar datos de Inversion de Emprendimiento
     * @param EmprendimientosInversionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ArangoClientException
     * @throws ArangoException
     */
    public function SaveInversion(EmprendimientosInversionRequest $request){
        $document = [];
        $document['invertido_capital'] = $request->get('invertido_capital');
        $document['module_inversion'] = true;

        if($request->get('invertido_capital')=="Si"){
            // Si ha tenido inversion de capital de socios
            $capital = $request->get('capital');
            $cc = [];
            foreach($capital as $cap){
                $cap['monto'] = str_replace(',','',$cap['monto']);
                $cc[] = $cap;
            }
            $document['capital'] = $cc;
            $document['inversion_otras'] = $request->get('inversion_otras');
            $document['buscando_capital'] = $request->get('buscando_capital');
            $document['capital_cuanto'] = str_replace(',','',$request->get('capital_cuanto'));
            $document['vehiculo_inversion'] = $request->get('vehiculo_inversion');

            // Si ha recibido inversio de otros
            if($request->get('inversion_otras')=="Si"){
                $capital = $request->get('capital_otros');
                $cc = [];
                foreach($capital as $cap){
                    $cap['monto'] = str_replace(',','',$cap['monto']);
                    $cc[] = $cap;
                }
                $document['capital_otros'] = $cc;
            }else{
                $document['capital_otros'] = null;
            }
        }else{
            $document['inversion_otras'] = null;
            $document['capital_otros'] = null;
            $document['buscando_capital'] = null;
            $document['capital_cuanto'] = null;
            $document['vehiculo_inversion'] = null;
        }

        $documentId = $request->get('id');
        $this->ArangoDB->Update($this->collection, $this->collection.'/'.$documentId, $document);

        Session::flash('status_success', 'Inversion Guardada');
        return redirect()->action($this->controller.'@Financiera', ['id'=>$documentId]);
    }

    /**
     * Guardar datos de Informacion Financiera de Emprendimiento
     * @param EmprendimientosFinancieraRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ArangoClientException
     * @throws ArangoException
     */
    public function SaveFinanciera2(EmprendimientosFinancieraRequest $request){
        $document = [];
        $document['module_financiera'] = true;
        $document['gasto_total'] = str_replace(',','',$request->get('gasto_total'));
        $document['valoracion_emprendimiento'] = $request->get('valoracion_emprendimiento');
        $document['monto_valoracion'] = str_replace(',','',$request->get('monto_valoracion'));
        $document['patente_ip'] = $request->get('patente_ip');

        $montos = [];
        foreach($_REQUEST as $r=>$v){
            if(preg_match('/mes_[0-9]+_[0-9]+/', $r)){ // obteniendo solo variables request
                $ex = explode("_", $r);
                $montos[$ex[2]][$ex[1]] = str_replace(',','',$v);
            }
        }
        $document['financiera'] = $montos;

        $documentId = $request->get('id');
        $this->ArangoDB->Update($this->collection, $this->collection.'/'.$documentId, $document);

        // Guardando Cédula de Identificación Fiscal del Emprendimiento
        if($_FILES['cedula_identificacion']['size'] != 0 && $_FILES['cedula_identificacion']['error'] == 0){
            $img = Image::make($_FILES['cedula_identificacion']['tmp_name']);
            $img->save(public_path('/emprendimientos_pics/cedula_'.$documentId .'.jpg', 100));
        }

        Session::flash('status_success', 'Información Financiera Guardada');
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
