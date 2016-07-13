<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseCassandraController;

class VideoController extends BaseCassandraController {

    protected $_keyspace = 'videodb';
    protected $_table = 'videos';
    protected $_plular = 'videos';
    protected $_singular = 'video';

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

    public function show($id) {
        $statement = $this->_session->prepare(
                "SELECT * FROM $this->_table WHERE videoid = ?"
        );

        $queryResult = $this->_session->execute($statement, new ExecutionOptions(array(
            'arguments' => array(new Uuid($id))
        )));

        $result = array();
        foreach ($queryResult as $row) {
            $result[$this->_singular] = $row;
        }
        return [
            'success' => $result,
        ];
    }

}
