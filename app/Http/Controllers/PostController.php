<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseApiController;
use Faker\Factory as Faker;
use App\Model\Post;
use App\Model\PostContent;

class PostController extends BaseApiController {

    public function __construct() {
        return parent::__construct();
    }

    protected $model = 'App\Post';

    /*
     * GET /objects
     * 
     * Get object list
     */

    public function index() {
        $query = $this->processInput();
        // $model = $this->model;
        // TODO get all cassandra here
        // $result = $model::getAll($query['where'], $query['sort'], $query['limit'], $query['offset']);

        $result = array();
        $faker = Faker::create('vi_VN');
        $count = empty($query['limit']) ? 10 : $query['limit'];
        for ($i = 0; $i < $count; $i++) {
            $post = new Post();
            $postContent = new PostContent();
            
            $postContent->set_id($faker->uuid);
            $postContent->set_author_id($faker->randomDigitNotNull);
            $postContent->set_content($faker->text);
            
            $arrayImageUrls = array();
            for ($j = 0; $j < $faker->numberBetween(1,3); $j++) {
                $arrayImageUrls[] = $faker->imageUrl;
            }
            $postContent->set_image_urls($arrayImageUrls);
            
            $arrayVideoUrls = array();
            for ($j = 0; $j < $faker->numberBetween(1,2); $j++) {
                $arrayVideoUrls[] = $faker->imageUrl;
            }
            $postContent->set_video_urls($arrayVideoUrls);            
            $postContent->set_location($faker->address);            
            $postContent->set_date_created($faker->numberBetween(1468912597, 1469009460) . $faker->numberBetween(100, 999));
            $postContent->set_date_updated($faker->numberBetween(1468912597, 1469009460) . $faker->numberBetween(100, 999));
            
            $post->set_likes($faker->numberBetween(0, 100));
            $post->set_comments($faker->numberBetween(0, 100));
            $post->set_shares($faker->numberBetween(0, 100));
            $post->set_post($postContent->toArray());
            $result[] = $post->toArray();
        }

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
