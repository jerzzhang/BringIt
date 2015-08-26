<?php

require_once __DIR__.'/../all.php';

$cookies = new Cookies();
$user = $cookies->user_from_cookie();

$vars = array("item");

if (set_vars($_POST, $vars)){
    echo $user->del_from_cart($_POST["item"]);
}
else{
    echo json_array(-1);
}
