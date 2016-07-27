<?php

namespace App\Model\Repository;

use \Cassandra as Cassandra;
use \Cassandra\SimpleStatement as SimpleStatement;
use \Cassandra\ExecutionOptions as ExecutionOptions;
use \Cassandra\Uuid as Uuid;

class BaseRepository
{    
    protected $_session;
          
    protected function connectDatabase() {
        
        $cluster = Cassandra::cluster();
        
        $host = env('DB_CASSANDRA_HOST');
        if (isset($host) && !empty($host)) {            
            if (is_array($host)) {
                $cluster->withContactPoints(explode(',', $host));
            } else {                
                $cluster->withContactPoints($host);
            }
        }
        
        $username = env('DB_CASSANDRA_USERNAME');
        $password = env('DB_CASSANDRA_PASSWORD');
        $keyspace = env('DB_CASSANDRA_KEYSPACE');
        
        if (isset($username) && isset($password) && !empty($username) && !empty($password)) {            
            $cluster->withCredentials($username, $password);            
        }
        
        $port = env('DB_CASSANDRA_PORT');
        if (isset($port) && !empty($port)) {            
            $cluster->withPort(intval($port));
        }
        
        $cluster = $cluster->build(); 
        
        try {
            $this->_session = $cluster->connect($keyspace);
        } catch (Exception $ex) {
            echo $ex->getMessage();
            exit();
        }
        
    }

    /**
     * Create a new database connection instance.
     *
     * 
     */
    public function __construct() {
        $this->connectDatabase();
    }
    
    protected function simpleArrayMapping(array $result = array(), $list = true) {
        
        if ($list == false) {
            $arraySimpled = $this->mapArrayToSimpledArray($result);   
        } else {
            $arraySimpled = array();
            foreach ($result as $singleResult) {
                $processedArr = $this->mapArrayToSimpledArray($singleResult);            
                $arraySimpled[] = $processedArr;
            }
        }
                
        return $arraySimpled;
    }
    
    protected function mapArrayToSimpledArray(array $arrayInput = array()) {

        $simpledArray = array();
        foreach ($arrayInput as $key => $value) {
            
            if (is_object($value)) {
                $classOfObject = get_class($value);
                switch ($classOfObject) {
                    case 'Cassandra\Uuid':
                        $simpledArray[$key] = $value->__toString();
                        break;
                    case 'Cassandra\Timestamp':
                        $simpledArray[$key] = $value->__toString();
                        break;
                    case 'Cassandra\Timeuuid':
                        $simpledArray[$key] = $value->time();                        
                        break;
                    case 'Cassandra\Set':
                        // TODO
                        //die('todo Cassandra\Set');
//                        $valueInSet = $value->values();
//                        var_dump($valueInSet);
                        break;
                    case 'Cassandra\UserTypeValue';
                        // TODO
                        //die('todo Cassandra\UserTypeValue');
                        break;
                    default:
                        break;
                }
            } else {
                $simpledArray[$key] = $value;
            }
        }

        return $simpledArray;
    }
    
    public function getAll (array $where = array(), array $sort = array(), $limit = 10, $offset = 0) {
        
        $statement = new SimpleStatement(
            "SELECT * from $this->_table"
        );

        $future = $this->_session->executeAsync($statement);
        $queryResult = $future->get();
        $result = array();

        foreach ($queryResult as $row) {
            $result[] = $row;            
        }
        
        $processedResult = $this->simpleArrayMapping($result);
        
        return $processedResult;
    }    
    
    public function getById ($id, array $where = array(), array $sort = array(), $limit = 10, $offset = 0) {
        $statement = $this->_session->prepare(
            "SELECT * FROM $this->_table WHERE " . $this->_table. "_id = ?"
        );

        $queryResult = $this->_session->execute($statement, new ExecutionOptions(array(
            'arguments' => array(new Uuid($id))
        )));

        
        $result = $queryResult->first();
        
        $processedResult = $this->simpleArrayMapping($result, false);
        
        return $processedResult;
    }

}
