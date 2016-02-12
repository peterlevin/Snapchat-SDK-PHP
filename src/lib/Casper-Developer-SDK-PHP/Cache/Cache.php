<?php

namespace Casper\Developer\Cache;

abstract class Cache {

    /**
     *
     * Load and return Data from Cache
     *
     * @return array Data from Cache
     */
    public abstract function loadCache();

    /**
     *
     * Save Data to Cache
     *
     * @param $data array Data to Save to Cache
     * @return mixed Save the Cache
     */
    public abstract function saveCache($data);

    /**
     *
     * Get cached Value
     *
     * @param $key string Key to save Value for
     * @return bool|array The stored Value or False
     */
    public function getValue($key){

        $data = $this->loadCache();

        if(isset($data[$key])){

            $value = $data["value"];
            $expires = $data["expires"];

            if($expires < time()){
                $this->clearValue($key);
                return false;
            }

            return $value;

        }

        return false;

    }

    /**
     *
     * Get cached Keys
     *
     * @return array Cached Keys
     */
    public function getKeys(){
        return array_keys($this->loadCache());
    }

    /**
     *
     * Clear Value from Cache
     *
     * @param $key string Key to Clear from Cache
     */
    public function clearValue($key){

        $data = $this->loadCache();

        if(isset($data[$key])){
            unset($data[$key]);
        }

        $this->saveCache($data);

    }

    /**
     *
     * Clear Values from Cache
     *
     * @param $keys array Keys to Clear from Cache
     */
    public function clearValues($keys = array()){

        $data = $this->loadCache();

        foreach($keys as $key){
            if(isset($data[$key])){
                unset($data[$key]);
            }
        }

        $this->saveCache($data);

    }

    /**
     *
     * Clear all Expired Values from Cache
     */
    public function clearExpired(){

        $data = $this->loadCache();

        foreach($data as $key => $values){
            if($values["expires"] < $this->getCurrentMillis()){
                unset($data[$key]);
            }
        }

        $this->saveCache($data);

    }

    /**
     * @param $key string Key to store Value of
     * @param $value array the Array Value to Store
     * @param $millis int Milliseconds to Cache data for
     */
    public function store($key, $value, $millis){

        $data = $this->loadCache();
        $expires = $this->getCurrentMillis() + $millis;

        $data[$key] = array(
            "value" => $value,
            "expires" => $expires
        );

    }

    /**
     *
     * Destroy the Cache
     *
     * @return boolean If the Cache was Destroyed
     */
    public abstract function destroyCache();

    /**
     *
     * Get Current Time in Milliseconds
     *
     * @return float Current Time in Milliseconds
     */
    public function getCurrentMillis(){
        return round(microtime(true) * 1000);
    }

}
