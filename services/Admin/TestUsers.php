<?php
namespace RESTful\Service\Admin;
use RESTful\Base\Service;

/**
 * RESTful - Standalone RESTful server library
 * @author: Daniel Aranda (https://github.com/daniel-aranda/)
 *
 */

class TestUsers extends Service{

    public function getAdd(){
        return ['users works'];
    }

}
