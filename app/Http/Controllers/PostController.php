<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseApiController;
use App\Model\Post;

class PostController extends BaseApiController {
    
    protected $model = 'App\Model\Post';

    /*
     * GET /objects
     * 
     * Get object list
     */

    public function index() {
        $query = $this->processInput();
        
        $model = new $this->model;

        $result = $model->getAll($query['where'], $query['sort'], $query['limit'], $query['offset']);
        

        // TODO: optimize
        foreach ($result as &$object) {  
           
            if (!empty($query['fields'])) {
                foreach ($object as $key => $value) {
                    if (in_array($key, $query['fields'])) {
                        continue;
                    } else {                             
                        unset($object[$key]);                        
                    }
                }
            }
        }
        
        return response()->json($this->responseFormat($result), 200);        
    }

}
