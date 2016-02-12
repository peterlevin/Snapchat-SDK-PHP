<?php

namespace Casper\Developer\Cache;

class MemoryCache extends Cache {

    /**
     * @var array Array to Store the Cache in
     */
    private $cache = array();

    public function loadCache(){
        return $this->cache;
    }

    public function saveCache($data){
        $this->cache = $data;
    }

    public function destroyCache(){
        $this->saveCache(array());
    }

}
