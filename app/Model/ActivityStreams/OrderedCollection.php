<?php

namespace App\Model\ActivityStreams;

use App\Model\ActivityStreams\Collection;

class OrderedCollection extends Collection {

    protected $type = 'OrderedCollection';
    protected $orderedItems;
    protected $fillable = ['type', 'totalItems', 'orderedItems'];

    public function get_orderedItems() {
        return $this->orderedItems;
    }

    public function set_orderedItems($orderedItems) {
        $this->orderedItems = $orderedItems;
        return $this;
    }

    public function fillData($arrayItem) {
        $this->set_totalItems(count($arrayItem));
        $this->set_orderedItems($arrayItem);

        return $this;
    }

}
