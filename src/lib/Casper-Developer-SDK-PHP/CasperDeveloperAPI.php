<?php

namespace Casper\Developer;

use Casper\Developer\Cache\Cache;
use Casper\Developer\Cache\EndpointCache;
use Casper\Developer\Cache\MemoryCache;
use Casper\Developer\Exception\CasperException;

class CasperDeveloperAPI extends CasperAgent {

    /**
     * @var Cache
     */
    private $cache;

    /**
     * @var EndpointCache
     */
    private $endpointCache;

    /**
     * @param $apiKey string Casper Developer API Key
     * @param $apiSecret string Casper Developer API Secret
     * @param $cache Cache for storing Data
     * @param $endpointCache EndpointCache for storing Endpoint Auth
     */
    public function __construct($apiKey, $apiSecret, $cache = null, $endpointCache = null){

        $this->setAPIKey($apiKey);
        $this->setAPISecret($apiSecret);

        if($cache == null){
            $cache = new MemoryCache();
        }

        if($endpointCache == null){
            $endpointCache = new EndpointCache($cache);
        }

        $this->setCache($cache);
        $this->setEndpointCache($endpointCache);

    }

    /**
     * @var $cache Cache
     */
    public function setCache($cache){
        $this->cache = $cache;
    }

    /**
     * @return Cache
     */
    public function getCache(){
        return $this->cache;
    }

    /**
     * @var $endpointCache EndpointCache
     */
    public function setEndpointCache($endpointCache){
        $this->endpointCache = $endpointCache;
    }

    /**
     * @return EndpointCache
     */
    public function getEndpointCache(){
        return $this->endpointCache;
    }

    /**
     * Fetches all Headers and Parameters required to make a Snapchat iOS Login request
     *
     * @param string $username
     *   Your Snapchat Username
     *
     * @param string $password
     *   Your Snapchat Password or 2Factor Authentication Code
     *
     * @param string $dtoken1i
     *   Optional DeviceToken Identifier (From initial Login response or Device Token request)
     *
     * @param string $dtoken1v
     *   Optional DeviceToken Verifier (From initial Login response or Device Token request)
     *
     * @param string $pre_auth_token
     *   Optional PreAuthToken for 2Factor Authentication (From initial Login response)
     *
     * @return object
     *   Response Object
     *
     * @throws CasperException
     *   An exception is thrown if an error occurs.
     */
    public function getSnapchatIOSLogin($username, $password, $dtoken1i = null, $dtoken1v = null, $pre_auth_token = null){

        $params = array(
            "username" => $username,
            "password" => $password
        );

        if($dtoken1i != null){
            $params["dtoken1i"] = $dtoken1i;
        }

        if($dtoken1v != null){
            $params["dtoken1v"] = $dtoken1v;
        }

        if($pre_auth_token != null){
            $params["pre_auth_token"] = $pre_auth_token;
        }

        //Make request to Casper API
        $response = parent::post("/snapchat/ios/login", null, $params);

        //Make sure Headers are in Response
        if(!isset($response["headers"])){
            throw new CasperException("Missing: headers");
        }

        //Make sure Params are in Response
        if(!isset($response["params"])){
            throw new CasperException("Missing: params");
        }

        return $response;

    }

    /**
     * Fetches all Headers and Parameters required to make a Snapchat API request to the Endpoint provided.
     * Additional Endpoints may be returned at the same time.
     *
     * @param string $username
     *   Your Snapchat Username
     *
     * @param string $auth_token
     *   Your Snapchat AuthToken
     *
     * @param string $endpoint
     *   Snapchat API Endpoint
     *
     * @return object
     *   Response Object
     *
     * @throws CasperException
     *   An exception is thrown if an error occurs.
     */
    public function getSnapchatIOSEndpointAuth($username, $auth_token, $endpoint){

        //Check cache for this Endpoint
        if($this->endpointCache != null){
            if($cachedEndpoint = $this->endpointCache->getEndpoint($username, $endpoint)){
                return $cachedEndpoint;
            }
        }

        //Make request to Casper API
        $response = parent::post("/snapchat/ios/endpointauth", null, array(
            "username" => $username,
            "auth_token" => $auth_token,
            "endpoint" => $endpoint
        ));

        $endpoints = $response["endpoints"];
        $settings = $response["settings"];

        //Make sure Endpoints are in Response
        if(!isset($endpoints)){
            throw new CasperException("Missing: endpoints");
        }

        if($this->endpointCache != null){

            if(isset($settings)){

                //Clear Cached Endpoints for Username
                if($settings["force_expire_cached"]){
                    $this->endpointCache->clearEndpoints($username);
                }

            }

            //Cache Endpoints from Response
            foreach($endpoints as $endpointAuth){
                $this->endpointCache->cacheEndpoint($username, $endpointAuth["endpoint"], $endpointAuth, $endpointAuth["cache_millis"]);
            }

        }

        //Return EndpointAuth
        foreach($endpoints as $endpointAuth){
            if($endpointAuth["endpoint"] == $endpoint){
                return $endpointAuth;
            }
        }

        return null;

    }

}
