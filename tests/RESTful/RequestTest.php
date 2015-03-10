<?php
namespace RESTful\Test;
use RESTful\Request;
use RESTful\Util\OptionableArray;


/**
 * RESTful - Standalone RESTful server library
 * @author: Daniel Aranda (https://github.com/daniel-aranda/)
 *
 */

class RequestTest extends Base
{

    /**
     * @var Request
     */
    private $request;

    protected function setUp() {
        $this->request = new Request(
            '/vehicles/23',
            new OptionableArray([
                'CONTENT_TYPE' => Request::APPLICATION_JSON
            ]),
            new OptionableArray([]),
            '{"field1":"value1","field2":"value2"}'
        );
    }

    public function testFactory() {
        $this->assertInstanceOf('RESTful\Request', Request::factory('/vehicles/55'));
    }

    public function testInvalidate() {
        $this->assertSame('vehicles', $this->request->getService());
        $this->assertSame('get', $this->request->getRequestMethod());
        $this->assertSame('index', $this->request->getMethod());
        $this->assertSame([23], $this->request->getArguments());
    }

    public function testGetData() {
        $data = $this->request->getData();

        $expected = [
            'field1' => 'value1',
            'field2' => 'value2'
        ];
        $this->assertSame($expected, $data);
    }

    public function testExceptionParsingJSON() {
        $this->setExpectedException('RESTful\Exception\Request\ParsingJSON');

        $request = new Request(
            '/vehicles/23',
            new OptionableArray([
                'CONTENT_TYPE' => Request::APPLICATION_JSON
            ]),
            new OptionableArray([]),
            '{"field1":"value1","field2":"value2"'
        );

        $request->getData();
    }

    public function testPOST() {

        $request = new Request(
            '/vehicles/23',
            new OptionableArray([
                'CONTENT_TYPE' => Request::FORM_URLENCODED,
                'REQUEST_METHOD' => 'POST'
            ]),
            new OptionableArray([
                'some_field' => 'some_value'
            ]),
            ''
        );

        $data = $request->getData();

        $expected = [
            'some_field' => 'some_value'
        ];
        $this->assertSame($expected, $data);
    }

    public function testSpecificMethod() {

        $request = new Request(
            '/vehicles/model',
            new OptionableArray([
                'CONTENT_TYPE' => Request::APPLICATION_JSON
            ]),
            new OptionableArray([]),
            ''
        );

        $this->assertSame('vehicles', $request->getService());
        $this->assertSame('get', $request->getRequestMethod());
        $this->assertSame('model', $request->getMethod());
        $this->assertSame([], $request->getArguments());

    }

    public function testThreeArguments() {

        $request = new Request(
            '/vehicles/model/11/22/33',
            new OptionableArray([
                'CONTENT_TYPE' => Request::APPLICATION_JSON
            ]),
            new OptionableArray([]),
            ''
        );

        $this->assertSame('vehicles', $request->getService());
        $this->assertSame('get', $request->getRequestMethod());
        $this->assertSame('model', $request->getMethod());
        $this->assertSame(['11','22','33'], $request->getArguments());

    }

}