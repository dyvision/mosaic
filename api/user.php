<?php
include('../lib/mosaic.php');
chdir('../');

use mosaic\user;


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $userarray = array();

    foreach (json_decode(file_get_contents('lists.json'), true) as $user) {
        if ($user != null) {
            array_push($userarray, $user);
        }
    }
    print_r(json_encode($userarray));
} elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    $patch = json_decode(file_get_contents('php://input'), true);
    $usercli = new user();

    $usercli->update($patch['id'], $patch['private']);
}
