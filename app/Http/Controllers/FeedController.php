<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseApiController;
use App\Model\ActivityStreams\OrderedCollection;
use App\Model\Repository\UserActivityRepository;
use App\Http\Business\ActivityBusiness;

class FeedController extends BaseApiController {   

    protected $repository = 'App\Model\Repository\UserActivityRepository';
    /*
     * GET /feed
     * 
     * Get all feeds
     */
    public function index() {
//        $user = \JWTAuth::parseToken()->toUser();
//        $userId = $user->getKey();
        
        $query = $this->processInput();
        
        // Return an orderedCollection
        $orderedFeed = new OrderedCollection();
        
        $repository = new $this->repository;
        
        $userActivityRepository = new UserActivityRepository();
        $userActivityList = $repository->getAll($query['where'], $query['sort'], $query['limit'], $query['offset']);
        
        $activityBusiness = new ActivityBusiness();
        $arrayActivity = $activityBusiness->createObject($userActivityList);
        
        $orderedFeed->fillData($arrayActivity);
                
                
        // TODO: optimize
        foreach ($orderedFeed as &$object) {  
           
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
        
        return response()->json($this->responseFormat($orderedFeed->toArray()), 200);        
    }

}
