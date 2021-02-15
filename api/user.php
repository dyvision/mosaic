<?php
include('../lib/mosaic.php');
chdir('../');

use mosaic\user;
use mosaic\auth;

if($_SERVER['REQUEST_METHOD'] == 'GET'){
   $authcli = New auth();
   $usercli = New user();
   $userarray = array();

   foreach($usercli->get() as $user){
       if($user != null){
           $jtoken = json_decode($authcli->authenticate($user,'refresh_token'),true);
           array_push($userarray,json_decode($authcli->verify($jtoken['access_token']),true));
       }
   }
   print_r(json_encode($userarray));
}
