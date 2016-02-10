<?php

namespace Snapchat\API\Request;

use Snapchat\API\Response\ConversationAuthTokenResponse;
use Snapchat\API\Response\Model\Conversation;
use Snapchat\Util\RequestUtil;

class ConversationAuthTokenRequest extends BaseRequest {

    /**
     * @param $conversation Conversation
     */
    public function initWithConversation($conversation){
        $this->addParam("conversation_id", $conversation->getId());
    }

    public function initWithUsername($username){
        $this->addParam("conversation_id", RequestUtil::getConversationID($this->snapchat->getUsername(), $username));
    }

    public function getMethod(){
        return self::POST;
    }

    public function getEndpoint(){
        return "/loq/conversation_auth_token";
    }

    public function getResponseObject(){
        return new ConversationAuthTokenResponse();
    }

    /**
     * @return ConversationAuthTokenResponse
     * @throws \Exception
     */
    public function execute(){
        return parent::execute();
    }

}