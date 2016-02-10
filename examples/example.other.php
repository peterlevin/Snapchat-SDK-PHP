<?php

require("../src/autoload.php");

$casper = new CasperDevelopersAPI("api_key", "api_secret");
$snapchat = new \Snapchat\Snapchat($casper);

try {

    //Use a Proxy for API Requests
    $snapchat->setProxy("127.0.0.1:8888");

    //Use AuthToken instead of Username and Password
    $snapchat->initWithAuthToken("username", "auth_token");

    $conversations = $snapchat->getConversations(); //Snaps and Chat Messages
    $friendsResponse = $snapchat->getCachedFriendsResponse(); //Friends, Friend Requests
    $updatesResponse = $snapchat->getAllUpdates(); //AuthToken, Score, Birthday, etc
    $storiesResponse = $snapchat->getStories(); //Your Stories and Friends Stories

    $friendsResponse = $snapchat->getAllUpdates()->getFriendsResponse(); //Friends, Friend Requests

} catch(Exception $e){
    //Something went wrong...
    echo $e->getMessage() . "\n";
}