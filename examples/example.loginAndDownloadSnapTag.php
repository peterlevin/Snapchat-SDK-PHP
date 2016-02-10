<?php

require("../src/autoload.php");

$casper = new CasperDevelopersAPI("api_key", "api_secret");
$snapchat = new \Snapchat\Snapchat($casper);

try {

    //Login
    $login = $snapchat->login("username", "password");

    //Download SnapTag [/download/snaptag/username.png]
    $snapchat->downloadSnapTag(sprintf("download/snaptag/%s", $snapchat->getUsername()));

} catch(Exception $e){
    //Something went wrong...
    echo $e->getMessage() . "\n";
}