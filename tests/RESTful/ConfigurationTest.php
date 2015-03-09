<?php
namespace RESTful\Test;
use RESTful\Configuration;
use RESTful\DependencyManager;
use RESTful\Environment;
use RESTful\Util\OptionableArray;

/**
 * RESTful - Standalone RESTful server library
 * @author: Daniel Aranda (https://github.com/daniel-aranda/)
 *
 */

class ConfigurationTest extends Base
{

    /**
     * @var \RESTful\Configuration
     */
    private $config;

    protected function setUp()
    {
        $path = $this->getFixturesDirectory() . 'configuration_test.json';
        $this->config = Configuration::factory( $path );
    }

    protected function tearDown()
    {
    }

    public function testFactory()
    {
        $path = $this->getFixturesDirectory() . 'configuration_test.json';
        $instance = Configuration::factory( $path );

        $this->assertInstanceOf('\RESTful\Configuration', $instance);
    }

    public function testDependencyFactory()
    {
        $instance = DependencyManager::get('\RESTful\Configuration');
        $this->assertInstanceOf('\RESTful\Configuration', $instance);
        DependencyManager::reset();
    }

    public function testGetValue(){

        $this->assertSame('value', $this->config->get('system.test.item'));
        $this->assertSame(8, $this->config->get('some'));

    }

    public function testSetValue(){

        $this->config->set('nombre.linda', 'lili');
        $this->assertSame('lili', $this->config->get('nombre.linda'));

        $this->config->set('linda', 'lili');
        $this->assertSame('lili', $this->config->get('linda'));

    }

    public function testEnvironment(){

        $this->assertSame($this->config->environment(), 'unit_test');

    }

    public function testEnvironmentIsSandbox(){

        $path = $this->getFixturesDirectory() . 'configuration_test.json';

        $custom_environment = new Environment(
            new OptionableArray([
                'SERVER_NAME' => 'sandbox.daniel-aranda.com'
            ]),
            false,
            null
        );

        $config = Configuration::factory(
            $path,
            $custom_environment
        );

        $this->assertSame($config->environment(), 'sandbox');

    }

//    public function testGetValueNotFound(){
//
//        $this->setExpectedException('RESTful_Exception_Config_ValueNotSet');
//        $this->config->get('random');
//
//    }
//
//    public function testValueNotSet(){
//
//        $this->setExpectedException('RESTful_Exception_Config_ValueNotSet');
//
//        $data = [];
//
//        $this->config = new RESTful_Config($data);
//
//        $this->config->findEnvironment('sandbox.random.com');
//
//    }

}
/*
class RESTful_ConfigTest extends RESTful_Test_Abstract{

    public function testFindEnvironment(){

        $this->assertSame($this->config->findEnvironment('sandbox.dealerx.com'), 'sandbox');
        $this->assertSame($this->config->findEnvironment('localhost'), 'sandbox');

    }

    public function testFindNotFoundEnvironment(){

        $this->setExpectedException('RESTful_Exception_Config_EnvironmentNotFound');

        $data = [
            "environments" => [
                "development" => [
                    "sandbox.dealerx.com",
                    "localhost"
                ]
            ]
        ];

        $this->config = new RESTful_Config($data);

        $this->config->findEnvironment('sandbox.random.com');

    }

    public function testFindInvalidEnvironment(){

        $this->setExpectedException('RESTful_Exception_Config_InvalidEnvironment');

        $data = [
            "environments" => [
                "development_invalid" => [
                    "sandbox.dealerx.com",
                    "localhost"
                ]
            ]
        ];

        $this->config = new RESTful_Config($data);

        $this->config->findEnvironment('sandbox.dealerx.com');

    }

    public function testGetPerEnvironment(){

        $data = [
            "environments" => [
                "sandbox" => [
                    "sandbox.dealerx.com",
                    "localhost"
                ],
                "unit_test" => [
                    "unit_test"
                ]
            ],
            "db" => [
                "default" => [
                    "data_source_name" => "firebase"
                ],
                "production" => [
                    "data_source_name" => "mysql"
                ],
                "unit_test" => [
                    "data_source_name" => "sqlite:memory"
                ]
            ]
        ];

        $this->config = new RESTful_Config($data);

        $db = $this->config->get_per_environment('db');

        $this->assertSame(['data_source_name' => 'sqlite:memory'], $db);
    }

    public function testGetPerEnvironmentDefault(){

        $data = [
            "environments" => [
                "sandbox" => [
                    "sandbox.dealerx.com",
                    "localhost"
                ],
                "unit_test" => [
                    "unit_test"
                ]
            ],
            "db" => [
                "default" => [
                    "data_source_name" => "firebase"
                ],
                "production" => [
                    "data_source_name" => "mysql"
                ]
            ]
        ];

        $this->config = new RESTful_Config($data);

        $db = $this->config->get_per_environment('db');

        $this->assertSame(['data_source_name' => 'firebase'], $db);
    }

}*/