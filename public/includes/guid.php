<?php

function gen_guid32()
{
    return sprintf('%04X%04X%04X%04X%04X%04X%04X%04X', 
        mt_rand(0, 65535), 
        mt_rand(0, 65535), 
        mt_rand(0, 65535), 
        mt_rand(16384, 20479), 
        mt_rand(32768, 49151), 
        mt_rand(0, 65535), 
        mt_rand(0, 65535), 
        mt_rand(0, 65535)
    );
}

function GUID($rptt=32){
    $final = "";
    for ($i = 0; $i < floor($rptt/32); $i++){
        $final .= gen_guid32();
    }
    $final .= substr(gen_guid32(),0,($rptt - (32 * floor($rptt/32))));
    return $final;
}

function generate_until_satisfied($check){
    $guid = GUID();
    while (!$check($guid)){
        $guid = GUID();
    }
    return $guid;
}
