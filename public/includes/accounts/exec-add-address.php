<?php

require_once __DIR__.'/../all.php';

$cookies = new Cookies();
$user = $cookies->user_from_cookie();
$vars = array("address","apartment","city","state","zipcode");
if (set_vars($_POST, $vars) && $user !== 0){
    $user->add_address($_POST["address"], $_POST["apartment"], $_POST["city"], $_POST["state"], $_POST["zipcode"]);
    if (($_POST["redirect"]) != ""){
        $arr = explode(",", $_POST["redirect"]);
        header(sprintf("Location: /order.php?flow=%s&type=%s&id=%s", $arr[0], $arr[1], $arr[2]));
        exit;
    }
    header("Location: /profile.php?p=2");
    exit;
}
else{
    header("Location: /profile.php?p=2");
    exit;
}
