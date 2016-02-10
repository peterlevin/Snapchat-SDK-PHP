<?php

namespace Snapchat\API\Request;

use Snapchat\API\Response\FindFriendsResponse;
use Snapchat\Snapchat;

class FindFriendsRequest extends BaseRequest {

    /**
     * @param $snapchat Snapchat
     * @param $country string Country Code. US, NZ, AU etc...
     * @param $query array Array of Names and Numbers to lookup. Format: array("number" => "name"); Maximum of 30 per Request.
     */
    public function __construct($snapchat, $country, $query){

        parent::__construct($snapchat);
        $this->addParam("countryCode", $country);
        $this->addParam("numbers", json_encode($query, JSON_FORCE_OBJECT));
        $this->addParam("should_recommend", "false");

    }

    public function getMethod(){
        return self::POST;
    }

    public function getEndpoint(){
        return "/bq/find_friends";
    }

    public function getResponseObject(){
        return new FindFriendsResponse();
    }

    /**
     * @return FindFriendsResponse
     * @throws \Exception
     */
    public function execute(){
        return parent::execute();
    }

}