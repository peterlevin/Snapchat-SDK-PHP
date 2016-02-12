<?php

namespace Snapchat\API\Response;

class BaseResponse {

    /**
     *
     * Response Message
     *
     * @var string
     */
    private $message;

    /**
     *
     * Response Status
     *
     * @var int
     */
    private $status;

    /**
     *
     * Logged In
     *
     * @var boolean
     */
    private $logged;

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return boolean
     */
    public function isLogged()
    {
        return $this->logged;
    }

    /**
     * @param boolean $logged
     */
    public function setLogged($logged)
    {
        $this->logged = $logged;
    }

}