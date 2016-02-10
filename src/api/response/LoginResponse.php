<?php

namespace Snapchat\API\Response;

class LoginResponse extends BaseResponse {

    /**
     * Updates Response
     * @var UpdatesResponse
     */
    private $updates_response;

    /**
     * Friends Response
     * @var FriendsResponse
     */
    private $friends_response;

    /**
     * Stories Response
     * @var StoriesResponse
     */
    private $stories_response;

    /**
     * Conversations Response
     * @var Model\Conversation[]
     */
    private $conversations_response;

    /**
     * Messaging Gateway Info
     * @var Model\MessagingGatewayInfo
     */
    private $messaging_gateway_info;

    /**
     * Device Token Identifier
     * @var string
     */
    private $dtoken1i;

    /**
     * Device Token Verifier
     * @var string
     */
    private $dtoken1v;

    /**
     * Two Factor Auth Needed
     * @var boolean
     */
    private $two_fa_needed;

    /**
     * Pre AuthToken
     * @var string
     */
    private $pre_auth_token;

    /**
     * Phone Number
     * @var string
     */
    private $phone_number;

    /**
     * Snap Privacy
     * @var int
     */
    private $snap_p;

    /**
     * Story Privacy
     * @var string
     */
    private $story_privacy;

    /**
     * @return UpdatesResponse
     */
    public function getUpdatesResponse()
    {
        return $this->updates_response;
    }

    /**
     * @param UpdatesResponse $updates_response
     */
    public function setUpdatesResponse($updates_response)
    {
        $this->updates_response = $updates_response;
    }

    /**
     * @return FriendsResponse
     */
    public function getFriendsResponse()
    {
        return $this->friends_response;
    }

    /**
     * @param FriendsResponse $friends_response
     */
    public function setFriendsResponse($friends_response)
    {
        $this->friends_response = $friends_response;
    }

    /**
     * @return StoriesResponse
     */
    public function getStoriesResponse()
    {
        return $this->stories_response;
    }

    /**
     * @param StoriesResponse $stories_response
     */
    public function setStoriesResponse($stories_response)
    {
        $this->stories_response = $stories_response;
    }

    /**
     * @return Model\Conversation[]
     */
    public function getConversationsResponse()
    {
        return $this->conversations_response;
    }

    /**
     * @param Model\Conversation[] $conversations_response
     */
    public function setConversationsResponse($conversations_response)
    {
        $this->conversations_response = $conversations_response;
    }

    /**
     * @return Model\MessagingGatewayInfo
     */
    public function getMessagingGatewayInfo()
    {
        return $this->messaging_gateway_info;
    }

    /**
     * @param Model\MessagingGatewayInfo $messaging_gateway_info
     */
    public function setMessagingGatewayInfo($messaging_gateway_info)
    {
        $this->messaging_gateway_info = $messaging_gateway_info;
    }

    /**
     * @return string
     */
    public function getDtoken1i()
    {
        return $this->dtoken1i;
    }

    /**
     * @param string $dtoken1i
     */
    public function setDtoken1i($dtoken1i)
    {
        $this->dtoken1i = $dtoken1i;
    }

    /**
     * @return string
     */
    public function getDtoken1v()
    {
        return $this->dtoken1v;
    }

    /**
     * @param string $dtoken1v
     */
    public function setDtoken1v($dtoken1v)
    {
        $this->dtoken1v = $dtoken1v;
    }

    /**
     * @return boolean
     */
    public function isTwoFaNeeded()
    {
        return $this->two_fa_needed;
    }

    /**
     * @param boolean $two_fa_needed
     */
    public function setTwoFaNeeded($two_fa_needed)
    {
        $this->two_fa_needed = $two_fa_needed;
    }

    /**
     * @return string
     */
    public function getPreAuthToken()
    {
        return $this->pre_auth_token;
    }

    /**
     * @param string $pre_auth_token
     */
    public function setPreAuthToken($pre_auth_token)
    {
        $this->pre_auth_token = $pre_auth_token;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    /**
     * @param string $phone_number
     */
    public function setPhoneNumber($phone_number)
    {
        $this->phone_number = $phone_number;
    }

    /**
     * @return int
     */
    public function getSnapP()
    {
        return $this->snap_p;
    }

    /**
     * @param int $snap_p
     */
    public function setSnapP($snap_p)
    {
        $this->snap_p = $snap_p;
    }

    /**
     * @return string
     */
    public function getStoryPrivacy()
    {
        return $this->story_privacy;
    }

    /**
     * @param string $story_privacy
     */
    public function setStoryPrivacy($story_privacy)
    {
        $this->story_privacy = $story_privacy;
    }

}