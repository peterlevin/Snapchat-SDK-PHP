<?php

require("../src/autoload.php");

$casper = new CasperDevelopersAPI("api_key", "api_secret");
$snapchat = new \Snapchat\Snapchat($casper);

try {

    //Login
    $login = $snapchat->login("username", "password");

    //Get Conversations from Login Response
    $conversations = $login->getConversationsResponse();

    //Download all un-viewed Snaps
    foreach($conversations as $conversation){

        $snaps = $conversation->getSnaps();
        foreach($snaps as $snap){

            //Only Received Snaps that haven't been Viewed
            if($snap->wasReceived() && !$snap->hasBeenViewed()){

                //Where to Save the Files
                $filename = sprintf("downloads/snaps/%s", $snap->getId());
                $filename_overlay = sprintf("downloads/snaps/%s_overlay", $snap->getId());

                //Download the Snap
                $mediapath = $snapchat->downloadSnap($snap, $filename, $filename_overlay);

                echo "Snap saved to: " . $mediapath->getBlobPath(). "\n";
                if($mediapath->overlayExists()){
                    echo "Snap Overlay saved to: " . $mediapath->getOverlayPath(). "\n";
                }

            }

        }

    }

} catch(Exception $e){
    //Something went wrong...
    echo $e->getMessage() . "\n";
}