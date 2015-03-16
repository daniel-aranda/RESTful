<?php
namespace RESTful\Exception\Request;

/**
 * RESTful - Standalone RESTful server library
 * @author: Daniel Aranda (https://github.com/daniel-aranda/)
 * @package: RESTful\Exception\Environment
 *
 */

class CanNotLocateRemoteIP extends \RESTful\Exception\Request
{

    public function __construct()
    {
        $message = 'No remote IP address found';
        parent::__construct($message);
    }

}