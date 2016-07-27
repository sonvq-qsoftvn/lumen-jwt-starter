<?php

namespace App\Model\Repository;

use App\Model\Repository\BaseRepository;

class ImageRepository extends BaseRepository
{
    
    protected $_table = 'image';

    public function __construct() {
        parent::__construct();
    }        

}
