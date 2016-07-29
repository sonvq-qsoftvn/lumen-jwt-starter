<?php

namespace App\Http\Business;

use App\Model\ActivityStreams\Image;
use App\Model\ActivityStreams\Article;
use App\Model\ActivityStreams\Place;
use App\Model\ActivityStreams\Video;

use App\Model\Repository\ImageRepository;
use App\Model\Repository\VideoRepository;

class ObjectBusiness  {   
    public function createObject($inputArray, $type) {
        
        switch ($type) {
            case 'Image':
                $object = new Image();
                if (isset($inputArray['url']) && $inputArray['url']) {
                    $object->set_url($inputArray['url']);    
                }

                break;
            
            case 'Video':
                $object = new Video();
                
                if (isset($inputArray['url']) && $inputArray['url']) {
                    $object->set_url($inputArray['url']);    
                }
                
                break;
            
            case 'Article':
                $object = new Article();
                                
                if (isset($inputArray['post_id']) && $inputArray['post_id']) {
                    $object->set_id($inputArray['post_id']);
                }
                
                if (isset($inputArray['content']) && $inputArray['content']) {
                    $object->set_content($inputArray['content']);
                }
                
                if (isset($inputArray['date_created']) && $inputArray['date_created']) {
                    $object->set_published($inputArray['date_created']);
                }
                
                if(isset($inputArray['location']) && $inputArray['location']) {
                    $location = $this->createObject($inputArray['location'], 'Place');
                    $object->set_location($location);
                }
                
                $arrayAttachment = array();
                if(isset($inputArray['images']) && count($inputArray['images']) > 0) {
                    foreach ($inputArray['images'] as $singleImageId) {
                        $imageRepository = new ImageRepository();   
                        $image = $imageRepository->getById($singleImageId);
                        $imageObject = $this->createObject($image, 'Image');
                        
                        $arrayAttachment[] = $imageObject;
                    }
                }
                
                if(isset($inputArray['videos']) && count($inputArray['videos']) > 0) {
                    foreach ($inputArray['videos'] as $singleVideoId) {
                        $videoRepository = new VideoRepository();   
                        $video = $videoRepository->getById($singleVideoId);
                        $videoObject = $this->createObject($video, 'Video');
                        
                        $arrayAttachment[] = $videoObject;
                    }
                }
                
                $object->set_attachment($arrayAttachment);
                break;
                
            case 'Place':
                $object = new Place();
                
                if(isset($inputArray['text']) && $inputArray['text']) {
                    $object->set_content($inputArray['text']);
                }
                
                if(isset($inputArray['lat']) && $inputArray['lat']) {
                    $object->set_latitude($inputArray['lat']);
                }
                
                if(isset($inputArray['long']) && $inputArray['long']) {
                    $object->set_longitude($inputArray['long']);
                }
                break;
            default:
                $object = array();
                break;
        }
        
        return $object->toArray();
    }
}
