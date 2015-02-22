<?php
namespace RESTful\Test;

/**
 * RESTful - Standalone RESTful server library
 * @author: Daniel Aranda (https://github.com/daniel-aranda/)
 * 
 */

use \RESTful\Environment;

class EnvironmentTest extends Base
{

    public function testWorks(){
        $item = Environment::factory();
        $this->assertSame(Environment::UNIT_TEST, $item->domain());
    }

}