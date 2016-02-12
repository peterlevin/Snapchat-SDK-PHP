<?php

require("../src/autoload.php");

$casper = new \Casper\Developer\CasperDeveloperAPI("api_key", "api_secret");
$snapchat = new \Snapchat\Snapchat($casper);

try {

    //Login
    $login = $snapchat->login("username", "password");

    //Get Stories from Login Response
    $storiesResponse = $login->getStoriesResponse();

    //Iterate Friend Stories
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

    //Iterate My Stories
    foreach($storiesResponse->getMyStories() as $myStories){

        $story = $myStories->getStory(); //The Story object
        $storyNotes = $myStories->getStoryNotes(); //Details about who viewed your Story
        $storyExtras = $myStories->getStoryExtras(); //View and Screenshot counts

        //Where to Save the Story
        $filename = sprintf("download/stories/%s.%s", $story->getId(), $story->getFileExtension());

        //Download the Story
        $mediapath = $snapchat->downloadStory($story, $filename);

    }

} catch(Exception $e){
    //Something went wrong...
    echo $e->getMessage() . "\n";
}