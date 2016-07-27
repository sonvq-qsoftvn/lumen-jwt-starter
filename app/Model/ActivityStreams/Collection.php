<?php

namespace App\Model\ActivityStreams;

use App\Model\ActivityStreams\Object;

class Collection extends Object {
    protected $type = 'Collection';
    protected $totalItems;
    protected $current;
    protected $first;
    protected $last;
    protected $items;        
    
    public function get_totalItems() {
        return $this->totalItems;
    }

    public function get_current() {
        return $this->current;
    }

    public function get_first() {
        return $this->first;
    }

    public function get_last() {
        return $this->last;
    }

    public function get_items() {
        return $this->items;
    }

    public function set_totalItems($totalItems) {
        $this->totalItems = $totalItems;
        return $this;
    }

    public function set_current($current) {
        $this->current = $current;
        return $this;
    }

    public function set_first($first) {
        $this->first = $first;
        return $this;
    }

    public function set_last($last) {
        $this->last = $last;
        return $this;
    }

    public function set_items($items) {
        $this->items = $items;
        return $this;
    }


}
