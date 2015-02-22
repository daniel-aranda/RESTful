<?php
namespace RESTful\Exception\Environment;

/**
 * RESTful - Standalone RESTful server library
 * @author: Daniel Aranda (https://github.com/daniel-aranda/)
 * @package: RESTful\Exception\Environment
 *
 */

class CannotGetHost extends \RESTful\Exception\Base
{

    public function __construct(array $server)
    {
        $message = 'Can\'t get the host. ' . var_export($server, true);
        parent::__construct($message);
    }

}