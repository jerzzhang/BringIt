<?php

require_once __DIR__.'/../all.php';

$cookies = new Cookies();
$user = $cookies->user_from_cookie();

$vars = array("itemid","instructions");// itemid, sideids

if (set_vars($_POST, $vars)){
    $itemid = $_POST["itemid"];
    $instr = $_POST["instructions"];

    unset($_POST["itemid"]);
    unset($_POST["instructions"]);
    $sides = array();
    foreach ($_POST as $k=>$v){
        if ($k != "side"){
            $sides[] = $k;
        }
        else{
            $sides[] = $v;
        }
    }
    echo $user->add_to_cart($itemid, $sides, $instr);
}
else{
    echo json_array(-1, $_POST);
}
