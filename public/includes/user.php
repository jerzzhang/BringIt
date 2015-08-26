<?php

class UserManager
{
    public $data = null;
    public $id;
    private $table_name = "accounts";

    public function __construct($user_data = null) {
        if (!$user_data){
            return;
        }
        $this->id = $user_data["uid"];
        $this->data = $user_data;
    }

    public function add_user($name, $email, $password, $phone){
        $salt = uniqid(mt_rand(), true);
        $uid = GUID(50);
        DB::insert($this->table_name, array(
            "name" => $name,
            "uid"  => $uid,
            "email" => $email,
            "phone" => $phone,
            "logintime" => "0",
            "password_hash" => hash("sha512", $password . $salt),
            "password_salt" => $salt,
            "session" => "0",
        )
    );
        return DB::insertId(); // return the user id.
    }

    public function get_user_from_insertid($id){
        $data = DB::queryOneRow("SELECT * FROM accounts WHERE id=%s", $id);
        return new UserManager($data);
    }

    public function is_account_available($email){
        DB::query("SELECT * FROM accounts WHERE email=%s", $email);
        return DB::count() == 0;
    }

    public function add_address($street, $apartment, $city, $state, $zipcode){
        // todo: add_address(array("street","apartment","city","state","zipcode"))
        $c = DB::query("SELECT account_id FROM account_address WHERE account_id=%s", $this->data["uid"]);
        $address = array(
            "account_id"=>$this->data["uid"],
            "street"=>$street == "" ? null : $street,
            "apartment"=>$apartment == "" ? null : $apartment,
            "city"=>$city == "" ? null : $city,
            "state"=>$state == "" ? null : strtoupper($state),
            "zip"=>$zipcode == "" ? null : $zipcode,
        );
        $address = array_filter($address, function($e){ return $e != null; });
        if (DB::count() == 1){
            DB::update("account_address", $address, "account_id=%s", $this->data["uid"]);
        }else{
            DB::insert("account_address", $address);
        }
    }

    public function add_to_cart($item_id, $sides, $inst){
        $item = DB::queryOneRow("SELECT * FROM menu_items WHERE id=%s", $item_id);
//        DB::query("UPDATE carts SET quantity=quantity+1 WHERE item_id=%s AND user_id=%s AND cart_type=%s AND active=%d", $item_id, $this->data["uid"], $item["service_id"], 1);
//        if (DB::affectedRows() == 0){
        $uid = GUID();
        DB::insert("carts", array("instructions"=>$inst, "uid"=>$uid, "cart_type"=>$item["service_id"], "cat_id"=>$item["service_id"], "item_id"=>$item_id, "user_id"=>$this->data["uid"]));
//        }
        if (count($sides) > 0){
            if (!isset($uid)){
                $uid = DB::queryOneRow("SELECT uid FROM carts WHERE item_id=%s AND user_id=%s AND cat_id=%s AND active=%d", $item_id, $this->data["uid"], $item["category_id"], 1)["uid"];
            }
            foreach ($sides as $sk=>$sv){
//                DB::query("UPDATE cart_sides SET quantity=quantity+1 WHERE cart_entry_uid=%s AND side_id=%s", $uid, $sv);
//                if (DB::affectedRows() == 0){
                DB::insert("cart_sides", array("cart_entry_uid"=>$uid, "side_id"=>$sv));
//                }
            }
        }
        return $this->get_cart($item["service_id"]);
        // DB::sqleval("NOW()")
    }

    public function __add_to_cart($item_id, $sides){
        $item = DB::queryOneRow("SELECT * FROM menu_items WHERE id=%s", $item_id);
        $existing_uid = DB::queryOneRow("SELECT uid FROM carts WHERE user_id=%s AND cart_type=%s AND active=%d", $this->data["uid"], $item["service_id"], 1);
        if (DB::count() != 0){
            $uid = $existing_uid["uid"];
        }
        else{
            $uid = GUID();
        }

        DB::query("UPDATE carts SET quantity=quantity+1 WHERE item_id=%s AND user_id=%s AND cart_type=%s AND active=%d", $item_id, $this->data["uid"], $item["service_id"], 1);
        if (DB::affectedRows() == 0){
            DB::insert("carts", array("uid"=>$uid, "cart_type"=>$item["service_id"], "item_id"=>$item_id, "user_id"=>$this->data["uid"]));
        }
        if (count($sides) > 0){

            foreach ($sides as $sk=>$sv){
                DB::query("UPDATE cart_sides SET quantity=quantity+1 WHERE cart_entry_uid=%s AND side_id=%s", $uid, $sv);
                if (DB::affectedRows() == 0){
                    DB::insert("cart_sides", array("cart_entry_uid"=>$uid, "side_id"=>$sv));
                }
            }
        }
        return $this->get_cart($item["category_id"]);
//        DB::sqleval("NOW()")
    }

    public function del_from_cart($cartid){
        $item = DB::queryOneRow("SELECT * FROM carts WHERE uid=%s", $cartid);
//        DB::query("UPDATE carts SET quantity=quantity-1 WHERE item_id=%s AND user_id=%s AND cart_type=%s", $item_id, $this->data["uid"], $item["service_id"]);
        DB::query("DELETE FROM carts WHERE uid=%s", $cartid);
        DB::query("DELETE FROM cart_sides WHERE cart_entry_uid=%s", $cartid);
        return $this->get_cart($item["cart_type"]);
    }


    public function get_cart($cart_cat_id){
        $items = DB::query("SELECT * FROM carts WHERE cat_id=%s AND user_id=%s AND active=%d", $cart_cat_id, $this->data["uid"], 1);
        $cart = array();
        foreach($items as $item){
            $id = $item["item_id"];
            $item_data = DB::queryOneRow("SELECT * FROM menu_items WHERE id=%s", $id);
            $item_data["quantity"] = $item["quantity"];
            $item_data["cid"] = $item["uid"];
            $sides_raw = DB::query("SELECT * FROM cart_sides WHERE cart_entry_uid=%s", $item["uid"]);
            $sides = array();
            $sides_str = "";
            $tprice = floatval($item_data["price"]);
            foreach ($sides_raw as $side){
                $sdata = DB::queryOneRow("SELECT * FROM menu_sides WHERE id=%d", $side["side_id"]);
                $sides[] = array("id"=>$sdata["id"], "name"=>$sdata["name"], "price"=>$sdata["price"], "quantity"=>$side["quantity"]);
                $sides_str .= sprintf("%s, ", $sdata["name"]);
                $tprice += floatval($sdata["price"]);
            }
            $item_data["side"] = $sides;
            $item_data["tprice"] = sprintf("%.02f",$tprice);
            $item_data["sidestr"] = substr($sides_str, 0, count($sides_str)-3);
            array_push($cart, $item_data);
        }
        if (count($cart) > 0){
            $result = 1;
        }
        else{
            $result = 0;
        }
        if (count($items) > 0){
            $cat_item_d = DB::queryOneRow("SELECT * FROM category_items WHERE id=%s", $items[0]["cat_id"]);
            $dprice = $cat_item_d["delivery_fee"];
            $mprice = $cat_item_d["minimum_price"];
        }
        else{
            $dprice = "0";
            $mprice = "0";
        }
        $data = array("deliveryprice"=>$dprice, "minprice"=>$mprice, "cart"=>$cart);
        return json_array($result, $data);
    }

    public function place_order($cid, $pmt, $amount){
//        DB::insertUpdate("account_address", $address, "account_id=%s", $this->data["uid"]);
        $catitem = DB::queryOneRow("SELECT * FROM category_items WHERE id=%s", $cid);
        $now = DB::sqleval("NOW()");
        $data = array(
            "service_id"=>$catitem["category_id"],
            "category_id"=>$cid,
            "time"=>$now,
            "user_id"=>$this->id,
            "payment_cc"=> $pmt == "credit_card" ? "1" : "0"
        );
        DB::insertUpdate("orders", $data);
        $oid = DB::insertId();
        DB::update("carts", array("order_id"=>$oid, "active"=>"0"), "user_id=%s AND active=1", $this->id);

        if ($pmt === 'credit_card' && $this->data['stripe_cust_id']) {
            \Stripe\Stripe::setApiKey(env('STRIPE_API_SECRET'));

            if ($customer = \Stripe\Customer::retrieve($this->data['stripe_cust_id'])) {
                \Stripe\Charge::create([
                    'amount' => $amount,
                    'currency' => 'usd',
                    'source' => $pmt,
                    'customer' => $this->data['stripe_cust_id'],
                    'description' => 'Order from ' . $catitem['name'],
                ]);
            }
        }
        return $oid;
    }


    public function auth_user($email, $password){
        $db_result = DB::queryOneRow("SELECT password_hash, password_salt, uid, permission FROM accounts WHERE email=%s", $email);

        $hashed_password = hash("sha512", $password . $db_result["password_salt"]);

        if ($hashed_password == $db_result["password_hash"]){
            return array($db_result["permission"], $db_result["uid"]); // valid user
        }
        return array(0, 0); // user is not a valid user
    }

    public static function get_users(){
        return DB::query("SELECT * FROM accounts");
    }
    public function changeDetails($uid, $name, $email){
        $data = Array("name"=>$name, "email"=>$email);
        DB::update("accounts",$data,"uid=%s",$uid);
    }
    public function changePassword($uid, $newpass){
        $db_result = DB::queryOneRow("SELECT password_hash, password_salt, uid, permission FROM accounts WHERE uid=%s", $uid);
        $hashed_password = hash("sha512", $newpass . $db_result["password_salt"]);
        $data = Array("password_hash"=>$hashed_password);
        DB::update("accounts",$data,"uid=%s",$uid);
    }

    public static function get_accounts(){
        $users = self::get_users();
        $accounts = array();
        foreach ($users as $user){
            $accounts[] = array($user["name"], $user["phone"], $user["email"]);
        }
        return $accounts;
    }

    public static function adminUpdateUserInformation($type, $uid, $val){
        DB::update("accounts", array($type=>$val), "uid=%s", $uid);
        return DB::queryOneRow("SELECT * FROM accounts WHERE uid=%s", $uid);
    }

    public static function getItemsForCart($userid, $oid){
        $items = "";
        $instructions= "";
        $price = 0.0;
        if ($oid !== -1){
            $cart = DB::query("SELECT * FROm carts WHERE user_id=%s AND active=0 AND order_id=%s", $userid, $oid);
        }
        else {
            $cart = DB::query("SELECT * FROm carts WHERE user_id=%s AND active=%d", $userid, 1);
        }
        foreach ($cart as $cart_item){
            if ($items !== ""){
                $items .= "\n";
            }
            $item = DB::queryOneRow("SELECT * FROM menu_items WHERE id=%s", $cart_item["item_id"]);
            $sides = UserManager::getSidesForCartItem($cart_item["uid"]);
            $sides_html = !$sides["html"] ? "" :  sprintf(" (%s)", $sides["html"]);
            $items .= $item["name"] . $sides_html . " Instructions: " . $cart_item['instructions'];
            $price += floatval($item["price"]) + $sides["price"];
        }
        if (!empty($item)) {
            $price += floatval(DB::queryOneRow("SELECT * FROM category_items WHERE id=%s", $item["service_id"])["delivery_fee"]);
        }

        return array("html"=>$items, "price"=>sprintf("%0.2f",$price));
    }

    public static function getSidesForCartItem($iuid){
        $sides_raw = DB::query("SELECT * FROM cart_sides WHERE cart_entry_uid=%s", $iuid);
        $sides = array();
        $sides_str = "";
        $tprice = 0.0;
        foreach ($sides_raw as $side){
            $sdata = DB::queryOneRow("SELECT * FROM menu_sides WHERE id=%d", $side["side_id"]);
            $sides[] = array("id"=>$sdata["id"], "name"=>$sdata["name"], "price"=>$sdata["price"], "quantity"=>$side["quantity"]);
            $sides_str .= sprintf("%s, ", $sdata["name"]);
            $tprice += floatval($sdata["price"]);
        }

        return array("html"=>substr($sides_str, 0, count($sides_str)-3), "price"=>$tprice);

    }

    public static function getAddressFor($uid){
        return DB::queryOneRow("SELECT * FROM account_address WHERE account_id=%s", $uid);
    }

    public function getAddress(){
        return DB::queryOneRow("SELECT * FROM account_address WHERE account_id=%s", $this->data["uid"]);
    }

    public function delete_user($uid){
        DB::delete($this->table_name, "uid=%s", $uid);
    }

    public function change_password($uid, $name, $password){
        $user = DB::queryOneRow("SELECT name, password_salt FROM accounts", "uid=%s", $uid);
        if ($user === 0){
            return 0;
        }
        if ($user["name"] != $name){
            return 0;
        }
        $new_salt = uniqid(mt_rand(), true);
        $new_password = hash("sha512", $password . $new_salt);
        DB::update($this->table_name, Array("pass"=>$new_password,"salt"=>$new_salt), "uid=%s", $uid);
    }

    public function getOrder($order_id) {
        $order = DB::queryOneRow("SELECT * FROM orders WHERE user_id=%s and id=%d", $this->id, $order_id);
        $categories = DB::query("SELECT * FROM category_items");

        $time   = $order["time"];

        $catname = whereArray($categories, "id", $order["service_id"])["name"];
        $address = UserManager::getAddressFor($order["user_id"]);

        $user   = DB::queryOneRow("SELECT * FROM accounts WHERE uid=%s", $order["user_id"]);
        $items = UserManager::getItemsForCart($order["user_id"], $order["id"]);

        $address_str = sprintf("%s %s \n%s, %s. %s", $address["street"], $address["apartment"], $address["city"], $address["state"], $address["zip"]);

        return array(
            'time' => $time,
            'service' => $catname,
            'recipient' => $user['name'],
            'phone' => $user['phone'],
            'email' => $user['email'], 
            'address' => $address_str,
            'items' => $items['html'],
            'price' => $items['price'],
            'payment_type' => $order['payment_cc'] ? 'Credit Card' : 'Duke Card',
        );
    }
}
