<?php

namespace App\Model\Repository;

use App\Model\Repository\BaseRepository;

class UserActivityRepository extends BaseRepository
{
    
    protected $_table = 'user_activity';

    public function __construct() {
        parent::__construct();
    }        

}
