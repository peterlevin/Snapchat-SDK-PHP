<?php

namespace Snapchat\API\Request;

use Snapchat\Snapchat;

class LogoutRequest extends AuthenticatedBaseRequest {

    /**
     * @param $snapchat Snapchat
     */
    public function __construct($snapchat){

        parent::__construct($snapchat);
        $this->addParam("events", "[]");

    }

    public function getMethod(){
        return self::POST;
    }

    public function getEndpoint(){
        return "/ph/logout";
    }

    public function getResponseObject(){
        return null;
    }

    public function parseResponse(){
        return false;
    }

}