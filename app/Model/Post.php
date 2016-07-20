<?php

namespace App\Model;

use App\Model\BaseModel;

class Post extends BaseModel
{
    protected $post;
    protected $comments;
    protected $likes;
    protected $shares;
    
    public function get_post() {
        return $this->post;
    }

    public function get_comments() {
        return $this->comments;
    }

    public function get_likes() {
        return $this->likes;
    }

    public function get_shares() {
        return $this->shares;
    }

    public function set_post($post) {
        $this->post = $post;
        return $this;
    }

    public function set_comments($comments) {
        $this->comments = $comments;
        return $this;
    }

    public function set_likes($likes) {
        $this->likes = $likes;
        return $this;
    }

    public function set_shares($shares) {
        $this->shares = $shares;
        return $this;
    }

    
    public static function getAll (array $where = array(), array $sort = array(), $limit = 10, $offset = 0) {
        
    }

}
