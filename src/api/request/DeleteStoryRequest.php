<?php

namespace Snapchat\API\Request;

use Snapchat\API\Response\Model\Story;
use Snapchat\Snapchat;

class DeleteStoryRequest extends BaseRequest {

    /**
     * @param $snapchat Snapchat
     * @param $story Story
     */
    public function __construct($snapchat, $story){

        parent::__construct($snapchat);
        $this->addParam("story_id", $story->getId());

    }

    public function getMethod(){
        return self::POST;
    }

    public function getEndpoint(){
        return "/bq/delete_story";
    }

    public function getResponseObject(){
        return null;
    }

    public function parseResponse(){
        return false;
    }

}