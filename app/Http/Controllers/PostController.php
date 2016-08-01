<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseApiController;
use App\Model\Repository\PostRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request as RequestSupport;
use App\Model\ActivityStreams\OrderedCollection;
use App\Http\Business\ActivityBusiness;
use App\Model\Repository\FollowingRepository;

class PostController extends BaseApiController {
    
    protected $repository = 'App\Model\Repository\PostRepository';

    /*
     * GET /objects
     * 
     * Get object list
     */

    public function index() {
        
        $input = RequestSupport::all();
        
        // Check user_id input
        if(!isset($input['user_id']) || empty($input['user_id'])) {
             return response()->json($this->responseFormat(null, 'missing_parameters', 'user_id parameter is required'), 412);   
        }
        
        $queryTime = isset($input['time']) ? $input['time'] : time();
        $serverTime = time();
        
        // Return an orderedCollection
        $orderedPosts = new OrderedCollection();
        
        // Get follow list of user_id
        $followingRepository = new FollowingRepository();
        $followingList = $followingRepository->getById($input['user_id']);
        
        if(empty($followingList)) {
            $arrayFollowingId = array();
        } else {
            $arrayFollowingId = $followingList['followings'];                 
        }
        $arrayFollowingId[] = $input['user_id'];
            
        $query = $this->processInput();

        $repository = new $this->repository;

        $postList = $repository->getAllByFollowing($arrayFollowingId, null, $queryTime);

        $activityBusiness = new ActivityBusiness();
        $arrayActivity = $activityBusiness->createObject($postList, 'Create');

        $orderedPosts->fillData($arrayActivity, $serverTime);


        // TODO: optimize
        foreach ($orderedPosts as &$object) {  

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
        
        return response()->json($this->responseFormat($orderedPosts->toArray()), 200);      
    }
    
    public function show($id) {
        
    } 
            
    public function newposts() {
        
        $input = RequestSupport::all();
        
        // Check user_id input
        if(!isset($input['user_id']) || empty($input['user_id'])) {
             return response()->json($this->responseFormat(null, 'missing_parameters', 'user_id parameter is required'), 412);   
        }
        
        if(!isset($input['time_end']) || empty($input['time_end'])) {
             return response()->json($this->responseFormat(null, 'missing_parameters', 'time_end parameter is required'), 412);   
        }
        
        $serverTime = time();
        
        // Return an orderedCollection
        $orderedPosts = new OrderedCollection();
        
        // Get follow list of user_id
        $followingRepository = new FollowingRepository();
        $followingList = $followingRepository->getById($input['user_id']);                
        
        if(empty($followingList)) {
            $arrayFollowingId = array();
        } else {
            $arrayFollowingId = $followingList['followings'];                 
        }
        $arrayFollowingId[] = $input['user_id'];
        
        $query = $this->processInput();

        $repository = new $this->repository;

        $postList = $repository->getAllByFollowing($arrayFollowingId, $input['time_end'], $serverTime);

        $activityBusiness = new ActivityBusiness();
        $arrayActivity = $activityBusiness->createObject($postList, 'Create');

        $orderedPosts->fillData($arrayActivity, $serverTime);


        // TODO: optimize
        foreach ($orderedPosts as &$object) {  

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
        
        
        return response()->json($this->responseFormat($orderedPosts->toArray()), 200);     
    }

    /**
     * @todo: post by client include text, image, video, ...
     */
    public function store(Request $request)
    {
        
        $input = $request->all();
        
        if ($input)
        {
            if (! (isset($input['actor']['id']) && $input['actor']['id']))
            {
                return response()->json($this->responseFormat(null, 'missing_parameters', 'Required Actor!'));
            }

            if (! (isset($input['object']['content']) && $input['object']['content']))
            {
                return response()->json($this->responseFormat(null, 'missing_parameters', 'Require content!'));
            }

            $type_action = isset($input['type']) ? $input['type'] : 'Create';
            $type = isset($input['object']['type']) ? $input['object']['type'] : 'Article';
            $content = isset($input['object']['content']) ? $input['object']['content'] : '';
            $published = isset($input['object']['published']) ? $input['object']['published'] : '';
            // Hard fix author_id
            $author_id = isset($input['actor']['id']) ? $input['actor']['id'] : 'f316527a-b34e-4329-91ce-1935977959a5';
            $data = ['content' => $content, 'published' => $published, 'author_id' => $author_id];

            $postRepository = new PostRepository;
            $postId = $postRepository->create($data);

            if ($postId)
            {
                 
                $result =  array(
                    'type' => 'Create',
                    'actor' => array(
                        'id' => $author_id
                    ),
                    'object' => array(
                        'type' => 'Article',
                        'id' => $postId,
                        'content' =>  htmlspecialchars($content),
                        'published' => $published
                    )
                );
                
                return response()->json($this->responseFormat($result));
                
            }
            else 
            {
                 
                 return response()->json($this->responseFormat(null, 'error_insert', 'Error inserting!'));
            }
        }
        

        
        

        //return ApiAppResponse::response(0, 'Response ok', $input);
    }

}
