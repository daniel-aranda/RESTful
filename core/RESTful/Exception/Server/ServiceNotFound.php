<?php
namespace RESTful\Exception\Server;

/**
 * RESTful - Standalone RESTful server library
 * @author: Daniel Aranda (https://github.com/daniel-aranda/)
 * @package: RESTful\Exception\Environment
 *
 */

class ServiceNotFound extends \RESTful\Exception\Server
{

    public function __construct($service)
    {
        $message = 'Service not Found: ' . $service;
        parent::__construct($message);
    }

}