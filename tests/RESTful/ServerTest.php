<?php
namespace RESTful\Test;
use RESTful\Request;
use RESTful\Response;
use RESTful\Server;
use PHPRocks\Util\OptionableArray;

/**
 * RESTful - Standalone RESTful server library
 * @author: Daniel Aranda (https://github.com/daniel-aranda/)
 *
 */

class ServerTest extends Base
{

    /**
     * @var Server
     */
    private $server;

    public function setUp(){

        $this->server = new Server(
            new Response()
        );
    }

    public function testExecute(){
        $request = new Request(
            '/test_service/add',
            new OptionableArray([]),
            new OptionableArray([]),
            new OptionableArray([]),
            ''
        );

        $this->server->execute($request);
        $this->assertSame('["works"]', $this->server->getResponse()->getResponse());
    }

    public function testExecuteChildView(){
        $request = new Request(
            '/test_service/55/comments',
            new OptionableArray([]),
            new OptionableArray([]),
            new OptionableArray([]),
            ''
        );

        $this->server->execute($request);
        $this->assertSame('["working","comments"]', $this->server->getResponse()->getResponse());
    }

    public function testExecuteGroupView(){
        $request = new Request(
            '/admin/test_users/add',
            new OptionableArray([]),
            new OptionableArray([]),
            new OptionableArray([]),
            '',
            ['admin']
        );

        $this->server->execute($request);
        $this->assertSame('["users works"]', $this->server->getResponse()->getResponse());
    }

    public function testExecuteNotAllowed(){
        $request = new Request(
            '/admin/test_users/update',
            new OptionableArray([]),
            new OptionableArray([]),
            new OptionableArray([]),
            '',
            ['admin']
        );

        $this->server->addEventHandler(Server::BEFORE_EXECUTE_SERVICE, function(Request $request){
            $request->setAllowed(false);
        });
        $this->server->addEventHandler(Server::NOT_ALLOWED, function(Request $request){
            $this->assertFalse($request->isAllowed());
        });

        $this->server->execute($request);

    }

    public function testExecuteWithRouter(){
        $request = new Request(
            '/test_service_router/update',
            new OptionableArray([
                'HTTP_CONTENT_TYPE' => Request::APPLICATION_JSON
            ]),
            new OptionableArray([]),
            new OptionableArray([]),
            '{"field":"value"}'
        );

        $this->server->execute($request);
        $this->assertSame('["working"]', $this->server->getResponse()->getResponse());
    }

    public function testExecuteResponseNumeric(){
        $request = new Request(
            '/test_service/number',
            new OptionableArray([]),
            new OptionableArray([]),
            new OptionableArray([]),
            ''
        );

        $this->server->execute($request);
        $this->assertSame('5', $this->server->getResponse()->getResponse());
    }

    public function testNotSupportedRequestMethod(){

        $message = 'Method not supported: test_service->putAdd';
        $this->setExpectedException('RESTful\Exception\Server\MethodNotSupported', $message);

        $request = new Request(
            '/test_service/add',
            new OptionableArray([
                'REQUEST_METHOD' => 'PUT'
            ]),
            new OptionableArray([]),
            new OptionableArray([]),
            ''
        );

        $this->server->execute($request);

    }

    public function testNotSupportedMethod(){

        $this->setExpectedException('RESTful\Exception\Server\MethodNotSupported');

        $request = new Request(
            '/test_service/delete',
            new OptionableArray([
            ]),
            new OptionableArray([]),
            new OptionableArray([]),
            ''
        );

        $this->server->execute($request);

    }

    public function testServiceNotFound() {
        $this->setExpectedException('RESTful\Exception\Server\ServiceNotFound');

        $request = new Request(
            '/random_service',
            new OptionableArray([
                'REQUEST_METHOD' => 'PUT'
            ]),
            new OptionableArray([]),
            new OptionableArray([]),
            ''
        );

        $this->server->execute($request);
    }

}