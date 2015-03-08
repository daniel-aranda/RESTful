<?php
namespace RESTful\Test;
use RESTful\DependencyManager;
use RESTful\Util\OptionableArray;

/**
 * RESTful - Standalone RESTful server library
 * @author: Daniel Aranda (https://github.com/daniel-aranda/)
 *
 */


class DependencyManagerTest extends Base
{

    private static $class_name = '\RESTful\Util\OptionableArray';

    protected function tearDown()
    {
        DependencyManager::reset();
    }

    public function testFactory()
    {

        $instance = DependencyManager::factory(static::$class_name, [[]]);

        $this->assertInstanceOf(static::$class_name, $instance);

        $this->assertFalse(DependencyManager::has(static::$class_name, [[]]));

    }

    public function testAdd()
    {
        $this->assertFalse(DependencyManager::has(static::$class_name, [[]]));

        DependencyManager::add(static::$class_name, [[]]);

        $this->assertTrue(DependencyManager::has(static::$class_name, [[]]));
    }

    public function testGet()
    {
        $this->assertFalse(DependencyManager::has(static::$class_name, [[]]));

        $instance = DependencyManager::get(static::$class_name, [[]]);

        $this->assertTrue(DependencyManager::has(static::$class_name, [[]]));

        $this->assertInstanceOf(static::$class_name, $instance);
    }

    public function testReset()
    {
        $this->assertFalse(DependencyManager::has(static::$class_name, [[]]));

        DependencyManager::get(static::$class_name, [[]]);

        $this->assertTrue(DependencyManager::has(static::$class_name, [[]]));

        DependencyManager::reset();

        $this->assertFalse(DependencyManager::has(static::$class_name, [[]]));
    }

}