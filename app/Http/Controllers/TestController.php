<?php

namespace App\Http\Controllers;

use App\Mail\SolicitudAdmin;
use App\Repositories\ArangoDB;
use ArangoDBClient\Document;
use Illuminate\Http\Request;
use ArangoDBClient\Document as ArangoDocument;
use ArangoDBClient\Exception as ArangoException;
use ArangoDBClient\Export as ArangoExport;
use ArangoDBClient\ConnectException as ArangoConnectException;
use ArangoDBClient\ClientException as ArangoClientException;
use ArangoDBClient\ServerException as ArangoServerException;
use ArangoDBClient\Statement as ArangoStatement;
use ArangoDBClient\UpdatePolicy as ArangoUpdatePolicy;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{
    protected $DocumentHandler;
    protected $CollectionHandler;
    protected $ArangoDB;

    public function __construct(ArangoDB $ArangoDB)
    {
        $this->ArangoDB = $ArangoDB;
        $this->DocumentHandler = $ArangoDB->DocumentHandler();
        $this->CollectionHandler = $ArangoDB->CollectionHandler();
        ArangoException::enableLogging();
    }

    public function Index(){
        //$result = $this->CollectionHandler->all('users');
        //var_dump($result);

        /*echo '<p>get Admin</p>';
        $cursor = $this->CollectionHandler->byExample('users', ['email' => 'adanlunas@gmail.com']);
        $usuario = $this->ArangoDB->Document($cursor->getAll());
        if($usuario){
            echo $usuario->email;
        }else{
            echo 'no existe';
        }*/

        // update a document
        /*$cursor = $this->CollectionHandler->byExample('users', ['email' => 'adanluna@gmail.com']);
        $usuario = $this->ArangoDB->Document($cursor->getAll());
        $id = $usuario->_key;

        $user = new ArangoDocument();
        $user->username = 'John';
        $result = $this->DocumentHandler->updateById('users', $id, $user);*/

        // Enviando Mail al Administrador
        $document = [];
        $document['responsable_email'] = "adanluna@gmail.com";
        $document['usuario'] = "Adan Luna";
        $document['usuario_email'] = "adan@oundmedia.com";
        $document['convocatoria_key'] = 122334;
        $document['convocatoria_nombre'] = "Prueba";
        $document['fecha_registro'] = strtotime("01/01/2018");
        Mail::to($document['responsable_email'])
            ->send(new SolicitudAdmin($document));

    }

    public function Get(){
        $document = $this->DocumentHandler->get('users', 'users/3050580');
        print_r($document);
        echo $document->username;
    }

    public function Create(){

        // create a document with some attributes
        $document = new ArangoDocument();
        $document->set("nombre", "Esau");
        $document->set("email", "adan@oundmedia.com");
        $document->set("isAdmin", "0");
        $document->set("password", Hash::make('claudia01'));

        // save document in collection
        $documentId = $this->DocumentHandler->save('users', $document);
        echo $documentId;
    }
}
