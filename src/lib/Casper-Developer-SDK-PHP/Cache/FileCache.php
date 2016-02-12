<?php

namespace Casper\Developer\Cache;

class FileCache extends Cache {

    /**
     * @var string File to Store the Cache in
     */
    public $file;

    /**
     * @param $file string File to Store the Cache in
     */
    public function __construct($file){

        $this->file = $file;

        if(!file_exists($this->file)){
            touch($file);
        }

    }

    public function loadCache(){

        $data = file_get_contents($this->file, LOCK_SH);

        if(empty($data)){
            return array();
        }

        return json_decode($data, true);

    }

    public function saveCache($data){

        $data = json_encode($data, JSON_FORCE_OBJECT);

        file_put_contents($this->file, $data, LOCK_EX);

    }

    public function getExpires($key){

        $data = $this->loadCache();

        if(isset($data[$key])){
            return $data[$key]["expires"];
        }

        return 0;

    }

    public function getValue($key){

        $data = $this->loadCache();

        if(isset($data[$key])){

            $value = $data[$key]["value"];
            $expires = $data[$key]["expires"];

            if($expires < $this->getCurrentMillis()){
                $this->clearValue($key);
                return false;
            }

            return $value;

        }

        return false;

    }

    public function clearValue($key){

        $data = $this->loadCache();

        if(isset($data[$key])){
            unset($data[$key]);
        }

        $this->saveCache($data);

    }

    public function store($key, $value, $millis){

        $data = $this->loadCache();
        $expires = $this->getCurrentMillis() + $millis;

        $data[$key] = array(
            "value" => $value,
            "expires" => $expires
        );

        $this->saveCache($data);

    }

    public function destroyCache(){
        unlink($this->file);
    }

}
