<?php
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

if(isset($_COOKIE['refresh'])){
    $header = "<a href='api/logout.php'>Logout</a>";
}else{
    $header = "<a href='authorize.php'>Connect</a>";
}


echo "<head><link rel='shortcut icon' type='image/png' href='style/MosaicLogo.png'/><title>Mosaic</title><meta name='viewport' content='width=device-width, initial-scale=1'>
<link href='style/style.css' rel='stylesheet'><script src='lib/mosaic.js'></script></head><body onload='getcount();'></br><center><h1>Welcome to Mosaic</h1><h3>$header</h3><span>Check out <span id='count'>0</span> users' top songs for the past 4 weeks. Click on a song to listen to it or share yours by clicking connect</span></center></br><center>";

echo "<div class='sidebar'></div>";

$users = json_decode(file_get_contents('lists.json'),true);
foreach ($users as $user) {
    if ($user == null) {
    } else {
        echo "<div class='block'><img class='profile' src='" . $user['ava'] . "'></img><div class='songlist'><a href='" . $user['url']. "'><h2>" . $user['display_name'] . "</h2></a>";
        foreach ($user['tracks'] as $track) {
            echo "<a href='" . $track['link'] . "'>" . $track['name'] . "</a>";
        }

        echo "</div></div>";
    }
}
echo "</center></body>";