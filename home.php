<?php
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);


include('lib/mosaic.php');

use mosaic\top;
use mosaic\user;
use mosaic\auth;

$usercli = new user();
$authcli = new auth();
$playlistcli = new top();

$array = array();


echo "<head><title>Mosaic</title><meta name='viewport' content='width=device-width, initial-scale=1'>
<link href='style/style.css' rel='stylesheet'></head><body><a href='authorize.php'>Share your top tracks for the month</a></br><center><h1>Welcome to Mosaic</h1> <h3>Check out everyone's top songs for the past 4 weeks. Click on a song to listen to it or share yours by clicking the link in the top left</h3></center></br>";

$users = json_decode($usercli->get(), true);
foreach ($users as $user) {
    $token = json_decode($authcli->authenticate($user, 'refresh_token'), true);
    $username = json_decode($authcli->verify($token['access_token']), true);

    echo "<div class='block'><h2>" . $username['display_name'] . "</h2>";
    foreach (json_decode($playlistcli->get($token['access_token']), true) as $track) {
        echo "<a href='".$track['link']."'>".$track['name']."</a></br>";
    }

    echo "</div>";
}
echo "</body>";
