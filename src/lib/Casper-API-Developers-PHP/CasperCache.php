<?php

class CasperCache {

    const KEY_DATA = "data";
    const KEY_CACHE_UNTIL = "cache_until";

    private $cache = array();

    public function cache($username, $endpoint, $data, $cache_millis){
        $this->cache[$username][$endpoint] = array(
            self::KEY_CACHE_UNTIL => time() + $cache_millis,
            self::KEY_DATA => $data
        );
    }

    public function get($username, $endpoint){

        if(isset($this->cache[$username][$endpoint])){

            $cached_auth = $this->cache[$username][$endpoint];
            if($cached_auth[self::KEY_CACHE_UNTIL] > time()){
                return $cached_auth[self::KEY_DATA];
            }

        }

        return false;

    }

    public function clearCache(){
        $this->cache = array();
    }

    public function clearCacheForUsername($username){
        unset($this->cache[$username]);
    }

}
