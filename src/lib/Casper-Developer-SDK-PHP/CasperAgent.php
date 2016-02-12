<?php

namespace Casper\Developer;

use Casper\Developer\Exception\CasperException;
use Casper\Developer\Util\JWT;

abstract class CasperAgent {

    /**
     * @var string Your Casper API Key
     */
    private $apiKey;

    /**
     * @var string Your Casper API Secret
     */
    public $apiSecret;

    /**
     * The User-Agent used in requests to the Casper API
     */
    const USER_AGENT = "Casper-API-Developers-PHP/1.0.0";

    /*
     * The Casper Developer API URL.
     */
    const URL = "https://casper-api.herokuapp.com";

    /**
     * @var string
     */
    private $proxy;

    /**
     * @var boolean
     */
    private $verifyPeer = true;

    /**
     * Default cURL headers.
     */
    public static $CURL_HEADERS = array(

    );

    /**
     * Default cURL options.
     */
    public static $CURL_OPTIONS = array(
        CURLOPT_TIMEOUT => 10,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_USERAGENT => self::USER_AGENT,
        CURLOPT_HEADER => false,
        CURLINFO_HEADER_OUT => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "gzip"
    );

    public function setAPIKey($apiKey = null){
        $this->apiKey = $apiKey;
    }

    public function setAPISecret($apiSecret = null){
        $this->apiSecret = $apiSecret;
    }

    /**
     * @var $proxy string
     * @var $verifyPeer boolean
     */
    public function setProxy($proxy, $verifyPeer = null){
        $this->proxy = $proxy;
    }

    /**
     * @var $verifyPeer boolean
     */
    public function setVerifyPeer($verifyPeer){
        $this->verifyPeer = $verifyPeer;
    }

    /**
     * Performs a GET request.
     *
     * @param string $endpoint
     *   Endpoint to make GET request to.
     *
     * @param array $headers
     *   An array of parameters to send in the request.
     *
     * @return object
     *   The response data.
     *
     * @throws CasperException
     *   An exception is thrown if an error occurs.
     */
    public function get($endpoint, $headers = array()){
        return $this->request($endpoint, $headers);
    }

    /**
     * Performs a POST request.
     *
     * @param string $endpoint
     *   Endpoint to make POST request to.
     *
     * @param array $headers
     *   An array of parameters to send in the request.
     *
     * @param array $params
     *   An array of parameters to send in the request.
     *
     * @return object
     *   The response data.
     *
     * @throws CasperException
     *   An exception is thrown if an error occurs.
     */
    public function post($endpoint, $headers = array(), $params = array()){
        return $this->request($endpoint, $headers, $params, true);
    }

    /**
     * Performs a POST request.
     *
     * @param string $endpoint
     *   Endpoint to make request to.
     *
     * @param array $headers
     *   An array of parameters to send in the request.
     *
     * @param array $params
     *   An array of parameters to send in the request.
     *
     * @param boolean $post
     *   true to make a POST request, else a GET request will be made.
     *
     * @return array
     *   The JSON data returned from the API.
     *
     * @throws CasperException
     *   An exception is thrown if an error occurs.
     */
    public function request($endpoint, $headers = array(), $params = array(), $post = false){

        $ch = curl_init();

        if($headers == null){
            $headers = array();
        }

        if($params == null){
            $params = array();
        }

        $headers = array_merge(self::$CURL_HEADERS, $headers);

        $headers[] = "X-Casper-API-Key: " . $this->apiKey;

        curl_setopt_array($ch, self::$CURL_OPTIONS);
        curl_setopt($ch, CURLOPT_URL, self::URL . $endpoint);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->verifyPeer);

        if($this->proxy != null){
            curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
        }

        $jwt_params = array(
            "iat" => time()
        );

        $jwt = JWT::encode(array_merge($jwt_params, $params), $this->apiSecret, "HS256");

        if($post){
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
                "jwt" => $jwt
            )));
        }

        $response = curl_exec($ch);

        if(curl_errno($ch) == 60){
            curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . "/ca_bundle.crt");
            $response = curl_exec($ch);
        }

        if($response === FALSE){
            $error = curl_error($ch);
            curl_close($ch);
            throw new CasperException($error);
        }

        $json = json_decode($response, true);
        if($json == null){
            curl_close($ch);
            throw new CasperException(sprintf("[%s] Failed to decode response!\nResponse: %s", $endpoint, $response));
        }

        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if($code != 200){

            curl_close($ch);

            $json_code = $json["code"];
            $json_message = $json["message"];

            if(isset($json_code) && isset($json_message)){
                throw new CasperException(sprintf("Casper API Response: [%s] [%s] %s", $endpoint, $json_code, $json_message));
            } else {
                throw new CasperException(sprintf("Casper API Response: [%s] [%s] Unknown Error\nResponse: %s", $endpoint, $code, $response));
            }

        }

        curl_close($ch);

        return $json;

    }

}
