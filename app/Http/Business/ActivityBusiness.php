<?php

namespace App\Http\Business;


use App\Model\ActivityStreams\Create;

use App\Http\Business\ActorBusiness;
use App\Http\Business\ObjectBusiness;

use App\Model\Repository\UserRepository;
use App\Model\Repository\PostRepository;

class ActivityBusiness  {   
    public function createObject($inputArray, $type) {
        $arrayActivity = array();
        
        foreach ($inputArray as $singleArray) {
            switch ($type) {
                case 'Create':                    
                    $createAction = new Create();
                     
                    // Get Actor for Create action
                    if (isset($singleArray['author_id'])) {
                        $userRepository = new UserRepository();
                        $user = $userRepository->getById($singleArray['author_id']); 
                        
                        if (!empty($user)) {
                            $actorBusiness = new ActorBusiness();
                            $createAction->set_actor($actorBusiness->createObject($user, 'Person'));
                        }                        
                    }

                    $objectBusiness = new ObjectBusiness();
                    $createAction->set_object($objectBusiness->createObject($singleArray, 'Article'));                    
                    
                    if (isset($singleArray['date_created']) && $singleArray['date_created']) {
                        $createAction->set_published($singleArray['date_created']);
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
