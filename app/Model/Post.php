<?php

namespace App\Model;

use App\Model\BaseModel;
use \Cassandra\SimpleStatement as SimpleStatement;
use \Cassandra\ExecutionOptions as ExecutionOptions;
use \Cassandra\Uuid as Uuid;

class Post extends BaseModel
{
    protected $author_id;
    protected $date_created;
    
    protected $_table = 'post';

    public function __construct() {
        parent::__construct();
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
        
        return $result;
    }
    
    public function getById ($id, array $where = array(), array $sort = array(), $limit = 10, $offset = 0) {
        $statement = $this->_session->prepare(
            "SELECT * FROM $this->_table WHERE " . $this->_table. "_id = ?"
        );

        $queryResult = $this->_session->execute($statement, new ExecutionOptions(array(
            'arguments' => array(new Uuid($id))
        )));

        $result = array();
        foreach ($queryResult as $row) {
            $result[] = $row;
        }
        
        return $result;
    }

}
