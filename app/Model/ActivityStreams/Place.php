<?php

namespace App\Model\ActivityStreams;

use App\Model\ActivityStreams\Object;

class Place extends Object {
    protected $type = 'Place';
    protected $accuracy;
    protected $altitude;
    protected $latitude;
    protected $longitude;
    protected $radius;
    protected $units;
    
    public function get_accuracy() {
        return $this->accuracy;
    }

    public function get_altitude() {
        return $this->altitude;
    }

    public function get_latitude() {
        return $this->latitude;
    }

    public function get_longitude() {
        return $this->longitude;
    }

    public function get_radius() {
        return $this->radius;
    }

    public function get_units() {
        return $this->units;
    }

    public function set_accuracy($accuracy) {
        $this->accuracy = $accuracy;
        return $this;
    }

    public function set_altitude($altitude) {
        $this->altitude = $altitude;
        return $this;
    }

    public function set_latitude($latitude) {
        $this->latitude = $latitude;
        return $this;
    }

    public function set_longitude($longitude) {
        $this->longitude = $longitude;
        return $this;
    }

    public function set_radius($radius) {
        $this->radius = $radius;
        return $this;
    }

    public function set_units($units) {
        $this->units = $units;
        return $this;
    }

    
    protected $fillable = ['type', 'name', 'longitude', 'latitude', 'content'];
}
