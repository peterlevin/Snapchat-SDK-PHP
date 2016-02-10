<?php

namespace Snapchat\API\Request;

use Snapchat\API\Response\Model\ChatMessage;
use Snapchat\Snapchat;

class ConversationPostMessagesRequest extends BaseRequest {

    /**
     * @param $snapchat Snapchat
     * @param $messages ChatMessage[] Chat Messages to Send
     */
    public function __construct($snapchat, $messages){

        parent::__construct($snapchat);
        $this->addParam("messages", json_encode($messages));

    }

    public function getMethod(){
        return self::POST;
    }

    public function getEndpoint(){
        return "/loq/conversation_post_messages";
    }

    public function getResponseObject(){
        return null;
    }

    public function parseResponse(){
        return false;
    }

}