<?php

class Cookies {
    public static $logintime = 3600;
    public static $path = "/";
    public static $domain = null;
    public static $secure = false;

    public function __construct() {}

    public function user_from_cookie(){
        if (!isset($_COOKIE["session"])){return 0;}
            if ($_COOKIE['session'] == "0"){return 0;}
                $user = DB::queryOneRow("SELECT * FROM accounts WHERE session=%s", $_COOKIE['session']);
        if (count($user)==0){
            return 0;
        }
        return new UserManager($user);
    }

    public function set_cookie($user_id){
        $cookie_guid = GUID(50);
        setCookie("session", $cookie_guid, time()+self::$logintime, self::$path, self::$domain, self::$secure);
        //			setCookie("expire",time()+1800, time()+self::$logintime, self::$path, self::$domain, self::$secure);
        DB::update("accounts", Array("session"=>$cookie_guid, "logintime"=>strval(time())), "uid=%s", $user_id);
        return $cookie_guid;
    }

    public function del_cookie($user_id){
        setCookie("session", "-1", time()-60, self::$path, self::$domain, self::$secure);
        //			setCookie("expire","0", time()-60, self::$path, self::$domain, self::$secure);
        DB::update("accounts", Array("session"=>"0", "logintime"=>"0"), "uid=%s", $user_id);
    }

    public function renew_cookie($user_id){
        if (!isset($_COOKIE['session'])){
            return;
        }
        setCookie("session", $_COOKIE['session'], time()+self::$logintime, self::$path, self::$domain, self::$secure);
        //			setCookie("expire", time()+1800, time()+self::$logintime, self::$path, self::$domain, self::$secure);
        DB::update("accounts", Array("logintime"=>strval(time())), "uid=%s", $user_id);
    }

    public function check_active_cookies(){
        $active = DB::query("SELECT uid, logintime FROM users");
        $removed = 0;
        foreach ($active as $active_user){
            $curtime = time();
            $logtime = intval($active_user["logintime"]);
            if (($curtime - $logtime) >= self::$logintime){
                $removed += 1;
                DB::update("accounts", Array("logintime"=>"0", "session"=>"0"), "uid=%s", $active_user["uid"]);
            }
        }
        return $removed;
    }
}
