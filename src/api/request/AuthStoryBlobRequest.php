<?php

namespace Snapchat\API\Request;

use Snapchat\API\Response\Model\Story;
use Snapchat\Crypto\StoryCrypto;
use Snapchat\Snapchat;

class AuthStoryBlobRequest extends BaseRequest {

    private $story;

    /**
     * @param $snapchat Snapchat
     * @param $story Story
     */
    public function __construct($snapchat, $story){

        parent::__construct($snapchat);

        $this->story = $story;
        $this->addParam("story_id", $story->getMediaId());

    }

    public function getMethod(){
        return self::POST;
    }

    public function getEndpoint(){
        return "/bq/auth_story_blob";
    }

    public function getResponseObject(){
        return null;
    }

    public function parseResponse(){
        return false;
    }

    /**
     * @return object
     * @throws \Exception
     */
    public function execute(){
        return StoryCrypto::decryptStory(parent::execute(), $this->story->getMediaKey(), $this->story->getMediaIv());
    }

}