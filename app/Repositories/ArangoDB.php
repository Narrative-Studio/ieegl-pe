<?php
namespace App\Repositories;

use ArangoDBClient\Collection as ArangoCollection;
use ArangoDBClient\CollectionHandler as ArangoCollectionHandler;
use ArangoDBClient\Connection as ArangoConnection;
use ArangoDBClient\ConnectionOptions as ArangoConnectionOptions;
use ArangoDBClient\DocumentHandler as ArangoDocumentHandler;
use ArangoDBClient\Edge;
use ArangoDBClient\EdgeHandler as ArangoEdgeHandler;
use ArangoDBClient\Statement as ArangoStatment;
use ArangoDBClient\Document as ArangoDocument;
use ArangoDBClient\Exception as ArangoException;
use ArangoDBClient\Export as ArangoExport;
use ArangoDBClient\ConnectException as ArangoConnectException;
use ArangoDBClient\ClientException as ArangoClientException;
use ArangoDBClient\ServerException as ArangoServerException;
use ArangoDBClient\Statement as ArangoStatement;
use ArangoDBClient\UpdatePolicy as ArangoUpdatePolicy;
use Illuminate\Pagination\LengthAwarePaginator;
use triagens\ArangoDb\Document;

class ArangoDB
{
    protected $ConnectionHandler;
    protected $ArangoDocumentHandler;
    protected $ArangoCollectionHandler;
    protected $ArangoEdgeHandler;

    /**
     * ArangoDB constructor.
     * @throws ArangoException
     */
    public function __construct()
    {
        $connectionOptions = array(
            // database name
            ArangoConnectionOptions::OPTION_DATABASE => 'sid',
            // server endpoint to connect to
            ArangoConnectionOptions::OPTION_ENDPOINT => env('ARANGO_SERVER'),
            // authorization type to use (currently supported: 'Basic')
            ArangoConnectionOptions::OPTION_AUTH_TYPE => 'Basic',
            // user for basic authorization
            ArangoConnectionOptions::OPTION_AUTH_USER => env('ARANGO_USER'),
            // password for basic authorization
            ArangoConnectionOptions::OPTION_AUTH_PASSWD => env('ARANGO_PASSWORD'), //Developer
            // connection persistence on server. can use either 'Close' (one-time connections) or 'Keep-Alive' (re-used connections)
            ArangoConnectionOptions::OPTION_CONNECTION => 'Keep-Alive',
            // connect timeout in seconds
            ArangoConnectionOptions::OPTION_TIMEOUT => 3,
            // whether or not to reconnect when a keep-alive connection has timed out on server
            ArangoConnectionOptions::OPTION_RECONNECT => true,
            // optionally create new collections when inserting documents
            ArangoConnectionOptions::OPTION_CREATE => true,
            // optionally create new collections when inserting documents
            ArangoConnectionOptions::OPTION_UPDATE_POLICY => ArangoUpdatePolicy::LAST,
        );
        $this->ConnectionHandler = new ArangoConnection($connectionOptions);
        $this->ArangoDocumentHandler = new ArangoDocumentHandler($this->ConnectionHandler);
        $this->ArangoCollectionHandler = new ArangoCollectionHandler($this->ConnectionHandler);
        $this->ArangoEdgeHandler = new ArangoEdgeHandler($this->ConnectionHandler);
    }

    /**
     * Create DocumentHandler
     * @return ArangoDocumentHandler
     */
    public function DocumentHandler(){
        return new ArangoDocumentHandler($this->ConnectionHandler);
    }

    /**
     * Create CollectionHandler
     * @return ArangoCollectionHandler
     */
    public function CollectionHandler(){
        return new ArangoCollectionHandler($this->ConnectionHandler);
    }

    /**
     * Create EdgeHandler
     * @return ArangoEdgeHandler
     */
    public  function EdgeHandler(){
        return new ArangoEdgeHandler($this->ConnectionHandler);
    }

    /**
     * Format Document cursor to object
     * @param $cursor
     * @return json
     */
    public function Document($cursor){
        foreach ($cursor as $value) {
            if ($value instanceof Document) {
                return json_decode($value . PHP_EOL);
            } else {
                return  json_decode($value. PHP_EOL);
            }
        }
    }

    /**
     * Query AQL
     * @param $query
     * @param bool $array
     * @return array
     * @throws ArangoException
     */
    public function Query($query, $array=false){
        $statement = new ArangoStatment(
            $this->ConnectionHandler,
            array(
                "query"     => $query,
                "count"     => true,
                "batchSize" => 1000,
                "sanitize"  => true
            )
        );

        $cursor = $statement->execute();
        $resultingDocuments = array();

        foreach ($cursor as $key => $value) {
            if($array){
                $resultingDocuments[$key] = (array)json_decode($value);
            }else{
                $resultingDocuments[$key] = json_decode($value);
            }
        }
        return $resultingDocuments;
    }

    /**
     * Obtener formato para Select boxes
     * @param $array
     * @param $key
     * @param $value
     * @return array
     */
    public function SelectFormat($array,$key,$value){
        $data = [];
        foreach ($array as $arr){
            $data[$arr[$key]] = $arr[$value];
        }
        return $data;
    }

    /**
     * Get Row by ID
     * @param $collection
     * @param $id
     * @return mixed
     * @throws ArangoException
     */
    public function GetById($collection, $id){
        return json_decode($this->ArangoDocumentHandler->get($collection, $id));
    }

    /**
     * Save Row
     * @param $collection
     * @param $document
     * @return mixed
     * @throws ArangoClientException
     * @throws ArangoException
     */
    public function Save($collection, $document){
        $data = new ArangoDocument();
        foreach($document as $key=>$value){
            $data->set($key, $value);
        }
        return $this->ArangoDocumentHandler->save($collection, $data);
    }

    /**
     * Update Row
     * @param $collection
     * @param $id
     * @param $document
     * @return bool
     * @throws ArangoClientException
     * @throws ArangoException
     */
    public function Update($collection, $id, $document){
        $data = new ArangoDocument();
        foreach($document as $key=>$value){
            $data->set($key, $value);
        }
        return $this->ArangoDocumentHandler->updateById($collection, $id, $data);
    }

    /**
     * Delete Row
     * @param $collection
     * @param $id
     * @return bool
     * @throws ArangoException
     */
    public function Delete($collection, $id){
        return $this->ArangoDocumentHandler->removeById($collection, $id);
    }

    /**
     * Crear Edge Collection
     * @param $data
     * @param $collection
     * @param $from
     * @param $to
     * @return mixed
     * @throws ArangoClientException
     * @throws ArangoException
     */
    public function CreateEdge($data, $collection, $from, $to){
        $contentEdge =Edge::createFromArray($data);
        return $this->ArangoEdgeHandler->saveEdge($collection, $from, $to, $contentEdge);
    }

    /**
     * Make Pagination for Laravel
     * @param $data
     * @param $total
     * @param $query
     * @return LengthAwarePaginator
     */
    public function Pagination($data, $total, $query){
        return new LengthAwarePaginator($data, $total, $query['perPage'], $query['page'], ['path'=>$query['path']]);
    }
}
