<?php

require("../src/autoload.php");

$casper = new CasperDevelopersAPI("api_key", "api_secret");
$snapchat = new \Snapchat\Snapchat($casper);

try {

    //Login
    $login = $snapchat->login("username", "password");

    //Get Stories from Login Response
    $storiesResponse = $login->getStoriesResponse();

    foreach($storiesResponse->getFriendStories() as $friendStories){

        //We only want Stories for this Username
        if($friendStories->getUsername() == "username_you_want_snaps_for"){

            $storiesContainer = $friendStories->getStories();
            foreach($storiesContainer as $storyContainer){

                $story = $storyContainer->getStory();

                echo "Downloading Story: " . $story->getId() . "\n";

                //Where to Save the Files
                $filename = sprintf("download/stories/%s", $story->getId());
                $filename_overlay = sprintf("download/stories/%s_overlay", $story->getId());

                //Download the Story
                $mediapath = $snapchat->downloadStory($story, $filename, $filename_overlay);

                echo "Story saved to: " . $mediapath->getBlobPath(). "\n";
                if($mediapath->overlayExists()){
                    echo "Story Overlay saved to: " . $mediapath->getOverlayPath(). "\n";
                }

            }

            break;

        }

    }

} catch(Exception $e){
    //Something went wrong...
    echo $e->getMessage() . "\n";
}