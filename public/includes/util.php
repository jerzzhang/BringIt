<?php

function json_array($result=null, $data=null, $message=null){
    $arr = array("result"=>$result, "message"=>$message, "data"=>$data);
    return json_encode($arr);
}

function set_vars($v, $arr){
    foreach($arr as $i){
        if (!isset($v[$i])){
            return false;
        }
    }
    return true;
}

function whereArray($arr, $w, $v){
    foreach ($arr as $a){
        if ($a[$w] == $v){
            return $a;
        }
    }
}

function arrayTo1d($arr){
    $f = array();
    foreach ($arr as $a){
        $i = array();
        foreach ($a as $k=>$v){
            $i[$k] = $v;
        }
        array_push($f, $i);
    }
    return $f;
}

function zip(array $x, array $y){
    $zipped = array();
    foreach (array_intersect(array_keys($x), array_keys($y)) as $key) {
        $zipped[$key] = array($x[$key], $y[$key]);
    }
    return $zipped;
}

function refineArray($arr, $keys){
    $narr = array();
    foreach ($arr as $a){
        $ir = array();
        foreach ($keys as $k){
            $ir[] = $a[$k];
        }
        $narr[] = $ir;
    }
    return $narr;
}

function refineArrayKeepKeys($arr, $keys){
    $narr = array();
    foreach ($arr as $a){
        $ir = array();
        foreach ($keys as $k){
            $ir[$k] = $a[$k];
        }
        $narr[] = $ir;
    }
    return $narr;
}

function refineArrayReductively($arr, $keys){
    $arr2 = array();
    foreach ($arr as $a){
        foreach ($keys as $k){
            unset($a[$k]);
        }
        $arr2[] = $a;
    }
    return $arr2;
}
// add $v to each array inside $arr, $front defines location of insertion
function addToEachArray($arr, $v, $front){
    $arr2 = array();
    foreach ($arr as $a){
        $arr3 = array();
        if ($front){
            $arr3[] = $v;
        }
        foreach ($a as $i){
            $arr3[] = $i;
        }
        if (!$front){
            $arr3[] = $v;
        }
        $arr2[] = $arr3;
    }
    return $arr2;
}

function htmlLoop($arr, $start, $format, $end){
    $html = "\n";
    $html .= $start;
    foreach ($arr as $items){
        $args = array();
        for ($i = 0; $i < count($items); $i++){
            $args[] = $items[$i];
        }
        $html .= vsprintf($format, $args);
    }
    return $html . $end . "\n";
}

function htmlLoopNamed($arr, $start, $format, $end){
    $html = "\n";
    $html .= $start;
    foreach ($arr as $items){
        $html .= vsprintf_named($format, $items);
    }
    return $html . $end . "\n";
}

function getSetting($name){
    $r = DB::queryOneRow("SELECT value FROM settings WHERE name=%s", $name);
    if ($r){
        return $r["value"];
    }
    return $r;
}

function uploadImage($file){
    $name = $file['name'];
    $size = $file['size'];
    $tmp_l = $file['tmp_name'];

    $tn = explode(".", $name);
    $ext = end($tn);
    $allowed_extensions = explode(",", getSetting("imageexts"));

    $gid = GUID(50);
    $gname = sprintf("../../images/%s.%s", $gid, $ext);

    while (file_exists($gname)){
        $gid = GUID(50);
        $gname = sprintf("../../images/%s.%s", $gid, $ext);
    }


    // valid name, proceed
    if (in_array($ext, $allowed_extensions)){
        $result = move_uploaded_file($tmp_l, $gname);
        if ($result){
            return sprintf("%s.%s", $gid, $ext);
        }
    }
    return -1;

}

function vsprintf_named($format, $args) {
    $names = preg_match_all('/%\((.*?)\)/', $format, $matches, PREG_SET_ORDER);

    $values = array();
    foreach($matches as $match) {
        $values[] = $args[$match[1]];
    }

    $format = preg_replace('/%\((.*?)\)/', '%', $format);
    return vsprintf($format, $values);
}

/**
 * Removes everything but numbers, then checks its size to ensure 10 or 7 numbers.
 *   NOTE: Does not support extensions
 * @param $phone mixed is the phone number but is treated as a string
 * @param $ext boolean if set to true return an array with extension separated
 * @return
 **/
 function isPhone($phone, $ext = false) {
    
    // Strips non numeric values out
    $numbers = preg_replace("%[^0-9]%", "", $phone );

    // Get the length of numbers supplied
    $length = strlen($numbers);

    // Validate size - must be 10 or 7
    if ( $length == 10 || $length == 7 ) {
        return $numbers;
    }

    // Was not a good number
    return false;

}

/**
 * Parse and format a string of hours.
 */
function sanitizeHours($hours) {
    $slots = explode(',', $hours);

    $formatted = [];
    foreach ($slots as $slot) {
        $matches = [];
        // verify a proper match
        if (preg_match('/^(\w+)\s+(.+)-(.+)/', trim($slot), $matches)) {
            $day_of_week = strtotime($matches[1]);
            $start_time = strtotime($matches[2]);
            $end_time = strtotime($matches[3]);

            // format if everything matched correctly
            if ($day_of_week && $start_time && $end_time) {
                $formatted[] = date('D', $day_of_week) . ' ' . date('g a', $start_time) . ' - ' . date('g a', $end_time);
            }
        }
    }
    return implode(',', $formatted);
}
