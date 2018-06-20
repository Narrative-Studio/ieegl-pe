<?php
namespace App\Repositories;

use ArangoDBClient\Collection as ArangoCollection;
use ArangoDBClient\CollectionHandler as ArangoCollectionHandler;
use ArangoDBClient\Connection as ArangoConnection;
use ArangoDBClient\ConnectionOptions as ArangoConnectionOptions;
use ArangoDBClient\DocumentHandler as ArangoDocumentHandler;
use ArangoDBClient\EdgeHandler as ArangoEdgeHandler;
use ArangoDBClient\Document as ArangoDocument;
use ArangoDBClient\Exception as ArangoException;
use ArangoDBClient\Export as ArangoExport;
use ArangoDBClient\ConnectException as ArangoConnectException;
use ArangoDBClient\ClientException as ArangoClientException;
use ArangoDBClient\ServerException as ArangoServerException;
use ArangoDBClient\Statement as ArangoStatement;
use ArangoDBClient\UpdatePolicy as ArangoUpdatePolicy;
use triagens\ArangoDb\Document;

class ArangoDB
{
    protected $ConnectionHandler;

    public function __construct()
    {
        $connectionOptions = array(
            // database name
            ArangoConnectionOptions::OPTION_DATABASE => 'sid',
            // server endpoint to connect to
            ArangoConnectionOptions::OPTION_ENDPOINT => 'tcp://142.44.247.4:8529',
            // authorization type to use (currently supported: 'Basic')
            ArangoConnectionOptions::OPTION_AUTH_TYPE => 'Basic',
            // user for basic authorization
            ArangoConnectionOptions::OPTION_AUTH_USER => 'root',
            // password for basic authorization
            ArangoConnectionOptions::OPTION_AUTH_PASSWD => 'lO2wnHr8',
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
    }
    public function DocumentHandler(){
        return new ArangoDocumentHandler($this->ConnectionHandler);
    }

    public function CollectionHandler(){
        return new ArangoCollectionHandler($this->ConnectionHandler);
    }

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
}
