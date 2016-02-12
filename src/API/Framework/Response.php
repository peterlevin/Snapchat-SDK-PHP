<?php


namespace Snapchat\API\Framework;

class Response {

    const OK = 200;
    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const FORBIDDEN = 403;

    /**
     * @var int Response Code;
     */
    private $code;

    /**
     * @var object Response Data;
     */
    private $data;

    public function __construct($code, $data){
        $this->code = $code;
        $this->data = $data;
    }

    /**
     *
     * Get Response Code
     *
     * @return int Response Code
     */
    public function getCode(){
        return $this->code;
    }

    /**
     *
     * Get Response Data
     *
     * @return object Response Data
     */
    public function getData(){
        return $this->data;
    }

    /**
     *
     * Check if the Response was 200 OK
     *
     * @return bool
     */
    public function isOK(){
        return $this->code == self::OK;
    }

}