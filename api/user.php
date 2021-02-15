<?php
include('../lib/mosaic.php');
chdir('../');


if($_SERVER['REQUEST_METHOD'] == 'GET'){
   $userarray = array();

   foreach(json_decode(file_get_contents('lists.json'),true) as $user){
       if($user != null){
           array_push($userarray,$user);
       }
   }
   print_r(json_encode($userarray));
}
