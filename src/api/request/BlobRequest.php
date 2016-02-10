<?php

namespace Snapchat\API\Request;

use Snapchat\API\Response\Model\Snap;
use Snapchat\Snapchat;

class BlobRequest extends BaseRequest {

    /**
     * @param $snapchat Snapchat
     * @param $snap Snap
     */
    public function __construct($snapchat, $snap){

        parent::__construct($snapchat);
        $this->addParam("id", $snap->getId());

    }

    public function getMethod(){
        return self::POST;
    }

    public function getEndpoint(){
        return "/bq/blob";
    }

    public function getResponseObject(){
        return null;
    }

    public function parseResponse(){
        return false;
    }

}