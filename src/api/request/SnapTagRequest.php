<?php

namespace Snapchat\API\Request;

use Snapchat\Snapchat;

class SnapTagRequest extends BaseRequest {

    /**
     * @param $snapchat Snapchat
     * @param $qrpath string
     */
    public function __construct($snapchat, $qrpath){

        parent::__construct($snapchat);
        $this->addParam("image", $qrpath);

    }

    public function getMethod(){
        return self::POST;
    }

    public function getEndpoint(){
        return "/bq/snaptag_download";
    }

    public function getResponseObject(){
        return null;
    }

    public function parseResponse(){
        return false;
    }

}