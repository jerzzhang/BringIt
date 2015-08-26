<?php

require_once __DIR__.'/../all.php';

$cookies = new Cookies();
$user = $cookies->user_from_cookie();

$vars = array("key","uid","newval");

if (set_vars($_POST, $vars) && $user!==0){
    if ($user->data["permission"] == 4){
        echo json_array(UserManager::adminUpdateUserInformation($_POST["key"], $_POST["uid"], $_POST["newval"]));
    }
}
echo json_array(-1);
