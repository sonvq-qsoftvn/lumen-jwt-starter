<?php

namespace App\Model\Repository;

use App\Model\Repository\BaseRepository;

class VideoRepository extends BaseRepository
{
    
    protected $_table = 'video';

    public function __construct() {
        parent::__construct();
    }        

}
