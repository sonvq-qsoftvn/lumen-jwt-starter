<?php

namespace App\Http\Business;


use App\Model\ActivityStreams\Create;

use App\Http\Business\ActorBusiness;
use App\Http\Business\ObjectBusiness;

use App\Model\Repository\UserRepository;
use App\Model\Repository\PostRepository;

class ActivityBusiness  {   
    public function createObject($inputArray) {
        $arrayActivity = array();
        foreach ($inputArray as $singleArray) {
            switch ($singleArray['activity_type']) {
                case 'Create':                    
                    $createAction = new Create();
                     
                    // Get Actor for Create action
                    if (isset($singleArray['user_id'])) {
                        $userRepository = new UserRepository();
                        $user = $userRepository->getById($singleArray['user_id']);                    
                        $actorBusiness = new ActorBusiness();
                        $createAction->set_actor($actorBusiness->createObject($user, 'Person'));
                    }
                
                    if(isset($singleArray['activity_id'])) {
                        var_dump($singleArray);die;
                        $postRepository = new PostRepository();                        
                        $post = $postRepository->getById($singleArray['activity_id']);                        
                        $objectBusiness = new ObjectBusiness();
                        $createAction->set_object($objectBusiness->createObject($post, 'Article'));
                    }
                    
                    $arrayActivity[] = $createAction->toArray();
                    break;
                
                default:
                    break;
            }
            
        }
        
        return $arrayActivity;
    }
}
