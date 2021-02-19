<?php

$lists = json_decode(file_get_contents('lists.json'),true);

$me = array_search($_GET['id'],array_column($lists,'display_name'));

if(count($list[$me]['tracks']) > 4){
    $result = $list[$me];
}else{
    $result = 'Not Found';
}

print_r(json_encode($result));