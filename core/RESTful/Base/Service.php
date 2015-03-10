<?php
namespace RESTful\Base;
use RESTful\Response;

/**
 * RESTful - Standalone RESTful server library
 * @author: Daniel Aranda (https://github.com/daniel-aranda/)
 *
 */

abstract class Service{

    protected $data;

    /**
     * @var Response
     */
    protected $response;

    public function __construct(
        array $data,
        Response $response
    ){
        $this->data = $data;
        $this->response = $response;
    }

}