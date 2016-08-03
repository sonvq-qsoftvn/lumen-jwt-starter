<?php

namespace App\Model\Repository;

use \Cassandra as Cassandra;
use \Cassandra\SimpleStatement as SimpleStatement;
use \Cassandra\ExecutionOptions as ExecutionOptions;
use \Cassandra\Uuid as Uuid;
use \Cassandra\Timestamp as Timestamp;

class BaseRepository
{    
    protected $_session;
    protected $_primaryKey;
          
    protected function connectDatabase() {
        
        $cluster = Cassandra::cluster();
        $cluster = $cluster->withDefaultPageSize(null);
        
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
        if (!isset($this->_primaryKey) && !is_array($this->_primaryKey)) {
            $this->_primaryKey = $this->_table. "_id";
        }
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
                        $returnValue = $value->__toString();
                        if(strlen($returnValue) > 10) {
                            $returnValue = substr($returnValue, 0, 10);
                        }
                        $simpledArray[$key] = $returnValue;
                        break;
                    case 'Cassandra\Timeuuid':
                        $simpledArray[$key] = $value->time();                        
                        break;
                    case 'Cassandra\Set':
                        // TODO
                        $valueInSet = $value->values();
                        $arrayValue = array();
                        if (count($valueInSet) > 0) {
                            foreach ($valueInSet as $singleKey => $singleValue) {
                                if(!is_object($singleValue)) {
                                    $arrayValue[] = $singleValue;
                                } else {                                    
                                    $arrayValue[] = $singleValue->__toString();      
                                }
                            }
                        }
                        $simpledArray[$key] = $arrayValue;                        
                        break;
                    case 'Cassandra\UserTypeValue':
                        switch ($key) {
                            case 'address':
                                
                                break;
                            case 'location':
                                $arrayLocation = array();
                                $locationArr = $value->values();
                                foreach ($locationArr as $subkey => $subvalue) {
                                    if (is_object($subvalue)) {
                                        $arrayLocation[$subkey] = $subvalue->__toString();
                                    } else {
                                        $arrayLocation[$subkey] = $subvalue;
                                    }
                                }
                                $simpledArray[$key] = $arrayLocation; 
                                break;
                            case 'phone':
                                break;
                        }
                        // TODO
                        //var_dump('todo Cassandra\UserTypeValue');die;
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

        $queryResult = $this->_session->execute($statement);
        
        $result = array();

        foreach ($queryResult as $row) {
            $result[] = $row;   
        }
        
        $processedResult = $this->simpleArrayMapping($result);
        
        return $processedResult;
    }    
    
    public function getById ($id, array $where = array(), array $sort = array(), $limit = 10, $offset = 0) {
        if (!is_array($this->_primaryKey)) {                        
            $statement = $this->_session->prepare(
                "SELECT * FROM $this->_table WHERE " . $this->_primaryKey . " = ?"
            );

            $queryResult = $this->_session->execute($statement, new ExecutionOptions(array(
                'arguments' => array(new Uuid($id))
            )));
        } else {
            $queryString = '';
            $length = count($this->_primaryKey);
            $counter = 0;
            $arrayArguments = array();
            
            foreach ($this->_primaryKey as $key => $value) {
                $queryString = $queryString . $key . ' = ?';
                if ($counter < $length - 1) {
                    $queryString .= ' and ';
                }
                switch ($value) {
                    case 'Uuid':
                        $arrayArguments[] = new Uuid($id[$counter]);
                        break;
                    case 'Timestamp':
                        $arrayArguments[] = new Timestamp($id[$counter]);
                        break;
                }
                
                $counter++;
                
            }
            $statement = $this->_session->prepare(
                "SELECT * FROM $this->_table WHERE " . $queryString
            );
                       
            $queryResult = $this->_session->execute($statement, new ExecutionOptions(array(
                'arguments' => $arrayArguments
            )));
        }
        

        
        $result = $queryResult->first();
                
        $processedResult = null;
        if (!empty($result)) {
            $processedResult = $this->simpleArrayMapping($result, false);
        }
        
        return $processedResult;
    }

}
