<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ArangoDB;
use ArangoDBClient\Document as ArangoDocument;
use ArangoDBClient\Exception as ArangoException;
use ArangoDBClient\Export as ArangoExport;
use ArangoDBClient\ConnectException as ArangoConnectException;
use ArangoDBClient\ClientException as ArangoClientException;
use ArangoDBClient\ServerException as ArangoServerException;
use ArangoDBClient\Statement as ArangoStatement;
use ArangoDBClient\UpdatePolicy as ArangoUpdatePolicy;


class AdminUniversidades extends Controller
{
    protected $DocumentHandler;
    protected $CollectionHandler;
    protected $ArangoDB;
    private $collection = 'universidades';

    public function __construct(ArangoDB $ArangoDB)
    {
        $this->ArangoDB = $ArangoDB;
        $this->DocumentHandler = $ArangoDB->DocumentHandler();
        $this->CollectionHandler = $ArangoDB->CollectionHandler();
        ArangoException::enableLogging();
        $this->middleware('auth:admin');
    }

    /**
     * Listado de Universidades
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function Index(){
        $datos = $this->ArangoDB->Query('FOR u IN universidades RETURN u');
        return view('admin.universidades.list', compact('datos'));
    }

    /*
     * Crear nueva universidad
     */
    public function New(){
        return view('admin.universidades.new');
    }

    /**
     * Editar la Uniiversidad
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ArangoException
     */
    public function Edit($id){
        $cursor = $this->CollectionHandler->byExample($this->collection, ['_id' => $this->collection.'/'.$id]);
        $item = $this->ArangoDB->Document($cursor->getAll());
        if(!$item){
            return redirect()->action('AdminUniversidades@Index')->with('error','La Universidad no existe');
        }
        return view('admin.universidades.edit', compact('item'));
    }

    public function Save(){

    }

    public function Delete($id){

    }
}
