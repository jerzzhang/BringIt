<?php

require_once __DIR__.'/../all.php';

$cookies = new Cookies();
$usermanager = new UserManager();
$user = $cookies->user_from_cookie();

function generateHTMLFromData($data){
    $html = '';
    $start = $end = "";
    $fmt = "
        <div class='order-info'>
        <div class='order-time'>%s</div>
        <div class='order-restaurant'>%s</div>
        <div class='order-name'>%s</div>
        <div class='order-address'>%s</div>
        <div class='order-items'>%s</div>
        <div class='order-total'><span class='pretotal'>TOTAL </span> %s</div>
        <br><br>
        </div>
        ";
// order-address:         <div class='order-address'>%s<br>%s<br>%s, %s<br>%s</div>
// order-name:         <div class='order-name'>%s<br>%s<br>%s</div>

    $html .= htmlLoop($data, $start, $fmt, $end);
    return $html;
}

function getOrderForUser($user){
    $data = Array();
    $order = DB::query("SELECT * FROM orders WHERE user_id=%s", $user->data["uid"]);
    $categories = DB::query("SELECT * FROM category_items");
    foreach ($order as $o){
        $time   = $o["time"];

        $catname = whereArray($categories, "id", $o["service_id"])["name"];
        $address = UserManager::getAddressFor($o["user_id"]);

        $user   = DB::queryOneRow("SELECT * FROM accounts WHERE uid=%s", $o["user_id"]);
        $items = UserManager::getItemsForCart($o["user_id"], $o["id"]);

        $address_str = sprintf("%s (%s) <br>%s, %s. %s", $address["street"], $address["apartment"], $address["city"], $address["state"], $address["zip"]);

        $odata = Array($time, $catname, $user["name"], $address_str, $items["html"], $items["price"]);
        array_push($data, $odata);
    }
    return $data;
}
$data = getOrderForUser($user);
if (count($data) == 0){
    echo "No orders";
}else{
    echo generateHTMLFromData($data);
}
