<?php

namespace App\Model\ActivityStreams;

use App\Model\ActivityStreams\Object;

class Article extends Object {
    protected $type = 'Article';

    protected $fillable = ['type', 'id', 'content', 'location', 'published', 'attachment'];
}
