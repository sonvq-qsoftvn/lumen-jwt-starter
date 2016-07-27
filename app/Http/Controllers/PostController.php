<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseApiController;
use App\Model\Repository\PostRepository;

class PostController extends BaseApiController {
    
    protected $repository = 'App\Model\Repository\PostRepository';

    /*
     * GET /objects
     * 
     * Get object list
     */

    public function index() {
        $query = $this->processInput();
        
        $repository = new $this->repository;

        $result = $repository->getAll($query['where'], $query['sort'], $query['limit'], $query['offset']);
        
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
