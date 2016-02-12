<?php

namespace Snapchat\API\Request;

use Casper\Developer\CasperDeveloperAPI;
use Casper\Developer\Exception\CasperException;
use Snapchat\API\Framework\Request;
use Snapchat\API\Response\LoginResponse;

class LoginRequest extends Request {

    private $url;

    private $username;
    private $password;

    private $dtoken1i;
    private $dtoken1v;

    private $pre_auth_token;

    /**
     * Casper Developer API instance
     * @var CasperDeveloperAPI
     */
    private $casper;

    public function __construct($casper, $username, $password, $dtoken1i = null, $dtoken1v = null, $pre_auth_token = null){

        parent::__construct();

        $this->casper = $casper;

        $this->username = $username;
        $this->password = $password;

        $this->dtoken1i = $dtoken1i;
        $this->dtoken1v = $dtoken1v;

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

        $login = $this->casper->getSnapchatIOSLogin($this->username, $this->password, $this->dtoken1i, $this->dtoken1v, $this->pre_auth_token);

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