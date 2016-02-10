<?php

include_once dirname(__FILE__) . '/lib/JWT.php';
include_once dirname(__FILE__) . '/CasperAgent.php';
include_once dirname(__FILE__) . '/CasperCache.php';
include_once dirname(__FILE__) . '/CasperException.php';

/**
 * @file
 * PHP implementation of the Casper Developers API.
 */
class CasperDevelopersAPI extends CasperAgent {

    /**
     * @var CasperCache
     */
    private $cache;

    /**
     * @var CasperCache
     */
    static $default_cache;

    /**
     * @param $api_key string Casper Developers API Key
     * @param $api_secret string Casper Developers API Secret
     * @param $cache CasperCache Cache used to temporarily hold Request Auth
     */
    public function __construct($api_key, $api_secret, $cache = null){

        $this->setAPIKey($api_key);
        $this->setAPISecret($api_secret);

        if($cache != null){
            $this->setCache($cache);
        } else {
            self::$default_cache = new CasperCache();
            $this->setCache(self::$default_cache);
        }

    }

    /**
     *
     * Set Cache that holds EndpointAuth
     *
     * @var CasperCache
     */
    public function setCache($cache){
        $this->cache = $cache;
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

        $response = parent::post("/snapchat/ios/login", null, $params);

        if(!isset($response->headers)){
            throw new CasperException("Headers not found in Response");
        }

        if(!isset($response->params)){
            throw new CasperException("Params not found in Response");
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

        if($this->cache != null){
            if($cached_response = $this->cache->get($username, $endpoint)){
                return $cached_response;
            }
        }

        $response = parent::post("/snapchat/ios/endpointauth", null, array(
            "username" => $username,
            "auth_token" => $auth_token,
            "endpoint" => $endpoint
        ));

        if(!isset($response->endpoints)){
            throw new CasperException("Endpoints Object not found in Response");
        }

        if($this->cache != null){

            $endpoints = $response->endpoints;
            $settings = $response->settings;

            if($settings->force_expire_cached){
                $this->cache->clearCacheForUsername($username);
            }

            foreach($endpoints as $endpoint_auth){
                $this->cache->cache($username, $endpoint_auth->endpoint, $endpoint_auth, $endpoint_auth->cache_millis);
            }

        }

        foreach($response->endpoints as $endpoint_auth){
            if($endpoint_auth->endpoint == $endpoint){
                return $endpoint_auth;
            }
        }

        return null;

    }

}
