<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use Illuminate\Http\Request;
use App\Repositories\ArangoDB;
use ArangoDBClient\Exception as ArangoException;
use ArangoDBClient\ClientException as ArangoClientException;
use ArangoDBClient\ServerException as ArangoServerException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;


class AdminReportes extends Controller
{
    protected $DocumentHandler;
    protected $CollectionHandler;
    protected $ArangoDB;
    private $collection = 'users';
    private $controller = 'AdminReportes';
    private $page;
    private $path;
    private $perPage = 25;

    /**
     * Reportes constructor.
     * @param ArangoDB $ArangoDB
     */
    public function __construct(ArangoDB $ArangoDB)
    {
        $this->ArangoDB = $ArangoDB;
        ArangoException::enableLogging();
        $this->middleware('auth:admin');
    }

    /**
     *  Reporte Usuarios Emprendimientos
     */
    public function UsuariosEmprendimientos(){
        return view('admin.reportes.usuarios-emprendimientos');
    }

    /**
     * Reporte Usuarios Emprendimientos AJAX
     * @param Request $request
     * @return string
     * @throws ArangoException
     */
    public function UsuariosEmprendimientosAjax(Request $request){

        $search_txt = "";
        $offset = $request->get('offset');
        $limit = $request->get('limit');
        $search = trim($request->get('search'));
        $sort = ($request->get('sort')!='')?$request->get('sort'):'nombre';
        $order = trim($request->get('order'));

        if($search!='') $search_txt = 'AND (LOWER(CONCAT(u.nombre," ",u.apellidos)) LIKE "%'.strtolower($search).'%" OR LOWER(u.email) LIKE "%'.strtolower($search).'%")';

        $data = $this->ArangoDB->Query("
            FOR u IN users 
                FILTER u._key NOT IN (FOR emp IN emprendimientos COLLECT keys = emp.userKey RETURN keys) AND u.validated==1 AND u.active==1 AND u.isAdmin==0 $search_txt
                LIMIT $offset,$limit
                SORT u.$sort $order
            RETURN {'id':u._key, 'nombre':CONCAT(u.nombre,' ',u.apellidos), 'email':u.email}", true);

        $data_total = $this->ArangoDB->Query("
            FOR u IN users 
                FILTER u._key NOT IN (FOR emp IN emprendimientos COLLECT keys = emp.userKey RETURN keys) AND u.validated==1 AND u.active==1 AND u.isAdmin==0 $search_txt
                COLLECT WITH COUNT INTO length
            RETURN length", true);

        $datos['total'] = $data_total[0][0];
        $datos['rows'] = $data;
        return json_encode($datos);
    }

    /**
     * Crear nuevo Administrador
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function New(){

        // Obteniendo Roles
        $roles = $this->ArangoDB->Query('FOR doc IN roles RETURN doc', true);
        $roles = $this->ArangoDB->SelectFormat($roles, '_key', 'nombre');

        return view('admin.admins.new',compact('roles'));
    }

    /**
     * Editar Administrador
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function Edit($id){
        try{
            $item = $this->ArangoDB->GetById($this->collection, $this->collection.'/'.$id);
        } catch (ArangoServerException $e) {
            Session::flash('status_error', $e->getMessage());
            return redirect()->action($this->controller.'@Index');
        }
        if(!$item){
            return redirect()->action($this->controller.'@Index')->with('status_error','El registro no existe');
        }
        // Obteniendo Roles
        $roles = $this->ArangoDB->Query('FOR doc IN roles RETURN doc', true);
        $roles = $this->ArangoDB->SelectFormat($roles, '_key', 'nombre');

        return view('admin.admins.edit', compact('item','roles'));
    }

    /**
     * Guardar datos de la Reportes
     * @param AdminRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ArangoClientException
     * @throws ArangoException
     */
    public function Save(AdminRequest $request){

        $document = [];
        $document['nombre'] = $request->get('nombre');
        $document['apellidos'] = $request->get('apellidos');
        $document['email'] = $request->get('email');
        $document['rol_id'] = $request->get('rol_id');
        $document['active'] = ($request->get('active')=='')?0:1;
        $document['isAdmin'] = 1;
        if($request->get('password')!='') $document['password'] = Hash::make($request->get('password'));

        // Creando Nuevo Registro
        if($request->get('id')==''){
            $documentId = $this->ArangoDB->Save($this->collection, $document);
            Session::flash('status_success', 'Registro Agregado');
        }else{
        // Actualizando Registro
            $documentId = $this->ArangoDB->Update($this->collection, $this->collection.'/'.$request->get('id'), $document);
            Session::flash('status_success', 'Registro Actualizado');
        }

        return redirect()->action($this->controller.'@Index');
    }

    /**
     * Borrar registro de Reportes
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