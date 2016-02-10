<?php


namespace Snapchat\API\Framework;

use JsonMapper;
use Snapchat\API\Framework\Curl\Curl;

abstract class Request {

    const GET = 0;
    const POST = 1;

    /**
     * Used for Mapping response Json to Class instances.
     * @var JsonMapper
     */
    public $mapper;

    /**
     * Proxy used for Requests
     * @var string
     */
    private $proxy;

    /**
     * @var array HTTP Headers to send in Request
     */
    private $headers = array();

    /**
     * @var array Parameters to send in Request
     */
    private $params = array();

    /**
     * @var RequestFile[] Files to upload in Request
     */
    private $files = array();

    /**
     * @return string Request Method
     */
    public abstract function getMethod();

    /**
     * @return string Request Url
     */
    public abstract function getUrl();

    public function __construct(){
        $this->mapper = new JsonMapper();
    }

    /**
     * Set Proxy to be used for Requests
     * @param $proxy string
     */
    public function setProxy($proxy){
        $this->proxy = $proxy;
    }

    /**
     *
     * Add Header to the Request
     *
     * @param $key string Header Key
     * @param $value string Header Value
     */
    public function addHeader($key, $value){
        $this->headers[$key] = $value;
    }

    /**
     *
     * Add Parameter to the Request
     *
     * @param $key string Parameter Key
     * @param $value string Parameter Value
     */
    public function addParam($key, $value){
        $this->params[$key] = $value;
    }

    /**
     *
     * Add File to the Request
     *
     * @param $key string File Key
     * @param $file RequestFile
     */
    public function addFile($key, $file){
        $this->params[$key] = new \CURLFile($file->getPath(), $file->getMime(), $file->getName());
    }

    /**
     * @return array Request Headers
     */
    public function getHeaders(){
        return $this->headers;
    }

    /**
     * @return array Request Parameters
     */
    public function getParams(){
        return $this->params;
    }

    /**
     * @return RequestFile[] Request Files
     */
    /*
    public function getFiles(){
        return $this->files;
    }
    */

    public function clearHeaders(){
        return $this->headers = array();
    }

    public function clearParams(){
        return $this->params = array();
    }

    /*
    public function clearFiles(){
        return $this->files = array();
    }
    */

    /**
     *
     * Execute the Request
     *
     * @return Response The Response
     * @throws \Exception
     */
    public function execute(){

        $data = null;
        $curl = new Curl();

        if($this->proxy != null){
            $curl->setOpt(CURLOPT_PROXY, $this->proxy);
        }

        foreach($this->getHeaders() as $key => $value){
            $curl->setHeader($key, $value);
        }

        $error_format = "Snapchat Request failed: [%s] [%s] %s";

        switch($this->getMethod()){

            case self::GET: {

                $data = $curl->get($this->getUrl(), $this->getParams());

                if($curl->error){
                    throw new \Exception(sprintf($error_format, "GET", $this->getUrl(), $curl->errorMessage));
                }

                break;

            }

            case self::POST: {

                $data = $curl->post($this->getUrl(), $this->getParams());

                if($curl->error){
                    throw new \Exception(sprintf($error_format, "POST", $this->getUrl(), $curl->errorMessage));
                }

                break;

            }

            default: {
                throw new \Exception(sprintf($error_format, "POST", $this->getUrl(), "Unsupported Request Method"));
            }

        }

        return new Response($curl->httpStatusCode, $data);

    }

}