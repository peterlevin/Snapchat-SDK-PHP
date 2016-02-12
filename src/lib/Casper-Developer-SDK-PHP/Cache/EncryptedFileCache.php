<?php

namespace Casper\Developer\Cache;

class EncryptedFileCache extends FileCache {

    /**
     * @var string Key to Encrypt File with
     */
    private $encryptionKey;

    /**
     * @param $file string File to Store the Cache in
     * @param $encryptionKey string Key to Encrypt File with
     */
    public function __construct($file, $encryptionKey){

        parent::__construct($file);

        $this->encryptionKey = $encryptionKey;

    }

    public function loadCache(){

        $data = file_get_contents($this->file, LOCK_SH);

        if(empty($data)){
            return array();
        }

        if($this->encryptionKey != null){
            $data = $this->decryptData($data);
        }

        return json_decode($data, true);

    }

    public function saveCache($data){

        $data = json_encode($data, JSON_FORCE_OBJECT);

        if($this->encryptionKey != null){
            $data = $this->encryptData($data);
        }

        file_put_contents($this->file, $data, LOCK_EX);

    }

    public function getHashedKey(){
        return hash("sha256", $this->encryptionKey, true);
    }

    public function encryptData($data){
        $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
        return base64_encode($iv . mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->getHashedKey(), $data, MCRYPT_MODE_CBC, $iv));
    }

    public function decryptData($data){

        $data = base64_decode($data);

        $iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));
        $data = substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));

        return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->getHashedKey(), $data, MCRYPT_MODE_CBC, $iv), "\0");

    }

}
