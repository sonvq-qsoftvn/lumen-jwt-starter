<?php

namespace App\Model\ActivityStreams;

class BaseActivityStreams {

    protected $fillable;

    public function get_fillable() {
        return $this->fillable;
    }

    public function set_fillable($fillable) {
        $this->fillable = $fillable;
        return $this;
    }

    public function toArray() {
        $this->excludeFields();
        $array = array();
        $arrayProperties = get_object_vars($this);
        foreach ($arrayProperties as $key => $value) {
            $functionName = "get_" . $key;
            $array[$key] = $this->$functionName();
        }

        return $array;
    }

    public function excludeFields() {
        if (count($this->fillable) > 0) {
            $allObjectProperties = get_object_vars($this);

            foreach ($allObjectProperties as $key => $value) {

                if (!in_array($key, $this->get_fillable()) && ($key != 'fillable')) {
                    unset($this->$key);
                }
            }

            unset($this->fillable);
        }
        return $this;
    }

}
