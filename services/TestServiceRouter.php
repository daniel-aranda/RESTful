<?php
namespace RESTful\Service;
use RESTful\Base\Service;

/**
 * RESTful - Standalone RESTful server library
 * @author: Daniel Aranda (https://github.com/daniel-aranda/)
 *
 */

class TestServiceRouter extends Service{

    public function getRouter(){
        return ['working'];
    }

}
