<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use \Cassandra as Cassandra;

class BaseCassandraController extends Controller {

    protected $_keyspace;
    protected $_session;
    
    public function getKeyspace() {
        return $this->_keyspace;
    }
    
    public function setKeyspace($_keyspace) {
        $this->_keyspace = $_keyspace;
        return $this;
    }
    
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
        if (isset($username) && isset($password) && !empty($username) && !empty($password)) {            
            $cluster->withCredentials($username, $password);            
        }
        
        $port = env('DB_CASSANDRA_PORT');
        if (isset($port) && !empty($port)) {            
            $cluster->withPort(intval($port));
        }
        
        $cluster = $cluster->build();
        
        try {
            $this->_session = $cluster->connect($this->_keyspace);
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

}
