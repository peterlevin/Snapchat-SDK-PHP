<?php

namespace Snapchat\API\Request;

use Snapchat\API\Response\Model\Conversation;
use Snapchat\Snapchat;

class ClearConversationRequest extends BaseRequest {

    /**
     * @param $snapchat Snapchat
     * @param $conversation Conversation
     */
    public function __construct($snapchat, $conversation){

        parent::__construct($snapchat);
        $this->addParam("conversation_id", $conversation->getId());

    }

    public function getMethod(){
        return self::POST;
    }

    public function getEndpoint(){
        return "/loq/clear_conversation";
    }

    public function getResponseObject(){
        return null;
    }

    public function parseResponse(){
        return false;
    }

}