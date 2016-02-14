<?php

namespace Snapchat\API\Request;

use Casper\Developer\Exception\CasperException;
use Snapchat\API\Framework\Request;
use Snapchat\API\Response\LoginResponse;
use Snapchat\Snapchat;

class LoginRequest extends Request {

    private $url;

    private $username;
    private $password;

    private $pre_auth_token;

    /**
     * Snapchat Instance to Use
     * @var Snapchat
     */
    private $snapchat;

    public function __construct($snapchat, $username, $password, $pre_auth_token = null){

        parent::__construct();

        $this->snapchat = $snapchat;

        $this->setProxy($this->snapchat->getProxy());
        $this->setVerifyPeer($this->snapchat->shouldVerifyPeer());

        $this->username = $username;
        $this->password = $password;

        $this->pre_auth_token = $pre_auth_token;

    }

    public function getMethod(){
        return self::POST;
    }

    public function getUrl(){
        return $this->url;
    }

    /**
     *
     * Execute the Request
     *
     * @return LoginResponse the Login Response
     * @throws CasperException
     * @throws \Exception
     */
    public function execute(){

        $this->clearHeaders();
        $this->clearParams();

        $login = $this->snapchat->getCasper()->getSnapchatIOSLogin($this->username, $this->password, $this->snapchat->getDeviceTokenIdentifier(), $this->snapchat->getDeviceTokenVerifier(), $this->pre_auth_token);

        $this->url = $login["url"];

        foreach($login["headers"] as $key => $value){
            $this->addHeader($key, $value);
        }

        foreach($login["params"] as $key => $value){
            $this->addParam($key, $value);
        }

        $response = parent::execute();

        if(!$response->isOK()){
            throw new \Exception(sprintf("[%s] Login Failed!", $response->getCode()));
        }

        return $this->mapper->map($response->getData(), new LoginResponse());

    }

}