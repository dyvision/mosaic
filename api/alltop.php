<?php
 //ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);


include('../lib/mosaic.php');

use mosaic\top;
use mosaic\user;
use mosaic\auth;

$usercli = new user();
$authcli = new auth();
$playlistcli = new top();

$array = array();

$users = json_decode($usercli->get(), true);
foreach ($users as $user) {
    $token = json_decode($authcli->authenticate($user,'refresh_token'),true);
    $username = json_decode($authcli->verify($token['access_token']),true)['username'];

    $obj['user'] = $username;
    array_push($array,json_decode($playlistcli->get($token['access_token']),true));
    $obj['toptracks'] = $array;

}

echo "<head><link href='../style/style.css' rel='stylesheet'></head>";
foreach($obj as $account){
    echo "<div><h2>".$account['username']."</h2>";
    foreach($obj['toptracks'] as $track){
        echo "<span>$track</span></br>";
    }
    echo "</div>";
}
