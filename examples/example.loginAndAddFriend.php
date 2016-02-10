<?php

require("../src/autoload.php");

$casper = new CasperDevelopersAPI("api_key", "api_secret");
$snapchat = new \Snapchat\Snapchat($casper);

try {

    //Login
    $login = $snapchat->login("username", "password");

    //Add Friend
    $snapchat->addFriend("username_to_add");

} catch(Exception $e){
    //Something went wrong...
    echo $e->getMessage() . "\n";
}