<?php

namespace App\Model\ActivityStreams;

use App\Model\ActivityStreams\Object;

class Person extends Object {
    protected $type = 'Person';
    protected $fillable = ['type', 'name', 'id', 'image'];
}
