<?php
namespace RESTful\Exception\Response;

/**
 * RESTful - Standalone RESTful server library
 * @author: Daniel Aranda (https://github.com/daniel-aranda/)
 * @package: RESTful\Exception\Environment
 *
 */

class CanNotSwapResponseType extends \RESTful\Exception\Response
{

    public function __construct()
    {
        $message = 'You cannot change the response type because content has already been rendered';
        parent::__construct($message);
    }

}