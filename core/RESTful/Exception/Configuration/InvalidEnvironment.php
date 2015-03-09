<?php
namespace RESTful\Exception\Configuration;
use RESTful\Exception\Configuration;

/**
 * RESTful - Standalone RESTful server library
 * @author: Daniel Aranda (https://github.com/daniel-aranda/)
 * @package: RESTful\Exception
 *
 */

class InvalidEnvironment extends Configuration{

    public function __construct($environment){

        $message = 'Invalid environment: ' . $environment;

        parent::__construct($message);
    }

}