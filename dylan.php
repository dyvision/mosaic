<?php

$lists = json_decode(file_get_contents('lists.json'),true);

$me = array_search($_GET['id'],$lists);

print_r(json_encode($me));