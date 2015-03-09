<?php
namespace RESTful\Test;
use RESTful\Environment;

/**
 * RESTful - Standalone RESTful server library
 * @author: Daniel Aranda (https://github.com/daniel-aranda/)
 *
 */

abstract class Base extends \PHPUnit_Framework_TestCase
{

    protected function getTestsDirectory(){
        return Environment::path('tests' . DIRECTORY_SEPARATOR);
    }

    protected function getFixturesDirectory(){
        $path = $this->getTestsDirectory();
        return $path . 'fixtures' . DIRECTORY_SEPARATOR;
    }

}