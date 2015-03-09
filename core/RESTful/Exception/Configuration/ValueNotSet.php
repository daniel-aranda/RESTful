<?php
namespace RESTful\Exception\Configuration;
use RESTful\Exception\Configuration;

/**
 * RESTful - Standalone RESTful server library
 * @author: Daniel Aranda (https://github.com/daniel-aranda/)
 * @package: RESTful\Exception
 *
 */

class ValueNotSet extends Configuration{

    public function __construct($value){

        $message = 'Value not set: ' . $value;

        parent::__construct($message);
    }

}