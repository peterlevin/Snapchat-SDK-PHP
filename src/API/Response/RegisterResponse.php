<?php

namespace Snapchat\API\Response;

class RegisterResponse extends BaseResponse {

    /**
     * Suggested Usernames
     * @var string[]
     */
    private $username_suggestions;

    /**
     * Email Address
     * @var string
     */
    private $email;

    /**
     * @var boolean
     */
    private $should_send_text_to_verify_number;

    /**
     * Auth Token
     * @var string
     */
    private $auth_token;

    /**
     * User ID
     * @var string
     */
    private $user_id;

    /**
     * Default Username
     * @var string
     */
    private $default_username;

    /**
     * Default Username Status
     * @var boolean
     */
    private $default_username_status;

    /**
     * @return \string[]
     */
    public function getUsernameSuggestions()
    {
        return $this->username_suggestions;
    }

    /**
     * @param \string[] $username_suggestions
     */
    public function setUsernameSuggestions($username_suggestions)
    {
        $this->username_suggestions = $username_suggestions;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return boolean
     */
    public function isShouldSendTextToVerifyNumber()
    {
        return $this->should_send_text_to_verify_number;
    }

    /**
     * @param boolean $should_send_text_to_verify_number
     */
    public function setShouldSendTextToVerifyNumber($should_send_text_to_verify_number)
    {
        $this->should_send_text_to_verify_number = $should_send_text_to_verify_number;
    }

    /**
     * @return string
     */
    public function getAuthToken()
    {
        return $this->auth_token;
    }

    /**
     * @param string $auth_token
     */
    public function setAuthToken($auth_token)
    {
        $this->auth_token = $auth_token;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param string $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return string
     */
    public function getDefaultUsername()
    {
        return $this->default_username;
    }

    /**
     * @param string $default_username
     */
    public function setDefaultUsername($default_username)
    {
        $this->default_username = $default_username;
    }

    /**
     * @return boolean
     */
    public function isDefaultUsernameStatus()
    {
        return $this->default_username_status;
    }

    /**
     * @param boolean $default_username_status
     */
    public function setDefaultUsernameStatus($default_username_status)
    {
        $this->default_username_status = $default_username_status;
    }

}