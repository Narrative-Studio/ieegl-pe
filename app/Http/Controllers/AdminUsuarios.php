<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use Illuminate\Http\Request;
use App\Repositories\ArangoDB;
use ArangoDBClient\Exception as ArangoException;
use ArangoDBClient\ClientException as ArangoClientException;
use ArangoDBClient\ServerException as ArangoServerException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Session;


class AdminUsuarios extends Controller
{
    protected $DocumentHandler;
    protected $CollectionHandler;
    protected $ArangoDB;
    private $collection = 'users';
    private $controller = 'AdminUsuarios';
    private $page;
    private $path;
    private $perPage = 50;

    /**
     * Industrias constructor.
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
     * Listado de Industrias
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function Index(Request $request){
        $search = '';
        if($request->get('q')!=''){
            $search = ' AND (LOWER(CONCAT(u.nombre," ",u.apellidos)) LIKE "%'.strtolower($request->get('q')).'%" OR LOWER(u.email) LIKE "%'.strtolower($request->get('q')).'%") ';
        }

        $data = $this->ArangoDB->Query("FOR u IN ".$this->collection." FILTER u.isAdmin==0 $search SORT u.nombre ASC LIMIT ".($this->perPage*($this->page-1)).", ".$this->perPage." RETURN u");
        if($request->get('total')!=''){
            $total = $request->get('total');
        }else{
            $total = $this->ArangoDB->Query("FOR u IN ".$this->collection." FILTER u.isAdmin==0 $search COLLECT WITH COUNT INTO length RETURN length");
            $total = (int)$total[0];
        }
        $datos = $this->ArangoDB->Pagination($data, $total, $this->PaginationQuery());
        return view('admin.'.$this->collection.'.list', compact('datos','total'));
    }

    /**
     * Crear nueva Industrias
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function New(){
        return view('admin.'.$this->collection.'.new');
    }

    /**
     * Editar la Industrias
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
        return view('admin.'.$this->collection.'.edit', compact('item'));
    }

    /**
     * Guardar datos de la Industrias
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ArangoClientException
     * @throws ArangoException
     */
    public function Save(UsuarioRequest $request){

        $document = [];
        $document['nombre'] = $request->get('nombre');
        $document['apellidos'] = $request->get('nombre');
        $document['email'] = $request->get('email');
        $document['telefono'] = $request->get('telefono');
        $document['validated'] = ($request->get('validated')=='')?0:1;
        $document['active'] = ($request->get('active')=='')?0:1;

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
     * Borrar registro de Industrias
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