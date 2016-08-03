<?php

namespace App\Model\Repository;

use App\Model\Repository\BaseRepository;

use \Cassandra\SimpleStatement as SimpleStatement;
use \Cassandra\ExecutionOptions as ExecutionOptions;
use \Cassandra\BatchStatement as BatchStatement;
use \Cassandra as Cassandra;
use \Cassandra\Uuid as Uuid;
use \Cassandra\Type as Type;
use \Cassandra\Timestamp as Timestamp;
use App\Common\Helper as Helper;


class PostRepository extends BaseRepository
{
    
    protected $_table = 'post';
    protected $_primaryKey = ['author_id' => 'Uuid', 'date_created' => 'Timestamp', 'post_id' => 'Uuid'];
    
    public function __construct() {
        parent::__construct();
    }   

    public  function create($data)
    {
    	// Fake author_id 
    	$statement = "INSERT INTO post(author_id, date_created, post_id, content, date_updated, images, location, publicity, videos)" . " VALUES(?,?,?,?,?,?,?,?,?)";

    	$images = Type::set(Type::uuid())->create( new Uuid('60b5a385-6567-4b0d-8931-4319ec6118e2'),  new Uuid('877183e8-55af-4d5b-ab04-fdb6f951aaf9'), new Uuid('6fbf4472-01d3-4174-800b-7206ef104154'));
		$videos = Type::set(Type::uuid())->create( new Uuid('678fc414-92cc-4026-8992-e265de7ff6dd'),  new Uuid('78351abb-97eb-4526-b11f-34173ac2ff69'), new Uuid('bb9fd946-24e2-4ba2-a16c-22c43b916841'));

		try 
		{
			$postIdObject = new uuid;
			$postId = $postIdObject->__toString();
			$this->_session->execute(
				new SimpleStatement($statement),
				new ExecutionOptions(array(
					'arguments' => array(
						new Uuid($data['author_id']),
						new Timestamp(time()),
						$postIdObject,
						htmlspecialchars($data['content']),
						new Timestamp(time()),
						$images,
						null,
						'1',
						$videos
					)
				))
			);

			return $postId;

		}
		catch(\Exception $e) 
		{
			echo $e->getMessage();
			return false;						
		}

		return true;

    } 
    
    public function getAllByFollowing (array $userIdArray = array(), $startTime = null, $endTime = null) {
        $sqlQuery = "SELECT * FROM $this->_table WHERE author_id IN (" . implode(', ', $userIdArray) . ")";
        
        if ($startTime != null) {
            $startTime = Helper::timestampSecondsToMilliseconds($startTime);
            $sqlQuery .= " and date_created > $startTime ";            
        }
        
        if ($endTime != null) {
            $endTime = Helper::timestampSecondsToMilliseconds($endTime);
            $sqlQuery .= " and date_created <= $endTime ";            
        }

        $sqlQuery .= 'ORDER BY date_created desc';
        $statement = $this->_session->prepare($sqlQuery);
           
        $queryResult = $this->_session->execute($statement);
        
        $result = array();

        foreach ($queryResult as $row) {
            $result[] = $row;   
        }
        
        $processedResult = $this->simpleArrayMapping($result);
        
        return $processedResult;
    }    
}
