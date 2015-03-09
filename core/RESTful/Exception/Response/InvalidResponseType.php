<?php
namespace RESTful\Exception\Response;

/**
 * RESTful - Standalone RESTful server library
 * @author: Daniel Aranda (https://github.com/daniel-aranda/)
 * @package: RESTful\Exception\Environment
 *
 */

class InvalidResponseType extends \RESTful\Exception\Response
{

    public function __construct($response_type)
    {
        $message = 'Invalid response type: ' . $response_type;
        parent::__construct($message);
    }

}