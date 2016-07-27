<?php

namespace App\Model\ActivityStreams;
use App\Model\ActivityStreams\BaseActivityStreams;

class Object extends BaseActivityStreams {
    protected $type = 'Object';
    protected $id;
    protected $name;
    protected $attachment;
    protected $attributedTo;
    protected $audience;
    protected $content;
    protected $context;
    protected $endTime;
    protected $generator;
    protected $icon;
    protected $image;
    protected $inReplyTo;
    protected $location;
    protected $preview;
    protected $published;
    protected $replies;
    protected $startTime;
    protected $summary;
    protected $tag;
    protected $updated;
    protected $url;
    protected $to;
    protected $bto;
    protected $cc;
    protected $bcc;
    protected $mediaType;
    protected $duration;
    
    public function get_type() {
        return $this->type;
    }

    public function get_id() {
        return $this->id;
    }

    public function get_name() {
        return $this->name;
    }

    public function get_attachment() {
        return $this->attachment;
    }

    public function get_attributedTo() {
        return $this->attributedTo;
    }

    public function get_audience() {
        return $this->audience;
    }

    public function get_content() {
        return $this->content;
    }

    public function get_context() {
        return $this->context;
    }

    public function get_endTime() {
        return $this->endTime;
    }

    public function get_generator() {
        return $this->generator;
    }

    public function get_icon() {
        return $this->icon;
    }

    public function get_image() {
        return $this->image;
    }

    public function get_inReplyTo() {
        return $this->inReplyTo;
    }

    public function get_location() {
        return $this->location;
    }

    public function get_preview() {
        return $this->preview;
    }

    public function get_published() {
        return $this->published;
    }

    public function get_replies() {
        return $this->replies;
    }

    public function get_startTime() {
        return $this->startTime;
    }

    public function get_summary() {
        return $this->summary;
    }

    public function get_tag() {
        return $this->tag;
    }

    public function get_updated() {
        return $this->updated;
    }

    public function get_url() {
        return $this->url;
    }

    public function get_to() {
        return $this->to;
    }

    public function get_bto() {
        return $this->bto;
    }

    public function get_cc() {
        return $this->cc;
    }

    public function get_bcc() {
        return $this->bcc;
    }

    public function get_mediaType() {
        return $this->mediaType;
    }

    public function get_duration() {
        return $this->duration;
    }

    public function set_type($type) {
        $this->type = $type;
        return $this;
    }

    public function set_id($id) {
        $this->id = $id;
        return $this;
    }

    public function set_name($name) {
        $this->name = $name;
        return $this;
    }

    public function set_attachment($attachment) {
        $this->attachment = $attachment;
        return $this;
    }

    public function set_attributedTo($attributedTo) {
        $this->attributedTo = $attributedTo;
        return $this;
    }

    public function set_audience($audience) {
        $this->audience = $audience;
        return $this;
    }

    public function set_content($content) {
        $this->content = $content;
        return $this;
    }

    public function set_context($context) {
        $this->context = $context;
        return $this;
    }

    public function set_endTime($endTime) {
        $this->endTime = $endTime;
        return $this;
    }

    public function set_generator($generator) {
        $this->generator = $generator;
        return $this;
    }

    public function set_icon($icon) {
        $this->icon = $icon;
        return $this;
    }

    public function set_image($image) {
        $this->image = $image;
        return $this;
    }

    public function set_inReplyTo($inReplyTo) {
        $this->inReplyTo = $inReplyTo;
        return $this;
    }

    public function set_location($location) {
        $this->location = $location;
        return $this;
    }

    public function set_preview($preview) {
        $this->preview = $preview;
        return $this;
    }

    public function set_published($published) {
        $this->published = $published;
        return $this;
    }

    public function set_replies($replies) {
        $this->replies = $replies;
        return $this;
    }

    public function set_startTime($startTime) {
        $this->startTime = $startTime;
        return $this;
    }

    public function set_summary($summary) {
        $this->summary = $summary;
        return $this;
    }

    public function set_tag($tag) {
        $this->tag = $tag;
        return $this;
    }

    public function set_updated($updated) {
        $this->updated = $updated;
        return $this;
    }

    public function set_url($url) {
        $this->url = $url;
        return $this;
    }

    public function set_to($to) {
        $this->to = $to;
        return $this;
    }

    public function set_bto($bto) {
        $this->bto = $bto;
        return $this;
    }

    public function set_cc($cc) {
        $this->cc = $cc;
        return $this;
    }

    public function set_bcc($bcc) {
        $this->bcc = $bcc;
        return $this;
    }

    public function set_mediaType($mediaType) {
        $this->mediaType = $mediaType;
        return $this;
    }

    public function set_duration($duration) {
        $this->duration = $duration;
        return $this;
    }

}
