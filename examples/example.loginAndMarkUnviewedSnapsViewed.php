<?php

require("../src/autoload.php");

$casper = new CasperDevelopersAPI("api_key", "api_secret");
$snapchat = new \Snapchat\Snapchat($casper);

try {

    //Login
    $login = $snapchat->login("username", "password");

    //Get Conversations from Login Response
    $conversations = $login->getConversationsResponse();

    //Mark all unviewed Snaps as Viewed
    foreach($conversations as $conversation){
        $snaps = $conversation->getSnaps();
        foreach($snaps as $snap){

            //Snaps we Received and haven't Viewed yet
            if($snap->wasReceived() && !$snap->hasBeenViewed()){
                $snapchat->markSnapViewed($snap);
            }

        }
    }

} catch(Exception $e){
    //Something went wrong...
    echo $e->getMessage() . "\n";
}