<?php

namespace App\Http\Controllers;

use App\Http\Requests\PerfilDatosPersonalesRequest;
use App\Http\Requests\PerfilEstudiosRequest;
use App\Http\Requests\UserRequest;
use App\Mail\SolicitudAdmin;
use App\Mail\UpdateSolicitudAdmin;
use Illuminate\Http\Request;
use App\Repositories\ArangoDB;
use ArangoDBClient\Exception as ArangoException;
use ArangoDBClient\ClientException as ArangoClientException;
use ArangoDBClient\ServerException as ArangoServerException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Mail;
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
        $query_aql = '
        FOR convocatoria IN convocatorias
            FOR entidad IN entidades
                FOR quien IN quien
                    FILTER convocatoria.quien == quien._key AND convocatoria.activo == "Si" AND convocatoria.fecha_inicio_convocatoria <= \''.time().'\' AND convocatoria.fecha_fin_convocatoria <= \''.time().'\'  AND convocatoria.entidad  == entidad._key
                    SORT convocatoria.created_at DESC LIMIT '.($this->perPage*($this->page-1)).', '.$this->perPage.'        
        ';
        $query = $query_aql. ' RETURN merge(convocatoria, {quien_nombre: quien.nombre}, {entidad: entidad.nombre,  entidad_desc: entidad.descripcion, entidad_key: entidad._key, entidad_ext: entidad.ext} )';
        $convocatorias = $this->ArangoDB->Query($query);
        if($request->get('total')!=''){
            $total = $request->get('total');
        }else{
            $total = $this->ArangoDB->Query($query_aql.' COLLECT WITH COUNT INTO length RETURN length');
            $total = (int)$total[0];
        }
        $convocatorias = $this->ArangoDB->Pagination($convocatorias, $total, $this->PaginationQuery());
        return view('panel.convocatorias.list', compact('convocatorias','total'));
    }

    /**
     * Ver Convocatoria
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function Ver($key){
        $filter = '';
        $emprendimientos = '';

        //Obteniendo Convocatoria
        $query = '
            FOR convocatoria IN convocatorias
            FILTER convocatoria._key=="'.$key.'"
            FOR users IN users
                FOR entidad IN entidades
                    FOR quien IN quien
                        FILTER convocatoria.responsable == users._key AND convocatoria.entidad  == entidad._key AND convocatoria.quien  == quien._key
                        RETURN merge(convocatoria, {responsable: {username: users.username, nombre: CONCAT(users.nombre," ", users.apellidos)}}, {entidad: entidad.nombre,  entidad_desc: entidad.descripcion, entidad_key: entidad._key, entidad_ext: entidad.ext}, {quien: quien.nombre, quien_key:quien._key} )';
        $item = $this->ArangoDB->Query($query);
        $item = $item[0];

        if($item->activo=="deleted") abort(404);

        //$existe = $this->ArangoDB->Query('FOR doc IN '.$this->collection.' FILTER doc.userKey=="'.auth()->user()->_key.'" AND doc.convocatoria_id == "'.$key.'" AND doc.aprobado!=2 RETURN doc');
        //$verificar = (count($existe)>0)?true:false;
        $verificar = false;
        $emprendimientos = [];

        if($verificar==false && auth()->user()){

            // Agregando filtro de 'Emprendimiento lanzado al mercado con o sin ventas'
            /*if($item->quien=='637A5309'){
                $filter = ' AND doc.module_ventas == true AND doc.lanzar_producto == "Si" ';
            }*/

            // Si la convocatoria no es exclusva para "Emprendedor sin idea pero con inquietud de emprender" se obtienen los emprendimientos
            if($item->quien!='6375236'){
                //Emprendimientos
                $emprendimientos = $this->ArangoDB->Query('FOR doc IN emprendimientos FILTER doc.userKey == "'.auth()->user()->_key.'" '.$filter.' SORT doc.nombre RETURN {_key: doc._key, nombre:doc.nombre}',true);
                $emprendimientos = $this->ArangoDB->SelectFormat($emprendimientos, '_key', 'nombre');
            }
        }

        return view('panel.convocatorias.view', compact('item','emprendimientos', 'verificar'));
    }

    /**
     * Listado de Aplicaciones
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function Aplicaciones(Request $request){
        $query = '
        FOR doc IN usuario_convocatoria
            FOR conv IN convocatorias
                FOR emp IN emprendimientos
                    FILTER doc.userKey == "'.auth()->user()->_key.'" AND conv._key  == doc.convocatoria_id AND emp._key == doc.emprendimiento_id
                    SORT doc.fecha DESC LIMIT '.($this->perPage*($this->page-1)).', '.$this->perPage.'
                    RETURN merge(doc, {activo: conv.activo}, {nombre: conv.nombre}, {quien: conv.quien}, {emprendimiento: emp.nombre}, {descripcion: conv.descripcion_corta}, {fecha_inicio_convocatoria: conv.fecha_inicio_convocatoria}, {fecha_fin_convocatoria: conv.fecha_fin_convocatoria} )
        ';
        $data = $this->ArangoDB->Query($query);
        if($request->get('total')!=''){
            $total = $request->get('total');
        }else{
            $total = $this->ArangoDB->Query('FOR doc IN '.$this->collection.' FILTER doc.userKey == "'.auth()->user()->_key.'" COLLECT WITH COUNT INTO length RETURN length');
            $total = (int)$total[0];
        }
        $convocatorias = $this->ArangoDB->Pagination($data, $total, $this->PaginationQuery());
        return view('panel.convocatorias.mis-aplicaciones', compact('convocatorias','total'));
    }

    /**
     * Ver Aplicación
     * @param $key
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function VerAplicacion($key){
        $query = '
        FOR doc IN usuario_convocatoria
            FOR conv IN convocatorias
                FOR quien IN quien
                    FOR emp IN emprendimientos
                        FOR entidad IN entidades
                            FOR responsable IN users
                            FILTER doc._key == "'.$key.'" AND conv._key  == doc.convocatoria_id AND emp._key == doc.emprendimiento_id AND quien._key  == conv.quien AND entidad._key == conv.entidad AND responsable._key == conv.responsable
                                RETURN merge(doc, {convocatoria: conv}, {emprendimiento: emp.nombre, emprendimiento_id: emp._key}, {quien: quien.nombre}, {entidad: entidad.nombre,  entidad_desc: entidad.descripcion, entidad_key: entidad._key, entidad_ext: entidad.ext}, {responsable: CONCAT(responsable.nombre," ",responsable.apellidos)})
        ';
        $item = $this->ArangoDB->Query($query);
        $item = $item[0];

        return view('panel.convocatorias.view-aplicacion', compact('item'));
    }

    /**
     * @param $key
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function Aplicar($key, Request $request){
        $puede_aplicar = true; // validacion para aplicar a convocatoria
        $errores = []; // Errores de por que no fue aprobada la convicatoria
        $emprendimiento = "";
        $msg = "";

        if(!$_POST && $request->get('type')!='json')  abort(404);

        //Obteniendo Convocatoria
        $query = '
            FOR convocatoria IN convocatorias
            FILTER convocatoria._key=="'.$key.'"
            FOR users IN users
                FOR entidad IN entidades
                    FOR quien IN quien
                        FILTER convocatoria.responsable == users._key AND convocatoria.entidad  == entidad._key AND convocatoria.quien  == quien._key
                        RETURN merge(convocatoria, {responsable: {username: users.username, nombre: CONCAT(users.nombre," ", users.apellidos)}}, {entidad: entidad.nombre}, {quien: quien.nombre, quien_key:quien._key} )';
        $item = $this->ArangoDB->Query($query);
        $item = $item[0];

        if($item->activo=="deleted") abort(404);

        // Si la convocatoria requiere un Emprendimiento
        if($item->quien_key!='6375236') {

            // Verificando que no se duplique el emprendimiento en la convicatoria
            $verificar = $this->VerificarEmeprendimiento($request->get('emprendimiento'), $key);

            //Emprendimiento seleccionado*/
            $emprendimiento = $this->ArangoDB->Query('FOR doc IN emprendimientos FILTER doc._key=="' . $request->get('emprendimiento') . '" AND doc.userKey == "' . auth()->user()->_key . '" RETURN doc');
            $emprendimiento = $emprendimiento[0];

            // Debe tener Datos Generales
            /*if($emprendimiento->module_datos==false){
                $puede_aplicar = false;
                $errores['generales'] = 'Debes tener Datos Generales';
            }

            // Debe tener Medios digitales
            if($emprendimiento->module_medios==false){
                $puede_aplicar = false;
                $errores['medios'] = 'Debes tener Medios Digitales';
            }*/

            // Si quien puede aplicar es diferente a TODOS
            if($item->quien_key!='11536038') {

                // Emprendimiento lanzado al mercado con o sin ventas
                if ($item->quien_key == '6375309'){
                    if (isset($emprendimiento->lanzar_producto)) {
                        if ($emprendimiento->lanzar_producto != "Si") {
                            $puede_aplicar = false;
                            $errores['lanzado'] = $msg = 'Tu emprendimiento debe estar lanzado al mercado';
                        }
                    } else {
                        $puede_aplicar = false;
                        $errores['lanzado'] = $msg = 'Tu emprendimiento debe estar lanzado al mercado';
                    }
                }else{
                    // Si la convocatoria requiere Ventas Registradas
                    /*if ($item->ventas == "Si") {
                        if (isset($emprendimiento->realizado_ventas)) {
                            if ($emprendimiento->realizado_ventas != "Si") {
                                $puede_aplicar = false;
                                $errores['ventas'] = 'Debes tener ventas registradas';
                            }
                        } else {
                            $puede_aplicar = false;
                            $errores['ventas'] = 'Debes tener ventas registradas';
                        }
                    }*/
                }

                if ($item->quien_key == '6375265'){ // Emprendimiento en validación o MVP
                    if (isset($emprendimiento->prototipo_o_mvp)) {
                        if ($emprendimiento->prototipo_o_mvp != "Si") {
                            $puede_aplicar = false;
                            $errores['mvp'] = $msg =  'Tu emprendimiento debe contar con un prototipo o MVP';
                        }
                    } else {
                        $puede_aplicar = false;
                        $errores['mvp'] = $msg =  'Tu emprendimiento debe contar con un prototipo o MVP';
                    }
                }

                // Si la convocatoria requiere Clientes
                /*if ($item->clientes == "Si") {
                    if(isset($emprendimiento->tiene_clientes)){
                        if($emprendimiento->tiene_clientes!="Si"){
                            $puede_aplicar = false;
                            $errores['clientes'] = 'Debes tener clientes';
                        }
                    }else{
                        $puede_aplicar = false;
                        $errores['clientes'] = 'Debes tener clientes';
                    }
                }
                // Si la convocatoria requiere Usuarios
                if ($item->usuarios == "Si") {
                    if(isset($emprendimiento->tiene_usuarios)){
                        if($emprendimiento->tiene_usuarios!="Si"){
                            $puede_aplicar = false;
                            $errores['usuarios'] = 'Debes tener usuarios';
                        }
                    }else{
                        $puede_aplicar = false;
                        $errores['usuarios'] = 'Debes tener usuarios';
                    }
                }
                // Si la convocatoria requiere Información Financiera registrada
                if ($item->financiera == "Si") {
                    if($emprendimiento->module_financiera==false){
                        $puede_aplicar = false;
                        $errores['financiera'] = 'Debes tener Información Financiera';
                    }
                }*/
            }
        }else{
            // Verificando que no se duplique el emprendimiento en la convicatoria
            $verificar = $this->VerificarEmeprendimiento('', $key);
        }

        if($request->get('type')!='json'){
            // Datos del Perfil
            $data = $this->ArangoDB->Query('FOR doc IN perfiles FILTER doc.userKey == "'.auth()->user()->_key.'" RETURN doc',true);
            $perfil = (count($data)>0)?$data[0]:[];
            $paises = $this->paises; // Paises
            $estados = $this->estados; // Estados
            $sexo = $this->sexo;
            $dedicas = $this->a_que_te_dedicas;

            // Cuenta
            $data = $this->ArangoDB->Query('FOR doc IN users FILTER doc._key == "'.auth()->user()->_key.'" RETURN doc',true);
            $cuenta = (count($data)>0)?$data[0]:[];

            //Emprendimiento
            $data = $this->ArangoDB->Query('FOR doc IN emprendimientos FILTER doc._key=="'.$request->get('emprendimiento').'" RETURN doc', true);
            $emprendimiento_array = (count($data)>0)?$data[0]:[];

            // Obteniendo Industrias
            $industrias = $this->ArangoDB->Query('FOR doc IN industrias SORT doc.nombre ASC RETURN doc');

            // Obteniendo Etapas
            $etapas = $this->ArangoDB->Query('FOR doc IN etapas SORT doc.nombre ASC RETURN doc', true);
            $etapas = $this->ArangoDB->SelectFormat($etapas, '_key', 'nombre');

            //Niveles
            $nivel_tlr = $this->nivel_tlr;

            // Vehiculos de Inversion
            $vehiculos = $this->vehiculos_inversion;

            // Obteniendo Terminos
            $terminos = $this->ArangoDB->Query('FOR doc IN terminos RETURN doc', true);
            $terminos = $this->ArangoDB->SelectFormat($terminos, '_key', 'nombre');

            $enteraste = $this->como_te_enteraste;

            // Estudiando
            $estudiando = $this->estudiando;

            //Campus TEC
            $campus = $this->campus;

            //Preguntas de Catálogo
            $preg_cat = [];
            $preg_cat_aql = [];
            $preguntas_catalogo = [];
            foreach($item->preguntas as $pregunta){
                if($pregunta->tipo=="catalogos") $preg_cat[]=$pregunta->campo;
            }
            if(count($preg_cat)>0){
                $preg_cat = implode('","', $preg_cat);
                $preg_cat_aql = $this->ArangoDB->Query(' FOR preguntas IN preguntas_admin FILTER preguntas._key IN ["'.$preg_cat.'"] RETURN preguntas', true);
            }
            if(count($preg_cat_aql)>0){
                foreach($preg_cat_aql as $pregunta) {
                    $preguntas_catalogo[$pregunta['_key']] = [
                        "_key"=>$pregunta['_key'],
                        "placeholder"=>isset($pregunta['placeholder'])?$pregunta['placeholder']:'',
                        "pregunta"=>isset($pregunta['pregunta'])?$pregunta['pregunta']:'',
                        "respuestas"=>isset($pregunta['respuestas'])?$pregunta['respuestas']:'',
                        "tipo"=>$pregunta['tipo'],
                        "categoria"=>$pregunta['categoria'],
                    ];
                }
            }

            return view('panel.convocatorias.aplicar', compact('item','emprendimiento', 'puede_aplicar', 'errores', 'verificar',
                'perfil','paises','estados','sexo','dedicas','estudiando','campus',
                'cuenta','emprendimiento_array',
                'industrias','nivel_tlr','enteraste','etapas','vehiculos','terminos',
                'preguntas_catalogo'
            ));
        }else{
            $response = [];
            $response['puede_aplicar'] = $puede_aplicar;
            $response['msg'] =  $msg;
            echo json_encode($response);
        }
    }

    public function EditarAplicacion($key, Request $request){
        $errores = []; // Errores de por que no fue aprobada la convicatoria
        $emprendimiento = "";
        $msg = "";

        // Aplicacion
        $aplicacion = $this->ArangoDB->Query('FOR doc IN usuario_convocatoria FILTER doc._key=="'.$key.'" RETURN doc');
        $aplicacion = $aplicacion[0];

        //Obteniendo Convocatoria
        $query = '
            FOR convocatoria IN convocatorias
            FILTER convocatoria._key=="'.$aplicacion->convocatoria_id.'"
            FOR users IN users
                FOR entidad IN entidades
                    FOR quien IN quien
                        FILTER convocatoria.responsable == users._key AND convocatoria.entidad  == entidad._key AND convocatoria.quien  == quien._key
                        RETURN merge(convocatoria, {responsable: {username: users.username, nombre: CONCAT(users.nombre," ", users.apellidos)}}, {entidad: entidad.nombre}, {quien: quien.nombre, quien_key:quien._key} )';
        $item = $this->ArangoDB->Query($query);
        $item = $item[0];

        if($item->activo=="deleted") abort(404);

        //Emprendimiento seleccionado*/
        $emprendimiento = $this->ArangoDB->Query('FOR doc IN emprendimientos FILTER doc._key=="'.$aplicacion->emprendimiento_id.'" RETURN doc');
        $emprendimiento = $emprendimiento[0];


        // Datos del Perfil
        $data = $this->ArangoDB->Query('FOR doc IN perfiles FILTER doc.userKey == "'.$aplicacion->userKey.'" RETURN doc',true);
        $perfil = (count($data)>0)?$data[0]:[];
        $paises = $this->paises; // Paises
        $estados = $this->estados; // Estados
        $sexo = $this->sexo;
        $dedicas = $this->a_que_te_dedicas;

        // Cuenta
        $data = $this->ArangoDB->Query('FOR doc IN users FILTER doc._key == "'.$aplicacion->userKey.'" RETURN doc',true);
        $cuenta = (count($data)>0)?$data[0]:[];

        //Emprendimiento
        $data = $this->ArangoDB->Query('FOR doc IN emprendimientos FILTER doc._key=="'.$aplicacion->emprendimiento_id.'" RETURN doc', true);
        $emprendimiento_array = (count($data)>0)?$data[0]:[];

        // Obteniendo Industrias
        $industrias = $this->ArangoDB->Query('FOR doc IN industrias SORT doc.nombre ASC RETURN doc');

        // Obteniendo Etapas
        $etapas = $this->ArangoDB->Query('FOR doc IN etapas SORT doc.nombre ASC RETURN doc', true);
        $etapas = $this->ArangoDB->SelectFormat($etapas, '_key', 'nombre');

        //Niveles
        $nivel_tlr = $this->nivel_tlr;

        // Vehiculos de Inversion
        $vehiculos = $this->vehiculos_inversion;

        // Obteniendo Terminos
        $terminos = $this->ArangoDB->Query('FOR doc IN terminos RETURN doc', true);
        $terminos = $this->ArangoDB->SelectFormat($terminos, '_key', 'nombre');

        $enteraste = $this->como_te_enteraste;

        // Estudiando
        $estudiando = $this->estudiando;

        //Campus TEC
        $campus = $this->campus;

        //Preguntas de Catálogo
        $preg_cat = [];
        $preg_cat_aql = [];
        $preguntas_catalogo = [];
        foreach($item->preguntas as $pregunta){
            if($pregunta->tipo=="catalogos") $preg_cat[]=$pregunta->campo;
        }
        if(count($preg_cat)>0){
            $preg_cat = implode('","', $preg_cat);
            $preg_cat_aql = $this->ArangoDB->Query(' FOR preguntas IN preguntas_admin FILTER preguntas._key IN ["'.$preg_cat.'"] RETURN preguntas', true);
        }
        if(count($preg_cat_aql)>0){
            foreach($preg_cat_aql as $pregunta) {
                $preguntas_catalogo[$pregunta['_key']] = [
                    "_key"=>$pregunta['_key'],
                    "placeholder"=>isset($pregunta['placeholder'])?$pregunta['placeholder']:'',
                    "pregunta"=>isset($pregunta['pregunta'])?$pregunta['pregunta']:'',
                    "respuestas"=>isset($pregunta['respuestas'])?$pregunta['respuestas']:'',
                    "tipo"=>$pregunta['tipo'],
                    "categoria"=>$pregunta['categoria'],
                ];
            }
        }

        $respuestas_aplicacion  = json_decode(json_encode($aplicacion->preguntas), true);

        return view('panel.convocatorias.editar-aplicacion', compact('item', 'aplicacion','emprendimiento', 'errores',
            'perfil','paises','estados','sexo','dedicas','estudiando','campus',
            'cuenta','emprendimiento_array',
            'industrias','nivel_tlr','enteraste','etapas','vehiculos','terminos',
            'preguntas_catalogo', 'respuestas_aplicacion'
        ));
    }

    /**
     * Aplicando Convocatoria
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ArangoClientException
     * @throws ArangoException
     */
    public function Aplicacion($key, Request $request){
        $puede_aplicar = true; // validacion para aplicar a convocatoria

        //Obteniendo Convocatoria
        $query = '
        FOR convocatoria IN convocatorias 
            FOR usuario IN users
            FILTER convocatoria._key=="'.$key.'" AND usuario._key == convocatoria.responsable
            RETURN merge(convocatoria, {usuario: usuario})
        ';
        $item = $this->ArangoDB->Query($query);
        $item = $item[0];

        if($item->activo=="deleted") abort(404);

        //Obteniendo usuario
        $query = '
        FOR usuario IN users 
            FILTER usuario._key=="'.auth()->user()->_key.'"
            RETURN usuario
        ';
        $user = $this->ArangoDB->Query($query);
        $user = $user[0];

        // Si la convocatoria requiere un Emprendimiento
        if($item->quien!='6375236') {

            // Verificando que no se duplique el emprendimiento en la convicatoria
            $verificar = $this->VerificarEmeprendimiento($request->get('emprendimiento_id'), $key);

            if($verificar == false){

                //Emprendimiento seleccionado
                $emprendimiento = $this->ArangoDB->Query('FOR doc IN emprendimientos FILTER doc._key=="' . $request->get('emprendimiento_id') . '" AND doc.userKey == "' . auth()->user()->_key . '" RETURN doc');
                $emprendimiento = $emprendimiento[0];

                // Debe tener Datos Generales
                /*if($emprendimiento->module_datos==false){
                    $puede_aplicar = false;
                }

                // Debe tener Medios digitales
                if($emprendimiento->module_medios==false){
                    $puede_aplicar = false;
                }*/

                // Si quien peude aplicar es diferente a TODOS
                if($item->quien!='11536038') {

                    // Emprendimiento lanzado al mercado con o sin ventas
                    if ($item->quien == '6375309'){
                        if (isset($emprendimiento->lanzar_producto)) {
                            if ($emprendimiento->lanzar_producto != "Si") {
                                $puede_aplicar = false;
                            }
                        } else {
                            $puede_aplicar = false;
                        }
                    }else{
                        // Si la convocatoria requiere Ventas Registradas
                        /*if ($item->ventas == "Si") {
                            if (isset($emprendimiento->realizado_ventas)) {
                                if ($emprendimiento->realizado_ventas != "Si") {
                                    $puede_aplicar = false;
                                }
                            } else {
                                $puede_aplicar = false;
                            }
                        }*/
                    }

                    if ($item->quien == '6375265'){ // Emprendimiento tener un prototipo o MVP
                        if (isset($emprendimiento->prototipo_o_mvp)) {
                            if ($emprendimiento->prototipo_o_mvp != "Si") {
                                $puede_aplicar = false;
                            }
                        } else {
                            $puede_aplicar = false;
                        }
                    }

                    // Si la convocatoria requiere Clientes
                    /*if ($item->clientes == "Si") {
                        if(isset($emprendimiento->tiene_clientes)){
                            if($emprendimiento->tiene_clientes!="Si"){
                                $puede_aplicar = false;
                            }
                        }else{
                            $puede_aplicar = false;
                        }
                    }
                    // Si la convocatoria requiere Usuarios
                    if ($item->usuarios == "Si") {
                        if(isset($emprendimiento->tiene_usuarios)){
                            if($emprendimiento->tiene_usuarios!="Si"){
                                $puede_aplicar = false;
                            }
                        }else{
                            $puede_aplicar = false;
                        }
                    }
                    // Si la convocatoria requiere Información Financiera registrada
                    if ($item->financiera == "Si") {
                        if($emprendimiento->module_financiera==false){
                            $puede_aplicar = false;
                        }
                    }*/
                }
            }else{
                $puede_aplicar = false;
            }

        }else{
            // Verificando que no se duplique el emprendimiento en la convicatoria
            $verificar = $this->VerificarEmeprendimiento('', $key);
            if($verificar==true) abort(404);
            $emprendimiento = false;
        }

        if($puede_aplicar){
            $document = [];
            $document['userKey'] = auth()->user()->_key;
            $document['convocatoria_id'] = $key;
            $document['fecha_registro'] = time();
            $document['fecha_aprobacion'] = null;
            $document['aprobado'] = 1;
            $document['comentarios'] = "";
            $document['preguntas'] = $_POST;
            $document['fecha'] = date('Y-m-d H:i:s');
            $document['responsable_id'] = $item->responsable;
            // Si la convocatoria requiere emprendimiento se guarda del request
            $document['emprendimiento_id'] = ($item->quien!='6375236')?$request->get('emprendimiento_id'):null;

            // Creando Nuevo Registro
            $documentId = $this->ArangoDB->Save($this->collection, $document);
            //Creando Edge
            $this->ArangoDB->CreateEdge(['label' => 'hasConvocatoria', 'created_time'=>now()], 'hasConvocatoria', 'users/'.auth()->user()->_key, $documentId);

            ///////////////////////////////////////////////////////////                     ///////
            /// Actualizando Datos de Perfil, Cuenta y Emprendimiento
            //////////////////////////////////////////////////////////////////
            if(is_array($document['preguntas'])){
                // Cuenta de Usuario
                if(isset($document['preguntas']['cuenta'])) {
                    $this->ArangoDB->Update('users', 'users/' . auth()->user()->_key, $document['preguntas']['cuenta']);
                }
                if(isset($document['preguntas']['usuario'])) {
                // Perfil
                    $data_update = $this->ArangoDB->Query('FOR doc IN perfiles FILTER doc.userKey == "'.auth()->user()->_key.'" RETURN doc._key');
                    $this->ArangoDB->Update('perfiles', 'perfiles/'.$data_update[0], $document['preguntas']['usuario']);
                }
                if(isset($document['preguntas']['emprendimiento'])) {
                    // Emprendimiento
                    $this->ArangoDB->Update('emprendimientos', 'emprendimientos/' . $document['emprendimiento_id'], $document['preguntas']['emprendimiento']);
                }
            }
            //////////////////////////////////////////////////////////////////

            // Enviando Mail al Administrador
            $aplicacion_key = explode('/',$documentId);
            $document['responsable_email'] = $item->usuario->email;
            $document['usuario'] = $user->nombre.' '.$user->apellidos;
            $document['usuario_email'] = $user->email;
            $document['aplicacion_key'] = $aplicacion_key[1];
            $document['convocatoria_nombre'] = $item->nombre;
            Mail::to($document['responsable_email'])->send(new SolicitudAdmin($document));
        }

        return view('panel.convocatorias.aplicacion', compact('puede_aplicar','item','emprendimiento'));
    }

    /**
     * Actualizando Aplicacion
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ArangoClientException
     * @throws ArangoException
     */
    public function UpdateAplicacion($key, Request $request){

        // Aplicacion
        $aplicacion = $this->ArangoDB->Query('FOR doc IN usuario_convocatoria FILTER doc._key=="'.$key.'" RETURN doc');
        $aplicacion = $aplicacion[0];

        //Obteniendo Convocatoria
        //Obteniendo Convocatoria
        $query = '
        FOR convocatoria IN convocatorias 
            FOR usuario IN users
            FILTER convocatoria._key=="'.$aplicacion->convocatoria_id.'" AND usuario._key == convocatoria.responsable
            RETURN merge(convocatoria, {usuario: usuario})
        ';
        $item = $this->ArangoDB->Query($query);
        $item = $item[0];

        if($item->activo=="deleted") abort(404);

        //Obteniendo usuario
        $query = '
        FOR usuario IN users 
            FILTER usuario._key=="'.$aplicacion->userKey.'"
            RETURN usuario
        ';
        $user = $this->ArangoDB->Query($query);
        $user = $user[0];

        //Emprendimiento seleccionado
        $emprendimiento = $this->ArangoDB->Query('FOR doc IN emprendimientos FILTER doc._key=="'.$aplicacion->emprendimiento_id.'" RETURN doc');
        $emprendimiento = $emprendimiento[0];

        if($aplicacion->aprobado==1 || $aplicacion->aprobado==4){
            $document = [];
            $document['preguntas'] = $_POST;
            $document['fecha_update'] = date('Y-m-d H:i:s');

            // Actualizando Aplicacion
            $this->ArangoDB->Update('usuario_convocatoria', 'usuario_convocatoria/'.$key, $document);

            //////////////////////////////////////////////////////////////////
            /// Actualizando Datos de Perfil, Cuenta y Emprendimiento
            //////////////////////////////////////////////////////////////////
            if(is_array($document['preguntas'])){
                // Cuenta de Usuario
                if(isset($document['preguntas']['cuenta'])) {
                    $this->ArangoDB->Update('users', 'users/' .$aplicacion->userKey, $document['preguntas']['cuenta']);
                }
                if(isset($document['preguntas']['usuario'])) {
                    // Perfil
                    $data_update = $this->ArangoDB->Query('FOR doc IN perfiles FILTER doc.userKey == "'.$aplicacion->userKey.'" RETURN doc._key');
                    $this->ArangoDB->Update('perfiles', 'perfiles/'.$data_update[0], $document['preguntas']['usuario']);
                }
                if(isset($document['preguntas']['emprendimiento'])) {
                    // Emprendimiento
                    $this->ArangoDB->Update('emprendimientos', 'emprendimientos/' . $aplicacion->emprendimiento_id, $document['preguntas']['emprendimiento']);
                }
            }
            //////////////////////////////////////////////////////////////////

            // Enviando Mail al Administrador
            $document['responsable_email'] = $item->usuario->email;
            $document['usuario'] = $user->nombre.' '.$user->apellidos;
            $document['usuario_email'] = $user->email;
            $document['_key'] = $aplicacion->_key;
            $document['convocatoria_nombre'] = $item->nombre;
            Mail::to($document['responsable_email'])->send(new UpdateSolicitudAdmin($document));

            $actualizada = true;
        }else{
            $actualizada = false;
        }

        return view('panel.convocatorias.aplicacion_actualizada', compact('item','actualizada'));
    }

    /**
     * Verificar que Emprendimiento no exista en convocatoria
     * @param $emprendimiento_id
     * @param $convocatoria_id
     * @return bool
     * @throws ArangoException
     */
    public function VerificarEmeprendimiento($emprendimiento_id='', $convocatoria_id){
        if($emprendimiento_id!='') {
            $item = $this->ArangoDB->Query('FOR doc IN ' . $this->collection . ' FILTER doc.userKey=="' . auth()->user()->_key . '" AND doc.emprendimiento_id=="' . $emprendimiento_id . '" AND doc.convocatoria_id == "' . $convocatoria_id . '" AND doc.aprobado!=2 RETURN doc');
        }else{
            $item = $this->ArangoDB->Query('FOR doc IN ' . $this->collection . ' FILTER doc.userKey=="' . auth()->user()->_key . '" AND doc.emprendimiento_id==null AND doc.convocatoria_id == "' . $convocatoria_id . '" AND doc.aprobado!=2 RETURN doc');
        }
        return (count($item)>0)?true:false;
    }

    /**
     * Regresar variables para paginacion
     * @return array
     */
    public function PaginationQuery(){
        return ['page'=>$this->page, 'perPage' => $this->perPage, 'path'=>$this->path];
    }

}