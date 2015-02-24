<?php
namespace RESTful\Test;

use RESTful\Util\OptionableArray;

/**
 * RESTful - Standalone RESTful server library
 * @author: Daniel Aranda (https://github.com/daniel-aranda/)
 *
 */

class OptionableArrayTest extends Base
{
    /**
     * @var OptionableArray
     */
    private $optionableArray;

    protected function setUp(){
        $this->optionableArray = new OptionableArray([
            'property_1' => 5,
            'property_2' => '',
            'property_3' => null,
            'property_4' => false,
            'property_5' => true,
            'property_6' => 'hi',
            'property_7' => 0
        ]);
    }

    public function testGet(){

        $this->assertSame(5, $this->optionableArray->get('property_1'));
        $this->assertSame(null, $this->optionableArray->get('property_2'));
        $this->assertSame(null, $this->optionableArray->get('property_3'));
        $this->assertSame(null, $this->optionableArray->get('property_4'));
        $this->assertSame(true, $this->optionableArray->get('property_5'));
        $this->assertSame('hi', $this->optionableArray->get('property_6'));
        $this->assertSame(0, $this->optionableArray->get('property_7'));
        $this->assertSame(null, $this->optionableArray->get('not_set'));

    }

    public function testHas(){

        $this->assertTrue($this->optionableArray->has('property_1'));
        $this->assertTrue($this->optionableArray->has('property_2'));
        $this->assertTrue($this->optionableArray->has('property_3'));
        $this->assertTrue($this->optionableArray->has('property_4'));
        $this->assertTrue($this->optionableArray->has('property_5'));
        $this->assertTrue($this->optionableArray->has('property_6'));
        $this->assertTrue($this->optionableArray->has('property_7'));
        $this->assertNotTrue($this->optionableArray->has('not_set'));

    }

}