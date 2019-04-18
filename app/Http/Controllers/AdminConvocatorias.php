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
    private $perPage = 25;
    private $campos_usuario =  [
        'Datos personales' => [
            'biografia'         =>'Biografía corta',
            'sexo'              =>'Sexo',
            'fecha_nacimiento'  =>'Fecha de Nacimiento',
            'a_que_se_dedica'   =>'¿A qué te dedicas?',
            'linkedin'          =>'Perfil Linkedin',
            'pais'              =>'País de residencia',
            'estado'            =>'Estado/Región',
            'ciudad'            =>'Ciudad',
            'biografia'         =>'Biografía'
        ],
        'Estudios'=> [
            'actualmente_cursando_carrera'  =>'¿Te encuentras actualmente cursando tu carrera profesional? ',
            'universidad'                   =>'Universidad donde cursaste tus estudios o estás actualmente estudiando',
            'universidad_otra'              =>'Otra',
            'campus'                        =>'Campus',
            'matricula'                     =>'Matrícula',
            'fecha_graduacion'              =>'Fecha en la que te graduaste o te vas a graduar',
        ]
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
        $query = '
        FOR convocatoria IN convocatorias
            FOR users IN users
                FOR entidad IN entidades
                    FILTER convocatoria.responsable == users._key AND convocatoria.entidad  == entidad._key
                    SORT convocatoria._key ASC LIMIT '.($this->perPage*($this->page-1)).', '.$this->perPage.'
                    RETURN merge(convocatoria, {responsable: {username: users.username, nombre: CONCAT(users.nombre," ", users.apellidos)}}, {entidad: entidad.nombre} )
        ';
        $data = $this->ArangoDB->Query($query);
        if($request->get('total')!=''){
            $total = $request->get('total');
        }else{
            $total = $this->ArangoDB->Query( '
            FOR convocatoria IN convocatorias
            FOR users IN users
                FOR entidad IN entidades
                    FILTER convocatoria.responsable == users._key AND convocatoria.entidad == entidad._key
                    SORT convocatoria._key ASC COLLECT WITH COUNT INTO length RETURN length');
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

        return view('admin.'.$this->collection.'.new', compact('entidades','quien','usuarios','campos_usuario','preguntas_catalogo'));
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
        $preguntas_catalogo = [];
        $preguntas = $this->ArangoDB->Query('FOR doc IN preguntas_admin RETURN doc', false);
        foreach ($preguntas as $preg){
            $preguntas_catalogo[$preg->categoria][] = $preg;
        }

        /************************/
        return view('admin.'.$this->collection.'.edit', compact('item','entidades','quien','usuarios','campos_usuario','preguntas_catalogo'));
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
        $document['preguntas'] = $request->get('preguntas');

        // Creando Nuevo Registro
        if($request->get('id')==''){
            $document['created_at'] = date('Y-m-d'); // Agregando fecha de creacion
            $documentId = $this->ArangoDB->Save($this->collection, $document);
            $key = str_replace($this->collection.'/','', $documentId);
            Session::flash('status_success', 'Registro Agregado');
        }else{
        // Actualizando Registro
            $documentId = $this->ArangoDB->Update($this->collection, $this->collection.'/'.$request->get('id'), $document);
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
}