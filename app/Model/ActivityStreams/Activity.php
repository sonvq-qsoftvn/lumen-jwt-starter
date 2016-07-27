<?php

namespace App\Model\ActivityStreams;

use App\Model\ActivityStreams\Object;

class Activity extends Object {
    protected $type = 'Activity';
    protected $actor;
    protected $object;
    protected $target;
    protected $result;
    protected $origin;
    protected $instrument;

    public function get_actor() {
        return $this->actor;
    }

    public function get_object() {
        return $this->object;
    }

    public function get_target() {
        return $this->target;
    }

    public function get_result() {
        return $this->result;
    }

    public function get_origin() {
        return $this->origin;
    }

    public function get_instrument() {
        return $this->instrument;
    }

    public function set_actor($actor) {
        $this->actor = $actor;
        return $this;
    }

    public function set_object($object) {
        $this->object = $object;
        return $this;
    }

    public function set_target($target) {
        $this->target = $target;
        return $this;
    }

    public function set_result($result) {
        $this->result = $result;
        return $this;
    }

    public function set_origin($origin) {
        $this->origin = $origin;
        return $this;
    }

    public function set_instrument($instrument) {
        $this->instrument = $instrument;
        return $this;
    }

    
}
