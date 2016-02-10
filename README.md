#Snapchat-SDK-PHP

This is an unofficial SDK for the Snapchat API in PHP. It has been built around the Casper Developer API.

##Before you Start

The Casper Developer API is a paid service for fetching Authentication Parameters and Headers for Snapchat requests on demand.

You will need to register for access, and submit your Project for review.

If you need to register, you can do so at the [Casper Developers](https://developers.casper.io) website.

##Installation

At this stage, the project is non-composer based...

To get started using the SDK, you will need to include the AutoLoader script.

Since we rely on the Casper Developers API, we need to provide an instance of `CasperDevelopersAPI` to the `Snapchat` constructor.

```
require("./src/autoload.php");
$casper = new CasperDevelopersAPI("api_key", "api_secret");
$snapchat = new \Snapchat\Snapchat($casper);
```

At the moment, the CasperDevelopersAPI project is embedded in the `./lib/` folder, and included in the `autoload.php`.

Once I learn to use composer properly, I will convert the Developers API project to composer based etc, and remove it from the `./lib/` folder.

##Usage

###Examples

Take a look at the [Examples folder](./examples).

###Login

To login, you will need to provide your Snapchat Username and Snapchat Password. If something goes wrong, an `Exception` will be thrown.

```
try {

    $login = $snapchat->login("username", "password");
    ...

} catch(Exception $e){
    echo $e->getMessage() . "\n";
}
```

Once you have logged in, the `$login` object will provide direct access to all of the fetched data. Such as Snaps, Conversations, Stories and Friends.

```
$conversations = $login->getConversationsResponse(); //Snaps and Chat Messages
$friendsResponse = $login->getFriendsResponse(); //Friends, Friend Requests
$updatesResponse = $login->getUpdatesResponse(); //AuthToken, Score, Birthday, etc
$storiesResponse = $login->getStoriesResponse(); //Your Stories and Friends Stories
```

Similar methods exist directly on the `$snapchat` object, which will fetch fresh data from the server.

###AuthToken Login

If you save the Username and AuthToken, you can create a new instance of the `Snapchat` class at a later time with the `initWithAuthToken` method.

```
$snapchat->initWithAuthToken("username", "auth_token");
```

When using the AuthToken method, you don't have access to the `$login` object.

You will need to use the methods with similar names on the `$snapchat` object instead.

```
$conversations = $snapchat->getConversations(); //Snaps and Chat Messages
$friendsResponse = $snapchat->getCachedFriendsResponse(); //Friends, Friend Requests
$updatesResponse = $snapchat->getAllUpdates(); //AuthToken, Score, Birthday, etc
$storiesResponse = $snapchat->getStories(); //Your Stories and Friends Stories
```

###Friends

Friend data is provided in the response of multiple API calls, but not it's own endpoint. You can access the currently cached Friend data like so:

```
$snapchat->getCachedFriendsResponse();
```

If you need to fetch updated Friend data from the server, you will need to call the `getAllUpdates` method.

```
$friendsResponse = $snapchat->getAllUpdates()->getFriendsResponse(); //Friends, Friend Requests
```

In the case above, the `getCachedFriendsResponse()` will now return the updated data.

###Conversations

Snaps and Chat Messages are both located within `ConversationMessages`. Here's a few examples on how to iterate over them.

####Get all unviewed received Snaps

```
foreach($conversations as $conversation){

    $snaps = $conversation->getConversationMessages()->getSnaps();
    foreach($snaps as $snap){

        if($snap->wasReceived() && !$snap->hasBeenViewed()){
            //Do something with the Unread Snap...
        }

    }

}
```

###Download Snaps

Unviewed Snaps can be downloaded with via the `downloadSnap` method.

You need to pass in the `Snap` object you want to download, along with a File Path (as a string), in which the Snap will be saved to.

You can optionally provide a File Path for the Video Overlay. (If one isn't provided, it will be generated for you).

File extensions (JPG/MP4) are automatically appended to the file name for you.

If everything goes successfully, the `downloadSnap` method will return a `MediaPath` object, which contains the File Paths of the Saved media. (Blob and Overlay).

An `Exception` will be thrown on Failure...

```
$snap = ...;

$filename = sprintf("my_snap_folder/%s", $snap->getId());
$mediapath = $snapchat->downloadSnap($snap, $filename);

$file_blob = $mediapath->getBlobPath();
$file_overlay = $mediapath->getOverlayPath();

echo "Blob saved to: " . $file_blob. "\n";
if($mediapath->overlayExists()){
  echo "Overlay saved to: " . $file_overlay. "\n";
}
```

####Download all unviewed received Snaps

```
$conversations = $login->getConversationsResponse();
foreach($conversations as $conversation){

    $snaps = $conversation->getConversationMessages()->getSnaps();
    
    foreach($snaps as $snap){

        if($snap->wasReceived() && !$snap->hasBeenViewed()){

            echo "Downloading Snap from: " . $snap->getSender() . "\n";

            $filename = sprintf("snaps/%s", $snap->getId());
            $mediapath = $snapchat->downloadSnap($snap, $filename);

            echo "Blob saved to: " . $mediapath->getBlobPath(). "\n";
            if($mediapath->overlayExists()){
                echo "Overlay saved to: " . $mediapath->getOverlayPath(). "\n";
            }

        }

    }

}
```

##Documentation

At the moment, there's no proper documentation. However, [take a look at the examples](./examples) as well as the other methods in the `Snapchat` class.

##Developers

- [liamcottle](https://github.com/liamcottle)

##Legal

The name "Snapchat" is a copyright of Snapchat™, Inc.

This project is in no way affiliated with, authorized, maintained, sponsored or endorsed by Snapchat™, Inc or any of its affiliates or subsidiaries.

I, the project owner and creator, am not responsible for any legalities that may arise in the use of this project. Use at your own risk.