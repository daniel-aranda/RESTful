<?php
namespace RESTful\Exception\Server;

/**
 * RESTful - Standalone RESTful server library
 * @author: Daniel Aranda (https://github.com/daniel-aranda/)
 * @package: RESTful\Exception\Environment
 *
 */

class MethodNotSupported extends \RESTful\Exception\Server
{

    public function __construct($request_method)
    {
        $message = 'Method not supported: ' . $request_method;
        parent::__construct($message);
    }

}