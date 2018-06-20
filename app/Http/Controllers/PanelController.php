<?php

namespace App\Http\Controllers;

use App\Repositories\ArangoDB;
use Illuminate\Http\Request;
use ArangoDBClient\Document as ArangoDocument;
use ArangoDBClient\Exception as ArangoException;
use ArangoDBClient\Export as ArangoExport;
use ArangoDBClient\ConnectException as ArangoConnectException;
use ArangoDBClient\ClientException as ArangoClientException;
use ArangoDBClient\ServerException as ArangoServerException;
use ArangoDBClient\Statement as ArangoStatement;
use ArangoDBClient\UpdatePolicy as ArangoUpdatePolicy;
use Illuminate\Support\Facades\Hash;

class PanelController extends Controller
{
    protected $DocumentHandler;
    protected $CollectionHandler;

    public function __construct()
    {
        $this->middleware('is_user');
    }

    public function Index(){
        return view('web');
    }
}