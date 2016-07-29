<?php

namespace App\Model\Repository;

use App\Model\Repository\BaseRepository;

class FollowingRepository extends BaseRepository
{
    
    protected $_table = 'following';
    protected $_primaryKey = 'user_id';

    public function __construct() {
        parent::__construct();
    }        

}
