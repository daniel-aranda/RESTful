<?php
namespace RESTful\Exception;

/**
 * RESTful - Standalone RESTful server library
 * @author: Daniel Aranda (https://github.com/daniel-aranda/)
 *
 */

class Base extends \Exception
{

    public $server_status_code = 500;

}
