<?php

require_once __DIR__.'/../all.php';

$cookies = new Cookies();

$user = $cookies->user_from_cookie();
if ($user !== 0){
    $cookies->del_cookie($user->data["uid"]);
    header("Location: /index.php?m=7");
    exit;
}
//$cookies->del_cookie("BE6925832E2F4BF184C4C667E5A01CDF");
else{
    header("Location: /index.php?m=8");
    exit;
}
