<?php

namespace Snapchat\API\Request;

use Snapchat\API\Response\FriendResponse;
use Snapchat\API\Response\Model\Friend;

class FriendRequest extends BaseRequest {

    const KEY_ACTION = "action";
    const KEY_ADDED_BY = "added_by";
    const KEY_FRIEND_ID = "friend_id";
    const KEY_IDENTITY_CELL_INDEX = "identity_cell_index";
    const KEY_IDENTITY_PROFILE_PAGE = "identity_profile_page";

    const KEY_IDENTITY_PROFILE_MY_FRIENDS_PAGE = "PROFILE_MY_FRIENDS_PAGE";
    const KEY_IDENTITY_PROFILE_ADD_FRIENDS_BY_USERNAME_PAGE = "PROFILE_ADD_FRIENDS_BY_USERNAME_PAGE";

    /**
     * @param $username string Username to Init with.
     */
    public function initWithUsername($username){
        $this->addParam("friend", $username);
        $this->addParam(self::KEY_IDENTITY_CELL_INDEX, "0");
        $this->addParam(self::KEY_IDENTITY_PROFILE_PAGE, self::KEY_IDENTITY_PROFILE_ADD_FRIENDS_BY_USERNAME_PAGE);
    }

    /**
     * @param $friend Friend Friend to Init with.
     */
    public function initWithFriend($friend){
        $this->initWithUsername($friend->getName());
        if(!empty($friend->getUserId())){
            $this->addParam(self::KEY_FRIEND_ID, $friend->getUserId());
            $this->addParam(self::KEY_IDENTITY_CELL_INDEX, "-1");
            $this->addParam(self::KEY_IDENTITY_PROFILE_PAGE, self::KEY_IDENTITY_PROFILE_MY_FRIENDS_PAGE);
        }
    }

    public function updateDisplayName($display){
        $this->addParam(self::KEY_ACTION, "display");
        $this->addParam("display", $display);
    }

    public function block(){
        $this->addParam(self::KEY_ACTION, "block");
    }

    public function unblock(){
        $this->addParam(self::KEY_ACTION, "unblock");
    }

    public function add(){
        $this->addParam(self::KEY_ACTION, "add");
        $this->addParam(self::KEY_ADDED_BY, Friend::ADDED_BY_USERNAME);
    }

    public function delete(){
        $this->addParam(self::KEY_ACTION, "delete");
        $this->addParam(self::KEY_ADDED_BY, Friend::ADDED_BY_USERNAME);
    }

    public function getMethod(){
        return self::POST;
    }

    public function getEndpoint(){
        return "/bq/friend";
    }

    public function getResponseObject(){
        return new FriendResponse();
    }

    /**
     * @return FriendResponse
     * @throws \Exception
     */
    public function execute(){
        return parent::execute();
    }

}