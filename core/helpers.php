<?php

define("MINUTES", 60);
define("HOURS", MINUTES * 60);
define("DAYS", HOURS * 24);
define("MONTHS", DAYS * 30);

function pp($var){
    if( defined('PHPUNIT_RESTful') || php_sapi_name() == "cli"){
        echo PHP_EOL;
    }else{
        echo "<pre style='background-color: black; color: white;padding: 10px;word-wrap: break-word;'>";
    }
    foreach(func_get_args() as $argument){
        print_r($argument);
    }
    if( defined('PHPUNIT_RESTful') || php_sapi_name() == "cli"){
        echo PHP_EOL;
    }else{
        echo "</pre>";
    }
}

function pt($var){
    foreach(func_get_args() as $argument){
        echo $argument . PHP_EOL;
    }
}

function pd($var){
    call_user_func_array('pp', func_get_args());
    exit;
}

function remove_multi_spaces($input){
    return preg_replace('/\s+/ms', ' ', $input);
}

function array_find($field, $value, $array){

    foreach($array as $index => $row){
        if( $row[$field] === $value ){
            return $row;
        }
    }

    return null;
}

function get_last_char($string){
    return substr($string, -1);
}

function array_find_item_non_sensitive($value, $array){

    foreach($array as $index => $row){
        if( preg_match('/^'.$value.'$/i', $row) ){
            return $row;
        }
    }

}

function set_cookie($key, $cookie, $device_expiration, $domain){
    setcookie($key, $cookie, $device_expiration, '/', $domain);
}

function remove_cookie($key, $domain){
    $_COOKIE[ $key ] = null;
    setcookie($key, null, time() - 360, "/", $domain);
}