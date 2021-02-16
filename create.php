<?php
 //ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

include('lib/mosaic.php');

use mosaic\auth;
use mosaic\user;

$mosaic = new auth();
$user = new user();

try {
    $token = json_decode($mosaic->authenticate($_GET['code'],'authorization_code'),true);
    print_r($mosaic->verify($token['access_token']));
    $user->create($token['refresh_token']);
    file_get_contents('https://mosaic.paos.io/api/lists.php');
    header('location: https://mosaic.paos.io');
} catch (Exception $e) {
    header('location: https://mosaic.paos.io/authorize.php');
}
