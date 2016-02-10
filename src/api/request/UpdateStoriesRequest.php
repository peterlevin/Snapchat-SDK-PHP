<?php

namespace Snapchat\API\Request;

use Snapchat\API\Response\Model\Story;
use Snapchat\Snapchat;
use Snapchat\Util\RequestUtil;

class UpdateStoriesRequest extends BaseRequest {

    private $story;

    private $screenshot = false;

    /**
     * @param $snapchat Snapchat
     * @param $story Story
     */
    public function __construct($snapchat, $story){

        parent::__construct($snapchat);
        $this->story = $story;

    }

    /**
     * Set whether this Story is being marked as Screenshot
     * @param $screenshot boolean
     */
    public function setScreenshot($screenshot){
        $this->screenshot = $screenshot;
    }

    public function getMethod(){
        return self::POST;
    }

    public function getEndpoint(){
        return "/bq/update_stories";
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

        $friend_stories = array();

        $friend_stories[] = array(
            "id" => $this->story->getId(),
            "screenshot_count" => $this->screenshot ? "1" : "0",
            "timestamp" => RequestUtil::getCurrentMillis()
        );

        $this->addParam("friend_stories", json_encode($friend_stories));

        return parent::execute();

    }

}