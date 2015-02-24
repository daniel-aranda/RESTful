<?php
namespace RESTful\Util;

/**
 * RESTful - Standalone RESTful server library
 * @author: Daniel Aranda (https://github.com/daniel-aranda/)
 *
 */

class OptionableArray
{

    /**
     * @var array
     */
    protected  $list;

    public function __construct(array $list){
        $this->list = $list;
    }

    public function get($key){
        if( !$this->has($key) ){
            return null;
        }
        $value = $this->list[$key];
        if( $value === '' || $value === false ){
            return null;
        }

        return $value;
    }

    public function has($key){
        return array_key_exists($key, $this->list);
    }

    public function source(){
        return $this->list;
    }

}