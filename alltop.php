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


echo "<head><link href='style/style.css' rel='stylesheet'></head>";

$users = json_decode($usercli->get(), true);
foreach ($users as $user) {
    $token = json_decode($authcli->authenticate($user,'refresh_token'),true);
    $username = json_decode($authcli->verify($token['access_token']),true);

    echo "<div><h2>".$username['display_name']."</h2>";
    foreach(json_decode($playlistcli->get($token['access_token']),true) as $track){
        echo "<span>$track</span></br>";
    }

}
echo "</div>";