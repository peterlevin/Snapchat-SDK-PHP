<?php

namespace Casper\Developer\Cache;

use Casper\Developer\Util\StringUtil;

class EndpointCache {

    /**
     * @var Cache
     */
    private $cache;

    /**
     * @param $cache Cache cache used to Cache Endpoints in
     */
    public function __construct($cache){
        $this->cache = $cache;
    }

    /**
     * @param $username string Username
     * @return string
     */
    public function getKey($username){
        return sprintf("endpointauth_%s", $username);
    }

    /**
     * @param $username string Username
     * @param $endpoint string Endpoint
     * @return string
     */
    public function getEndpointKey($username, $endpoint){
        return sprintf("%s_%s", $this->getKey($username), $endpoint);
    }

    /**
     * @param $username string Username
     * @param $endpoint string Endpoint
     * @return bool|object
     */
    public function getEndpoint($username, $endpoint){
        return $this->cache->getValue($this->getEndpointKey($username, $endpoint));
    }

    /**
     * @param $username string Username
     * @param $endpoint string Endpoint
     * @param $endpointAuth array Values from Server
     * @param $cacheMillis int Milliseconds to Cache for
     * @return bool
     */
    public function cacheEndpoint($username, $endpoint, $endpointAuth, $cacheMillis){
        $this->cache->store($this->getEndpointKey($username, $endpoint), $endpointAuth, $cacheMillis);
    }

    /**
     * @param $username string Username
     */
    public function clearEndpoints($username){

        $keyPrefix = $this->getKey($username);
        $keysToClear = array();

        foreach($this->cache->getKeys() as $key){
            if(StringUtil::startsWith($key, $keyPrefix)){
                $keysToClear[] = $key;
            }
        }

        $this->cache->clearValues($keysToClear);

    }

}
