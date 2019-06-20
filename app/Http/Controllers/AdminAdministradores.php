<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use Illuminate\Http\Request;
use App\Repositories\ArangoDB;
use ArangoDBClient\Exception as ArangoException;
use ArangoDBClient\ClientException as ArangoClientException;
use ArangoDBClient\ServerException as ArangoServerException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class AdminAdministradores extends Controller
{
    protected $DocumentHandler;
    protected $CollectionHandler;
    protected $ArangoDB;
    private $collection = 'users';
    private $controller = 'AdminAdministradores';
    private $page;
    private $path;
    private $perPage = 25;

    /**
     * Administradores constructor.
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
     * Listado de Administradores
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function Index(Request $request){
        $data = $this->ArangoDB->Query('FOR u IN '.$this->collection.' FOR r IN roles FILTER u.isAdmin==1 AND r._key==u.rol_id SORT u.nombre ASC LIMIT '.($this->perPage*($this->page-1)).', '.$this->perPage.'  RETURN merge(u, {rol: r})');
        if($request->get('total')!=''){
            $total = $request->get('total');
        }else{
            $total = $this->ArangoDB->Query('FOR u IN '.$this->collection.' FILTER u.isAdmin==1 COLLECT WITH COUNT INTO length RETURN length');
            $total = (int)$total[0];
        }
        $datos = $this->ArangoDB->Pagination($data, $total, $this->PaginationQuery());
        return view('admin.admins.list', compact('datos','total'));
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
     * Guardar datos de la Administradores
     * @param AdminRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ArangoClientException
     * @throws ArangoException
     */
    public function Save(AdminRequest $request){

            $document = [];
            $document['nombre'] = $request->get('nombre');
            $document['apellidos'] = $request->get('apellidos');
            $document['rol_id'] = $request->get('rol_id');
            $document['active'] = ($request->get('active')=='')?0:1;
            if($request->get('password')!='') $document['password'] = Hash::make($request->get('password'));

            // Creando Nuevo Registro
            if($request->get('id')==''){
                $document['isAdmin'] = 1;
                $document['validated'] = 1;
                $document['email'] = $request->get('email');

                $total = $this->ArangoDB->Query('FOR u IN '.$this->collection.' FILTER u.email=="'.$request->get('email').'" COLLECT WITH COUNT INTO length RETURN length');
                $total = (int) $total[0];
                if($total<1){
                    $documentId = $this->ArangoDB->Save($this->collection, $document);
                    Session::flash('status_success', 'Registro Agregado');
                }else{
                    Session::flash('status_error', 'Ya existe un usuario con ese email, por favor usar otro email.');
                    return redirect()->action($this->controller.'@New')->withInput();
                }
            }else{
                // Actualizando Registro
                $documentId = $this->ArangoDB->Update($this->collection, $this->collection.'/'.$request->get('id'), $document);
                Session::flash('status_success', 'Registro Actualizado');
            }

            return redirect()->action($this->controller.'@Index');
    }

    /**
     * Borrar registro de Administradores
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