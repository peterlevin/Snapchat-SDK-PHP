<?php

namespace Snapchat\API\Request;

use Snapchat\API\Response\RegisterResponse;
use Snapchat\Snapchat;

class RegisterRequest extends BaseRequest {

    private $email;
    private $password;

    /**
     * @param $snapchat Snapchat
     * @param $email string Email Address
     * @param $password string Password
     * @param $birthday string Birthday (format: YYYY-MM-DD)
     * @param $timezone string TimeZone {@link http://php.net/manual/en/timezones.php}
     */
    public function __construct($snapchat, $email, $password, $birthday, $timezone){

        parent::__construct($snapchat);

        $this->snapchat = $snapchat;

        $this->email = $email;
        $this->password = $password;

        $this->addParam("email", $email);
        $this->addParam("password", $password);
        $this->addParam("birthday", $birthday);
        $this->addParam("time_zone", $timezone);

    }

    public function getMethod(){
        return self::POST;
    }

    public function getEndpoint(){
        return "/loq/register";
    }

    public function getResponseObject(){
        return new RegisterResponse();
    }

    public function casperAuthCallback($endpointAuth){

        $params = $endpointAuth["params"];

        $deviceToken = $this->snapchat->getCachedDeviceToken();
        $deviceToken->initDeviceSignature($this->email, $this->password, $params["timestamp"], $params["req_token"]);

        $this->addParam("dsig", $deviceToken->getDeviceSignature());
        $this->addParam("dtoken1i", $deviceToken->getDeviceTokenIdentifier());

    }

    /**
     * @return RegisterResponse
     * @throws \Exception
     */
    public function execute(){
        return parent::execute();
    }

}