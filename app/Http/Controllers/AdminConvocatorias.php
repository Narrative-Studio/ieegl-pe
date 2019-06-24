<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConvocatoriasRequest;
use Illuminate\Http\Request;
use App\Repositories\ArangoDB;
use ArangoDBClient\Exception as ArangoException;
use ArangoDBClient\ClientException as ArangoClientException;
use ArangoDBClient\ServerException as ArangoServerException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;


class AdminConvocatorias extends Controller
{
    protected $DocumentHandler;
    protected $CollectionHandler;
    protected $ArangoDB;
    private $collection = 'convocatorias';
    private $controller = 'AdminConvocatorias';
    private $page;
    private $path;
    private $perPage = 50;
    private $campos_cuenta = [
        'Datos de cuenta' => [
            'nombre'        =>'Nombre',
            'apellidos'     =>'Apellidos',
            'email'         =>'Correo Electrónico',
            'telefono'      =>'Celular',
        ],
    ];
    private $campos_usuario =  [
        'Datos personales' => [
            'biografia'         =>'Biografía',
            'sexo'              =>'Sexo',
            'fecha_nacimiento'  =>'Fecha de Nacimiento',
            'a_que_se_dedica'   =>'¿A qué te dedicas?',
            'linkedin'          =>'Perfil Linkedin',
            'pais'              =>'País de residencia',
            'estado'            =>'Estado/Región',
            'ciudad'            =>'Ciudad',
        ],
        'Estudios'=> [
            'actualmente_cursando_carrera'  =>'¿Te encuentras actualmente cursando tu carrera profesional? ',
            'campus'                        =>'Campus',
            'matricula'                     =>'Matrícula'
        ]
    ];
    private $campos_emprendimiento =  [
        'Datos Generales' => [
            'nombre'         =>'Nombre comercial del emprendimiento',
            'fecha_fundacion'  =>'Fecha de fundación de tu emprendimiento',
            'descripcion'   =>'Descripción del Emprendimiento',
            'pais'   =>'País donde está establecido',
            'ciudad'          =>'Ciudad',
            'industria_o_sector'              =>'Industria o Sector de Emprendimiento',
            'etapa_emprendimiento'            =>'¿En qué etapa se encuentra tu Emprendimiento?',
            'mercado_cliente'            =>'¿A qué mercado/cliente atiende tu Emprendimiento?',
            'problema_soluciona'            =>'¿Qué problema le soluciona tu Emprendimiento a tu mercado/cliente?',
            'competencia'            =>'¿Quién es tu competencia? ',
            'diferencia_competencia'            =>'¿Cómo te diferencías de tu competencia?',
            'diferenciador_modelo_negocio'            =>'¿Cuál es el gran diferenciador de tu modelo de negocio?',
            'investigacion_desarrollo'            =>'¿Actualmente, tu Emprendimiento lleva un proceso de investigación y desarrollo basado en ciencia y tecnología?',
            'numero_socios'            =>'Número de socios fundadores en tu emprendimiento',
        ],
        'Medios Digitales'=> [
            'sitio_web'  =>'Sitio Web de tu Emprendimiento',
            'red_social' =>'Red social mas utilizada por tu Emprendimiento',
            'video' =>'Video de tu Emprendimiento',
            'logo_file' => 'Logo de tu Emprendimiento',
            'presentacion_file' => 'Presentación o pitch deck',
        ],
        'Mercado'=> [
            'tiene_clientes'  =>'¿Tienes clientes?',
            'clientes_activos'  =>'Si tienes clientes, ¿Cuántos están activos en tu emprendimiento?',
            'tiene_usuarios'  =>'¿Tienes usuarios? ',
            'usuarios_activos'  =>'Si tienes usuarios, ¿Cuántos están activos en tu emprendimiento?',
        ],
        'Inversión'=> [
            'levantado_capital'  =>'¿Has levantado capital? ',
            'recibido_capital_cuanto'  =>'Si has levandato capital, ¿Cuánto ha sido? (USD)',
            'recibido_inversion'  =>'¿Has recibido inversión?',
            'recibido_inversion_cuanto'  =>'Si has recibido inversión, ¿Cuánto ha sido? (USD)',
            'buscando_capital'  =>'¿Actualmente estás buscando capital?',
            'capital_cuanto'  =>'Si estas buscando capital, ¿Cuánto capital estás buscando? (USD)',
        ],
        'Información Financiera'=> [
            'lanzar_producto'  =>'¿Ya lanzaste tu producto/servicio al mercado?',
            'fecha_lanzamiento'  =>'Si ya lanzaste tu producto, ¿En qué fecha fue?',
            'patente_ip'  =>'¿Tienes una Patente o IP de tu producto o servicio?',
            'realizado_ventas'  =>'¿Has tenido ventas?',
            'socio_exit_empresa'  =>'¿Alguno de tus socios ha tenido un "exit" o ha venido de una empresa?',
            'cedula_file' => 'Cédula de Identificación Fiscal',
        ],
    ];

    /**
     * Convocatoria constructor.
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
     * Listado de Convocatoria
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function Index(Request $request){
        $query_user = (auth()->user()->rol_id != 7931855)?' convocatoria.responsable == "'.auth()->user()->_key.'" AND ':'';
        $query_activo = ($request->get('status')!='')?' convocatoria.activo== "'.$request->get('status').'" AND ':'';
        $query = '
        FOR convocatoria IN convocatorias
            FOR users IN users
                FOR entidad IN entidades
                  LET aplicaciones = (
                    FOR a IN usuario_convocatoria
                      FILTER a.convocatoria_id == convocatoria._key
                      COLLECT WITH COUNT INTO length RETURN length
                    )            
                    FILTER '.$query_user.$query_activo.' convocatoria.responsable == users._key AND convocatoria.entidad  == entidad._key AND convocatoria.activo != "deleted"
                    SORT convocatoria.created_at DESC LIMIT '.($this->perPage*($this->page-1)).', '.$this->perPage.'
                    RETURN merge(convocatoria, {responsable: {username: users.username, nombre: CONCAT(users.nombre," ", users.apellidos)}}, {entidad: entidad.nombre}, {total: aplicaciones[0]})
        ';
        $data = $this->ArangoDB->Query($query);
        if($request->get('total')!=''){
            $total = $request->get('total');
        }else{
            $total = $this->ArangoDB->Query( '
            FOR convocatoria IN convocatorias
                FOR users IN users
                    FOR entidad IN entidades
                        FILTER '.$query_user.$query_activo.' convocatoria.responsable == users._key AND convocatoria.entidad == entidad._key AND convocatoria.activo != "deleted"
                        SORT convocatoria.created_at DESC COLLECT WITH COUNT INTO length RETURN length');
            $total = (int)$total[0];
        }
        $datos = $this->ArangoDB->Pagination($data, $total, $this->PaginationQuery());
        return view('admin.'.$this->collection.'.list', compact('datos','total'));
    }

    /**
     * Crear nueva Convocatoria
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function New(){

        // Obteniendo Entidades
        $entidades = $this->ArangoDB->Query('FOR doc IN entidades RETURN doc', true);
        $entidades = $this->ArangoDB->SelectFormat($entidades, '_key', 'nombre');

        // Obteniendo Quien Convoca
        $quien = $this->ArangoDB->Query('FOR doc IN quien RETURN doc', true);
        $quien = $this->ArangoDB->SelectFormat($quien, '_key', 'nombre');

        /***** Preguntas ********/
        $campos_usuario = $this->campos_usuario;
        $campos_cuenta = $this->campos_cuenta;
        $campos_emprendimiento = $this->campos_emprendimiento;
        $preguntas_catalogo = [];
        $preguntas = $this->ArangoDB->Query('FOR doc IN preguntas_admin RETURN doc', false);
        foreach ($preguntas as $preg){
            $preguntas_catalogo[$preg->categoria][] = $preg;
        }

        // Obteniendo Usuarios Responsables
        $usuarios = $this->ArangoDB->Query('
        FOR doc IN users
            FOR rol IN roles
                FILTER doc.isAdmin==1 AND rol._key==doc.rol_id AND rol.permisos LIKE "%solicitudes%"
                RETURN doc', true);
        $usuarios = $this->ArangoDB->SelectFormat($usuarios, '_key', 'nombre');

        return view('admin.'.$this->collection.'.new', compact('entidades','quien','usuarios','campos_usuario','preguntas_catalogo','campos_emprendimiento','campos_cuenta'));
    }

    /**
     * Editar la Convocatoria
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function Edit($id){
        try{
            $item = $this->ArangoDB->GetById($this->collection, $this->collection.'/'.$id);

            if($item->activo=="deleted") abort(404);

            // Obteniendo Entidades
            $entidades = $this->ArangoDB->Query('FOR doc IN entidades RETURN doc', true);
            $entidades = $this->ArangoDB->SelectFormat($entidades, '_key', 'nombre');

            // Obteniendo Quien Convoca
            $quien = $this->ArangoDB->Query('FOR doc IN quien RETURN doc', true);
            $quien = $this->ArangoDB->SelectFormat($quien, '_key', 'nombre');

            // Obteniendo Usuarios Responsables
            $usuarios = $this->ArangoDB->Query('
            FOR doc IN users
                FOR rol IN roles
                    FILTER doc.isAdmin==1 AND rol._key==doc.rol_id AND rol.permisos LIKE "%solicitudes%"
                    RETURN doc', true);
            $usuarios = $this->ArangoDB->SelectFormat($usuarios, '_key', 'nombre');

        } catch (ArangoServerException $e) {
            Session::flash('status_error', $e->getMessage());
            return redirect()->action($this->controller.'@Index');
        }
        if(!$item){
            return redirect()->action($this->controller.'@Index')->with('status_error','El registro no existe');
        }
        /***** Preguntas ********/
        $campos_usuario = $this->campos_usuario;
        $campos_cuenta = $this->campos_cuenta;
        $campos_emprendimiento = $this->campos_emprendimiento;
        $preguntas_catalogo = [];
        $preguntas = $this->ArangoDB->Query('FOR doc IN preguntas_admin RETURN doc', false);

        if($preguntas) {
            foreach ($preguntas as $preg) {
                $preguntas_catalogo[$preg->categoria][] = $preg;
            }
        }

        if(isset($item->preguntas)){
            $array = json_decode(json_encode($item->preguntas), true);
            ksort($array);
            $json = str_replace('\r\n', '|', json_encode($array));
            $json = preg_replace('/\\\t/', '', $json);
        }else{
            $json = '';
        }

        /************************/
        return view('admin.'.$this->collection.'.edit', compact('item','entidades','quien','usuarios','campos_usuario','preguntas_catalogo','json','campos_emprendimiento','campos_cuenta'));
    }

    /**
     * Guardar datos de la Convocatoria
     * @param ConvocatoriasRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ArangoClientException
     * @throws ArangoException
     */
    public function Save(ConvocatoriasRequest $request){

        //dd($request->get('preguntas'));exit();
        $document = [];
        $document['nombre'] = $request->get('nombre');
        $document['descripcion'] = $request->get('descripcion');
        $document['descripcion_corta'] = $request->get('descripcion_corta');
        $document['entidad'] = $request->get('entidad');
        $document['quien'] = $request->get('quien');
        $document['fecha_inicio_convocatoria'] = strtotime($request->get('fecha_inicio_convocatoria'));
        $document['fecha_fin_convocatoria'] = strtotime($request->get('fecha_fin_convocatoria'));
        $document['fecha_inicio_evento'] = strtotime($request->get('fecha_inicio_evento'));
        $document['fecha_fin_evento'] = strtotime($request->get('fecha_fin_evento'));
        $document['responsable'] = $request->get('responsable');
        $document['ventas'] = $request->get('ventas');
        $document['clientes'] = $request->get('clientes');
        $document['usuarios'] = $request->get('usuarios');
        $document['financiera'] = $request->get('financiera');
        $document['comentarios'] = $request->get('comentarios');
        $document['pago_iframe'] = $request->get('pago_iframe');
        $document['pago'] = $request->get('pago');
        $document['activo'] = $request->get('activo');

        // Creando Nuevo Registro
        if($request->get('id')==''){
            $document['created_at'] = date('Y-m-d H:i:s'); // Agregando fecha de creacion
            $document['preguntas'] = $request->get('preguntas');
            $documentId = $this->ArangoDB->Save($this->collection, $document);
            $key = str_replace($this->collection.'/','', $documentId);
            Session::flash('status_success', 'Registro Agregado');
        }else{
        // Actualizando Registro
            $documentId = $this->ArangoDB->Update($this->collection, $this->collection.'/'.$request->get('id'), $document);
            $preguntas['preguntas'] = $request->get('preguntas');
            $documentId = $this->ArangoDB->Update($this->collection, $this->collection.'/'.$request->get('id'), $preguntas);
            $key = $request->get('id');
            Session::flash('status_success', 'Registro Actualizado');
        }

        // Guardando Logo del Emprendimiento
        if($_FILES['imagen']['size'] != 0 && $_FILES['imagen']['error'] == 0){
            $img = Image::make($_FILES['imagen']['tmp_name']);
            $img->save(public_path('/convocatorias_pics/imagen_'.$key .'.jpg', 100));
        }

        return redirect()->action($this->controller.'@Index');
    }

    /**
     * Borrar registro de Convocatoria
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws ArangoException
     */
    public function Delete($id){
        try {
            $document['activo'] = "deleted";
            $this->ArangoDB->Update($this->collection, $this->collection.'/'.$id, $document);
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
}