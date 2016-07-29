<?php

namespace App\Model\ActivityStreams;

use App\Model\ActivityStreams\Document;

class Video extends Document {
    protected $type = 'Video';

    protected $fillable = ['type', 'url'];
}
