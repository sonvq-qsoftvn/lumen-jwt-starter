<?php

namespace App\Http\Business;
use App\Model\ActivityStreams\Image;
use App\Model\ActivityStreams\Article;

class ObjectBusiness  {   
    public function createObject($inputArray, $type) {
        
        switch ($type) {
            case 'Image':
                $object = new Image();
                $object->set_url($inputArray['url']);
                
                break;
            
            case 'Article':
                $object = new Article();
                $object->set_url($inputArray['url']);
                break;
            default:
                $object = array();
                break;
        }
        
        return $object->toArray();
    }
}
