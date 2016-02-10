<?php

namespace Snapchat\API\Request;

use Snapchat\API\Constants;
use Snapchat\API\Framework\Request;
use Snapchat\API\Framework\Response;
use Snapchat\Snapchat;

abstract class BaseRequest extends Request {

    /**
     * @var Snapchat
     */
    public $snapchat;

    /**
     * @var Response
     */
    private $response;

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
     * @return int Get Response Code of Completed Request
     */
    public function getResponseCode(){
        return $this->response->getCode();
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
     * This method will be called before checking the Response is OK.
     * @param $response Response
     * @return bool If the Response was intercepted, and should stop being processed.
     */
    public function interceptResponse($response){
        return false;
    }

    /**
     * This method will be called before the Snapchat API request is made.
     * @param $endpointAuth object EndpointAuth from Casper Response
     */
    public function casperAuthCallback($endpointAuth){

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

        $this->casperAuthCallback($endpoint);

        $response = parent::execute();
        $this->response = $response;

        if($this->interceptResponse($response)){
            return null;
        }

        if(!$response->isOK()){
            throw new \Exception(sprintf("[%s] [%s] Request Failed!", $this->getEndpoint(), $response->getCode()));
        }

        if($this->parseResponse()){
            return $this->mapper->map($response->getData(), $this->getResponseObject());
        }

        return $response->getData();

    }

}