<?php

require("../src/autoload.php");

$casper = new \Casper\Developer\CasperDeveloperAPI("api_key", "api_secret");
$snapchat = new \Snapchat\Snapchat($casper);

try {

    //Login
    $login = $snapchat->login("username", "password");

    //Download My SnapTag
    $snapchat->downloadMySnapTag(sprintf("download/snaptag/%s.png", $snapchat->getUsername()));

    //Download someone else's SnapTag
    $snapchat->downloadSnapTagByUsername("teamsnapchat", "download/snaptag/teamsnapchat.png");

} catch(Exception $e){
    //Something went wrong...
    echo $e->getMessage() . "\n";
}