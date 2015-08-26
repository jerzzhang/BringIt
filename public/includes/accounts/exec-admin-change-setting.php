<?php

require_once __DIR__.'/../all.php';

$cookies = new Cookies();
$user = $cookies->user_from_cookie();

$vars = array("type","name");
$vars1 = array("name");


if (set_vars($_POST, $vars) && $user !== 0){
    $type = $_POST["type"];
    if ($user->data["permission"] == 4){

        if ($type === "1" && set_vars($_POST, $vars1)){
            $name = $_POST["name"];
            $value = $_POST["value"];

            $setting = DB::queryOneRow("SELECT * FROM settings WHERE name=%s", $name);
            if (DB::count() !== 0){
                // valid
                if ($setting["value"] !== $value){
                    // change it
                    DB::update("settings", array("value"=>$value), "name=%s", $name);
                    echo json_array(1, array("name"=>$name, "value"=>$value), "successfully changed");
                    return;
                }
                echo json_array(0, null, "no change made");
                return;
            }
            echo json_array(0, null, "invalid setting");
            return;
        }
        if ($type === "2"){
            $f = $_FILES['settingsfile'];
            $loc = uploadImage($f);
            if ($loc !== -1){
                DB::update("settings",array("value"=>$loc), "name=%s", $_POST["name"]);
//                echo json_array(0, null, "failure to upload file");
//                return;
            }
            header("Location: /admin.php");
//            echo json_array(1, array("newloc"=>$loc), "success!");
            exit;
        }
    }
    echo json_array(0, $user->data["permission"], "invalid permissions");
    return;
}
echo json_array(0, $_POST, "invalid user or data");
