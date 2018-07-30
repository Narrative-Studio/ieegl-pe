<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConvocatoriasRequest;
use Illuminate\Http\Request;
use App\Repositories\ArangoDB;
use ArangoDBClient\Exception as ArangoException;
use ArangoDBClient\ClientException as ArangoClientException;
use ArangoDBClient\ServerException as ArangoServerException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;


class AdminRoles extends Controller
{
    protected $DocumentHandler;
    protected $CollectionHandler;
    protected $ArangoDB;
    private $collection = 'roles';
    private $controller = 'AdminRoles';
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
        ArangoException::enableLogging();
        $this->middleware('auth:admin');
        $this->page = LengthAwarePaginator::resolveCurrentPage('page');
        $this->path = LengthAwarePaginator::resolveCurrentPath();
    }

    /**
     * Listado de Roles
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function Index(Request $request){
        AdminRoles::CheckAccess('roles');
        $query = 'FOR doc IN '.$this->collection.' return doc';
        $data = $this->ArangoDB->Query($query);
        if($request->get('total')!=''){
            $total = $request->get('total');
        }else{
            $total = $this->ArangoDB->Query('FOR doc IN '.$this->collection.' COLLECT WITH COUNT INTO length RETURN length');
            $total = (int)$total[0];
        }
        $datos = $this->ArangoDB->Pagination($data, $total, $this->PaginationQuery());
        return view('admin.roles.list', compact('datos','total'));
    }

    /**
     * Nuevo Rol
     * @return mixed
     */
    public function New(){
        AdminRoles::CheckAccess('roles');
        $permisos = [];
        return view('admin.roles.new', compact('permisos'));
    }

    public function Edit($id){
        AdminRoles::CheckAccess('roles');
        $item = $this->ArangoDB->GetById($this->collection, $this->collection.'/'.$id);
        $permisos = explode(',', $item->permisos);
        return view('admin.roles.edit', compact('item','permisos'));
    }

    public function Save(Request $request){
        AdminRoles::CheckAccess('roles');
        $document = [];
        $document['nombre'] = $request->get('nombre');
        $document['permisos'] = implode(',',$request->get('permisos'));

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

    static function CheckAccess($section)
    {
        if (!Auth::user()) {
            App::abort(403, 'Entrada a Admin Prohibida');
        }

        if (Auth::user()->rol_id != '7931855'){ // Si el usuario pertenece a los administradores dejarlo pasar
            $per = explode(',', session('permisos'));
            if (!in_array($section, $per)) {
                App::abort(403, 'Sin Permisos');
            }
        }
    }

    static function getAccess($section){
        if(\session('permisos')==''){
            $ArangoDB = new \App\Repositories\ArangoDB;
            $item = $ArangoDB->GetById('roles', 'roles/'.\auth()->user()->rol_id);
            \session(['permisos' => $item->permisos]);
        }
        if (Auth::user()->rol_id != '7931855'){ // Si el usuario pertenece a los administradores dejarlo pasar
            $per = explode(',', \session('permisos'));
            return (!in_array($section, $per))?false:true;
        }else{
            return true;
        }
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
}