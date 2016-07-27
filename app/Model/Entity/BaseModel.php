<?php

namespace App\Model\Entity;

class BaseModel
{               
    public function toArray()
    {
        $array = array();
        $arrayProperties = get_object_vars($this);
        foreach ($arrayProperties as $key => $value) {
            $functionName = "get_" . $key;
            $array[$key] = $this->$functionName();
        }
        
        
        return $array;
    }
}
