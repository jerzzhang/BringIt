<?php

require_once __DIR__.'/../all.php';

$cookies = new Cookies();
$user = $cookies->user_from_cookie();

$vars = array("cart_type");

if (set_vars($_POST, $vars) && $user !== 0){
    echo $user->get_cart($_POST["cart_type"]);
}
else{
    echo json_array(-1);
}
