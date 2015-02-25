<?php
namespace RESTful\Test;

/**
 * RESTful - Standalone RESTful server library
 * @author: Daniel Aranda (https://github.com/daniel-aranda/)
 * 
 */

use RESTful\Environment;
use RESTful\Util\OptionableArray;

class EnvironmentTest extends Base
{
    /**
     * @var Environment
     */
    private $environment;

    protected function setUp(){
        $this->environment = Environment::factory();
    }

    public function testDomain(){
        $this->assertSame(Environment::UNIT_TEST, $this->environment->domain());
    }

    public function testProtocol(){
        $this->assertSame('cmd', $this->environment->protocol());
    }

    public function testUrl(){
        $this->assertSame('cmd://unit_test', $this->environment->url());
    }

    public function testIsValid(){
        $this->assertTrue(Environment::isValid(Environment::PRODUCTION));
        $this->assertTrue(Environment::isValid(Environment::DEV));
        $this->assertTrue(Environment::isValid(Environment::STAGE));
        $this->assertTrue(Environment::isValid(Environment::UNIT_TEST));
        $this->assertTrue(Environment::isValid(Environment::CLI));
    }

    public function testCustomDomain(){
        $environment = new Environment(
            new OptionableArray([
                'HTTP_HOST' => 'danielarandaochoa.com'
            ]),
            false,
            'random'
        );

        $this->assertSame('http', $environment->protocol());
        $this->assertSame('danielarandaochoa.com', $environment->domain());
    }

    public function testNotDomain(){

        $this->setExpectedException('RESTful\Exception\Environment\CannotGetHost');

        $environment = new Environment(
            new OptionableArray([
                'HTTP_HOST' => null
            ]),
            false,
            'random'
        );

        $environment->domain();
    }

     public function testSSL(){
        $environment = new Environment(
            new OptionableArray([
                'HTTP_HOST' => 'danielarandaochoa.com',
                'HTTPS' => 'on'
            ]),
            false,
            'random'
        );

        $this->assertSame('https', $environment->protocol());
        $this->assertSame('danielarandaochoa.com', $environment->domain());
    }

}