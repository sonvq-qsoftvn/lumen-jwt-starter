<?php

namespace App\Model\ActivityStreams;

use App\Model\ActivityStreams\Activity;

class Create extends Activity {
    protected $type = 'Create';
    protected $fillable = ['type', 'actor', 'object', 'published'];
}
