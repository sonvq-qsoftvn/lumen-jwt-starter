<?php

namespace App\Model\Repository;

use App\Model\Repository\BaseRepository;

class UserRepository extends BaseRepository
{
    
    protected $_table = 'user';

    public function __construct() {
        parent::__construct();
    }    

}
