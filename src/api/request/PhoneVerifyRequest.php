<?php

namespace Snapchat\API\Request;

use Snapchat\Crypto\DeviceToken;
use Snapchat\API\Response\PhoneVerifyResponse;

class PhoneVerifyRequest extends BaseRequest {

    public function updatePhoneNumber($country, $number){

        $this->addParam("action", "updatePhoneNumber");
        $this->addParam("countryCode", $country);
        $this->addParam("method", "text");
        $this->addParam("password", $this->snapchat->getUsername());
        $this->addParam("phoneNumber", $number);

    }

    public function updatePhoneNumberWithCall($country, $number){

        $this->addParam("action", "updatePhoneNumberWithCall");
        $this->addParam("countryCode", $country);
        $this->addParam("method", "call");
        $this->addParam("password", $this->snapchat->getUsername());
        $this->addParam("phoneNumber", $number);

    }

    public function verifyPhoneNumber($code){

        $this->addParam("action", "verifyPhoneNumber");
        $this->addParam("code", $code);
        $this->addParam("password", $this->snapchat->getUsername());
        $this->addParam("skipConfirmation", true);
        $this->addParam("type", "DEFAULT_TYPE");

    }

    public function getMethod(){
        return self::POST;
    }

    public function getEndpoint(){
        return "/bq/phone_verify";
    }

    public function getResponseObject(){
        return new PhoneVerifyResponse();
    }

    public function casperAuthCallback($auth){

        $timestamp = $auth->params->timestamp;
        $req_token = $auth->params->req_token;

        $device_token = new DeviceToken($this->snapchat->getDeviceTokenIdentifier(), $this->snapchat->getDeviceTokenVerifier());
        $device_token->initDeviceSignature($this->snapchat->getUsername(), $this->snapchat->getUsername(), $timestamp, $req_token);

        $this->addParam("dsig", $device_token->getDeviceSignature());
        $this->addParam("dtoken1i", $device_token->getDeviceTokenIdentifier());

    }

    /**
     * @return PhoneVerifyResponse
     * @throws \Exception
     */
    public function execute(){
        return parent::execute();
    }

}