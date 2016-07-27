<?php

namespace App\Model\ActivityStreams;

use App\Model\ActivityStreams\Document;

class Image extends Document {
    protected $type = 'Image';

    protected $fillable = ['type', 'url'];
}
