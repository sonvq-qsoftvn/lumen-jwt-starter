<?php

namespace App\Model\ActivityStreams;

use App\Model\ActivityStreams\Collection;

class OrderedCollection extends Collection {

    protected $type = 'OrderedCollection';
    protected $orderedItems;
    protected $serverRequestTime;
    protected $fillable = ['type', 'totalItems', 'orderedItems', 'serverRequestTime'];

    public function get_orderedItems() {
        return $this->orderedItems;
    }

    public function set_orderedItems($orderedItems) {
        $this->orderedItems = $orderedItems;
        return $this;
    }
    
    public function get_serverRequestTime() {
        return $this->serverRequestTime;
    }

    public function set_serverRequestTime($serverRequestTime) {
        $this->serverRequestTime = $serverRequestTime;
        return $this;
    }

    public function fillData($arrayItem, $serverTime) {
        
        $this->set_totalItems(count($arrayItem));
        $this->set_orderedItems($arrayItem);
        $this->set_serverRequestTime($serverTime);
        
        return $this;
    }

}
