<?php

namespace Snapchat\API\Request;

use Snapchat\API\Constants;
use Snapchat\API\Framework\Request;
use Snapchat\Snapchat;

abstract class BaseRequest extends Request {

    /**
     * @var Snapchat
     */
    public $snapchat;

    /**
     * @param $snapchat Snapchat The Snapchat instance to make the Request with.
     */
    public function __construct($snapchat){

        parent::__construct();

        $this->addHeader("Accept-Language", "en");
        $this->addHeader("Accept-Locale", "en_US");

        $this->setSnapchat($snapchat);
        $this->setProxy($snapchat->getProxy());

    }

    /**
     * @param $snapchat Snapchat Snapchat Instance to use for this Request
     */
    public function setSnapchat($snapchat){
        $this->snapchat = $snapchat;
    }

    /**
     * @return string The API Endpoint
     */
    public abstract function getEndpoint();

    /**
     * @return object The class instance to map the JSON to.
     */
    public abstract function getResponseObject();

    public function getUrl(){
        return Constants::BASE_URL . $this->getEndpoint();
    }

    public function parseResponse(){
        return true;
    }

    /**
     *
     * Execute the Request
     *
     * @return object Response Object
     * @throws \CasperException
     * @throws \Exception
     */
    public function execute(){

        $endpoint = $this->snapchat->getCasper()->getSnapchatIOSEndpointAuth($this->snapchat->getUsername(), $this->snapchat->getAuthToken(), $this->getEndpoint());

        foreach($endpoint->headers as $key => $value){
            $this->addHeader($key, $value);
        }

        foreach($endpoint->params as $key => $value){
            $this->addParam($key, $value);
        }

        $response = parent::execute();

        if(!$response->isOK()){
            throw new \Exception(sprintf("[%s] [%s] Request Failed!", $this->getEndpoint(), $response->getCode()));
        }

        if($this->parseResponse()){
            return $this->mapper->map($response->getData(), $this->getResponseObject());
        }

        return $response->getData();

    }

}