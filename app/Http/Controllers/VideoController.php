<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseCassandraController;
use \Cassandra\SimpleStatement as SimpleStatement;

class VideoController extends BaseCassandraController {

    protected $_keyspace = 'videodb';
    protected $_table = 'videos';
    
    public function index() {         
        $statement = new SimpleStatement(
            "SELECT * from $this->_table"
        );
        
        $future = $this->_session->executeAsync($statement);
        $queryResult = $future->get();             
        $result = array();
        
        foreach ($queryResult as $row) {                    
            $result[] = $row;
        }
        
        return [
            'success' => [
                "$this->_table" => $result,
            ],
        ];
    }

}
