<?php
namespace RESTful\Exception\Request;

/**
 * RESTful - Standalone RESTful server library
 * @author: Daniel Aranda (https://github.com/daniel-aranda/)
 * @package: RESTful\Exception\Environment
 *
 */

class ParsingJSON extends \RESTful\Exception\Request
{

    public function __construct($json)
    {
        $message = 'Error parsing this JSON: ' . $json;
        parent::__construct($message);
    }

}