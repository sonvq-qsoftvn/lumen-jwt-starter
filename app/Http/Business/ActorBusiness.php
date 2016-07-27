<?php

namespace App\Http\Business;
use App\Model\ActivityStreams\Person;
use App\Model\Repository\ImageRepository;
use App\Http\Business\ObjectBusiness;

class ActorBusiness  {   
    public function createObject($inputArray, $type) {
        switch ($type) {
            case 'Person':
                $object = new Person;        
                $object->set_id($inputArray['user_id']);
                $object->set_name($inputArray['first_name'] . ' ' . $inputArray['last_name']);

                if (isset($inputArray['avatar'])) {
                    $imageRepository = new ImageRepository();
                    $image = $imageRepository->getById($inputArray['avatar']);                    
                    $objectBusiness = new ObjectBusiness();            
                    $object->set_image($objectBusiness->createObject($image, 'Image'));
                }
                break;
            default:
                $object = array();
        }

        
        return $object->toArray();
    }
}
