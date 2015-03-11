<?php
namespace RESTful\Service;
use RESTful\Base\Service;

/**
 * RESTful - Standalone RESTful server library
 * @author: Daniel Aranda (https://github.com/daniel-aranda/)
 *
 */

class TestService extends Service{

    public function getAdd(){
        return ['works'];
    }

    public function getNumber(){
        return 5;
    }

}
