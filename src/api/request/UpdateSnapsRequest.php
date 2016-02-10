<?php

namespace Snapchat\API\Request;

use Snapchat\API\Response\Model\Snap;
use Snapchat\Snapchat;

class UpdateSnapsRequest extends BaseRequest {

    private $snap;

    private $replayed = false;
    private $screenshot = false;

    /**
     * @param $snapchat Snapchat
     * @param $snap Snap
     */
    public function __construct($snapchat, $snap){

        parent::__construct($snapchat);
        $this->snap = $snap;

        $this->addParam("added_friends_timestamp", $snapchat->getCachedUpdatesResponse()->getAddedFriendsTimestamp());

    }

    /**
     * Set whether this Snap is being marked as Replayed
     * @param $replayed boolean
     */
    public function setReplayed($replayed){
        $this->replayed = $replayed;
    }

    /**
     * Set whether this Snap is being marked as Screenshot
     * @param $screenshot boolean
     */
    public function setScreenshot($screenshot){
        $this->screenshot = $screenshot;
    }

    public function getMethod(){
        return self::POST;
    }

    public function getEndpoint(){
        return "/bq/update_snaps";
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

        $viewed_time = $this->snap->getViewTime() * 1000;

        $json = json_encode(array(
            $this->snap->getId() => array(
                "c" => $this->screenshot ? "1" : "0",
                "replayed" => $this->replayed ? "1" : "0",
                "sv" => $viewed_time,
                "t" => time(),
            )
        ));

        $this->addParam("json", $json);

        return parent::execute();

    }

}