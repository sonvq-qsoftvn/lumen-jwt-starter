<?php

namespace App\Model;

use App\Model\BaseModel;

class PostContent extends BaseModel
{
    protected $id;
    protected $author_id;
    protected $content;
    protected $image_urls;
    protected $video_urls;
    protected $location;
    protected $date_created;
    protected $date_updated;

    public function get_id() {
        return $this->id;
    }

    public function get_author_id() {
        return $this->author_id;
    }

    public function get_content() {
        return $this->content;
    }

    public function get_image_urls() {
        return $this->image_urls;
    }

    public function get_video_urls() {
        return $this->video_urls;
    }

    public function get_location() {
        return $this->location;
    }

    public function get_date_created() {
        return $this->date_created;
    }

    public function get_date_updated() {
        return $this->date_updated;
    }

    public function set_id($id) {
        $this->id = $id;
        return $this;
    }

    public function set_author_id($author_id) {
        $this->author_id = $author_id;
        return $this;
    }

    public function set_content($content) {
        $this->content = $content;
        return $this;
    }

    public function set_image_urls($image_urls) {
        $this->image_urls = $image_urls;
        return $this;
    }

    public function set_video_urls($video_urls) {
        $this->video_urls = $video_urls;
        return $this;
    }

    public function set_location($location) {
        $this->location = $location;
        return $this;
    }

    public function set_date_created($date_created) {
        $this->date_created = $date_created;
        return $this;
    }

    public function set_date_updated($date_updated) {
        $this->date_updated = $date_updated;
        return $this;
    }
          
}
