<?php

namespace App\Http\Controllers;

use App\Http\Requests\PreguntasRequest;
use Illuminate\Http\Request;
use App\Repositories\ArangoDB;
use ArangoDBClient\Exception as ArangoException;
use ArangoDBClient\ClientException as ArangoClientException;
use ArangoDBClient\ServerException as ArangoServerException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Session;


class AdminPreguntas extends Controller
{
    protected $DocumentHandler;
    protected $CollectionHandler;
    protected $ArangoDB;
    private $collection = 'preguntas_admin';
    private $controller = 'AdminPreguntas';
    private $page;
    private $path;
    private $perPage = 25;

    /**
     * Preguntas constructor.
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
     * Listado de Preguntas
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function Index(Request $request){
        $data = $this->ArangoDB->Query('FOR u IN '.$this->collection.' SORT u._key ASC LIMIT '.($this->perPage*($this->page-1)).', '.$this->perPage.'  RETURN u');
        if($request->get('total')!=''){
            $total = $request->get('total');
        }else{
            $total = $this->ArangoDB->Query('FOR doc IN '.$this->collection.' COLLECT WITH COUNT INTO length RETURN length');
            $total = (int)$total[0];
        }
        $datos = $this->ArangoDB->Pagination($data, $total, $this->PaginationQuery());
        $categorias = $this->categoria_preguntas;
        return view('admin.'.$this->collection.'.list', compact('datos','total','categorias'));
    }

    /**
     * Crear nueva Preguntas
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function New(){
        $categorias = $this->categoria_preguntas;
        return view('admin.'.$this->collection.'.new', compact('categorias'));
    }

    /**
     * Editar la Preguntas
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
        $categorias = $this->categoria_preguntas;
        return view('admin.'.$this->collection.'.edit', compact('item','categorias'));
    }

    /**
     * Guardar datos de la Preguntas
     * @param PreguntasRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ArangoClientException
     * @throws ArangoException
     */
    public function Save(PreguntasRequest $request){

        $document = [];
        $document['pregunta'] = $request->get('pregunta');
        $document['descripcion'] = $request->get('descripcion');
        $document['tipo'] = $request->get('tipo');
        $document['categoria'] = $request->get('categoria');
        $document['respuestas'] = ($document['tipo']=='text' || $document['tipo'] =='textarea')?'':$request->get('respuestas');

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
     * Borrar registro de Preguntas
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