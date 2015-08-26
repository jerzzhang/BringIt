<?php
	
require_once __DIR__.'/../all.php';

if (!isset($_POST['username']) || empty($_POST['username'])) {
    header("Location: /index.php?m=5"); // not enough credentials passed
    exit;
}

if (!isset($_POST['password']) || empty($_POST['password'])) {
    header("Location: /index.php?m=5"); // not enough credentials passed
    exit;
}

$location = "/";

$users = new UserManager();
$cookies = new Cookies();

$data = $users->auth_user($_POST["username"], $_POST["password"]);
$auth_level = $data[0];
$user_uid   = $data[1];

if ($auth_level !== 0){ // user is valid
    $cookies->set_cookie($user_uid);
    if ($auth_level != 1){
        $location = "/admin.php";
//         header("Location: /admin.php");
//         exit;
    }
    else{
        $location = "/index.php";
//         header("Location: /index.php?m=6"); // success no message
//         exit;
    }
}
else{
    $location = "/index.php?m=4";
//     header("Location: /index.php?m=4"); // invalid credentials
//     exit;
}

if (isset($_POST["redirect"])){
    if ($_POST["redirect"] != "0"){
        $location = vsprintf("../../%s", $_POST["redirect"]);
    }
}
header(vsprintf("Location: %s", $location));
exit;
