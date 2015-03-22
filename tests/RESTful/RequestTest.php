<?php
namespace RESTful\Test;
use RESTful\Request;
use PHPRocks\Util\OptionableArray;


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
        $this->assertSame(null, $this->request->getGroup());
        $this->assertSame(null, $this->request->getGroups());
    }

    public function testDumbGetters() {
        $this->assertSame('/vehicles/23', $this->request->getPath());
        $this->assertInstanceOf('PHPRocks\Util\OptionableArray', $this->request->getServer());
        $this->assertInstanceOf('PHPRocks\Util\OptionableArray', $this->request->getPost());
        $this->assertInstanceOf('PHPRocks\Util\OptionableArray', $this->request->getGet());
        $this->assertSame('{"field1":"value1","field2":"value2"}', $this->request->getPhpInput());
        $this->assertSame('/vehicles/23', $this->request->getRequestUrl());
    }

    public function testGetData() {
        $data = $this->request->getData();

        $expected = [
            'field1' => 'value1',
            'field2' => 'value2'
        ];
        $this->assertSame($expected, $data);
    }

    public function testRequestWithGroup() {

        $request = new Request(
            '/admin/vehicles/23',
            new OptionableArray([
                'CONTENT_TYPE' => Request::APPLICATION_JSON
            ]),
            new OptionableArray([]),
            new OptionableArray([]),
            '{"field1":"value1","field2":"value2"',
            ['admin', 'manager']
        );

        $this->assertSame('admin', $request->getGroup());
    }

    public function testExceptionParsingJSON() {
        $this->setExpectedException('PHPRocks\Exception\Util\JSON');

        $request = new Request(
            '/vehicles/23',
            new OptionableArray([
                'CONTENT_TYPE' => Request::APPLICATION_JSON
            ]),
            new OptionableArray([]),
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
            new OptionableArray([]),
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
            new OptionableArray([]),
            ''
        );

        $this->assertSame('vehicles', $request->getService());
        $this->assertSame('get', $request->getRequestMethod());
        $this->assertSame('model', $request->getMethod());
        $this->assertSame(['11','22','33'], $request->getArguments());

    }

    public function testGetRemoteIP() {

        $server = [
            'REMOTE_ADDR' => '200.95.65.30'
        ];

        $this->assertSame('200.95.65.30', Request::getRemoteIP($server));

        $server = [
            'HTTP_CLIENT_IP' => '200.95.65.28',
            'REMOTE_ADDR' => '200.95.65.30'
        ];

        $this->assertSame('200.95.65.28', Request::getRemoteIP($server));

        $server = [
            'HTTP_CLIENT_IP' => '200.95.65.28',
            'HTTP_X_FORWARDED_FOR' => '200.95.65.27',
            'REMOTE_ADDR' => '200.95.65.30'
        ];

        $this->assertSame('200.95.65.28', Request::getRemoteIP($server));

        $server = [
            'HTTP_X_FORWARDED_FOR' => '200.95.65.27',
            'REMOTE_ADDR' => '200.95.65.30'
        ];

        $this->assertSame('200.95.65.27', Request::getRemoteIP($server));

    }

    public function testRemoteIPNotFound() {

        $this->setExpectedException('RESTful\Exception\Request');

        $this->assertSame(null, Request::getRemoteIP());

    }

}