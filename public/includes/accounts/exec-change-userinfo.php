<?php

require_once __DIR__.'/../all.php';

$vars = array("wholename","email","oldpass"); //,"oldpass","newpass","newpassconf");


if (set_vars($_POST, $vars)){
    $cookies = new Cookies();
    $user = $cookies->user_from_cookie();
    $auth = $user->auth_user($user->data["email"], $_POST["oldpass"]);
    if ($auth[1] !== 0){
        $newname = $_POST["wholename"] === '' ? $user->data["name"] : $_POST["wholename"];
        $newemail = $_POST["email"] === '' ? $user->data["email"] : $_POST["email"];

        // validate data
        $errors = array();
        $inputs = app('request')->input();
        if (!filter_var($inputs['email'], FILTER_VALIDATE_EMAIL)) {
            array_push($errors, 'Invalid email');
        }
        if (!empty($errors)) {
            header("Location: /profile.php?m=13");
            exit;
        }

        $user->changeDetails($user->data["uid"],$newname, $newemail);

        if (isset($_POST["newpass"]) && isset($_POST["newpassconf"])){
            if ($_POST["newpass"] == $_POST["newpassconf"] && $_POST["newpass"] !== ""){
                $user->changePassword($user->data["uid"], $_POST["newpass"]);
            }
        }
    }
    else{
        header("Location: /profile.php?m=4");
        exit;
    }
}

header("Location: /profile.php");
exit;
