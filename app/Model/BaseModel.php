<?php

namespace App\Model;
use \Cassandra as Cassandra;

class BaseModel
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
    
    public function toArray()
    {
        $array = array();
        $arrayProperties = get_object_vars($this);
        foreach ($arrayProperties as $key => $value) {
            $functionName = "get_" . $key;
            $array[$key] = $this->$functionName();
        }
        
        
        return $array;
    }
}
