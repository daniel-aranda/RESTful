<?php
namespace RESTful\Exception\Configuration;
use RESTful\Exception\Configuration;

/**
 * RESTful - Standalone RESTful server library
 * @author: Daniel Aranda (https://github.com/daniel-aranda/)
 * @package: RESTful\Exception
 *
 */

class EnvironmentNotFound extends Configuration{

    public function __construct($domain){

        $message = 'Environment not found for this domain: ' . $domain;

        parent::__construct($message);
    }

}