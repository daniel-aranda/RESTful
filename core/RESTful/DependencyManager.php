<?php
namespace RESTful;

/**
 * RESTful - Standalone RESTful server library
 * @author: Daniel Aranda (https://github.com/daniel-aranda/)
 *
 */

final class DependencyManager
{

    protected static $instances = [];

    public static function factory($class_name, array $arguments = [])
    {
        $reflector = new \ReflectionClass($class_name);
        $instance = null;

        if( $reflector->hasMethod('factory') ){
            $method = new \ReflectionMethod( $class_name, 'factory' );
            if ( $method->isStatic() && $method->isPublic() )
            {
                $instance = call_user_func_array([$class_name, 'factory'], $arguments);
            }

        }

        if( is_null($instance) ){
            $instance = $reflector->newInstanceArgs($arguments);
        }

        return $instance;
    }

    public static function add($class_name, array $arguments = [])
    {
        $key = static::key($class_name, $arguments);
        static::$instances[$key] = static::factory($class_name, $arguments);
    }

    public static function get($class_name, array $arguments = [])
    {
        $key = static::key($class_name, $arguments);
        if( !static::has($class_name, $arguments) ){
            static::add($class_name, $arguments);
        }
        return static::$instances[$key];
    }

    public static function has($class_name, array $arguments = [])
    {
        $key = static::key($class_name, $arguments);
        return array_key_exists($key, static::$instances);
    }

    private static function key($class_name, array $arguments = [])
    {
        return md5($class_name . json_encode($arguments));
    }

    public static function reset()
    {
        static::$instances = [];
    }

}