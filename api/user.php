<?php
include('../lib/mosaic.php');
chdir('../');

use mosaic\user;

$usercli = new user();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        print_r($usercli->get($_GET['id']));
    } else {
        $userarray = array();

        foreach (json_decode(file_get_contents('lists.json'), true) as $user) {
            if ($user != null) {
                array_push($userarray, $user);
            }
        }
        print_r(json_encode($userarray));
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    $patch = json_decode(file_get_contents('php://input'), true);


    $usercli->update($patch['id'], $patch['guid'],$patch['private']);
}
