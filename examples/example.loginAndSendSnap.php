<?php

require("../src/autoload.php");

$casper = new \Casper\Developer\CasperDeveloperAPI("api_key", "api_secret");
$snapchat = new \Snapchat\Snapchat($casper);

try {

    //Login
    $login = $snapchat->login("username", "password");

    //Upload Photo to Snapchat
    $uploadPayload = $snapchat->uploadPhoto("photo.jpg");

    //Send Snap
    $snapchat->sendMedia($uploadPayload, 10, array("recipient"));

} catch(Exception $e){
    //Something went wrong...
    echo $e->getMessage() . "\n";
}