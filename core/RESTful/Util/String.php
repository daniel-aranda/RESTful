<?php
namespace RESTful\Util;

/**
 * RESTful - Standalone RESTful server library
 * @author: Daniel Aranda (https://github.com/daniel-aranda/)
 *
 */

class String
{

    /**
     * @param $string
     * @return mixed|string
     *
     * Transform daniel_test into DanielTest, so we can use camel cased classes as services
     */
    public static function underscoreToCamelCase($string){
        return preg_replace_callback('/(_|^)([a-z0-9])/', function($matches){
            return strtoupper($matches[2]);
        }, $string);
    }


}