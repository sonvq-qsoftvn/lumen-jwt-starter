<?php

namespace App\Model\Repository;

use App\Model\Repository\BaseRepository;

class PostRepository extends BaseRepository
{
    
    protected $_table = 'post';

    public function __construct() {
        parent::__construct();
    }   

}
