<?php
namespace RESTful\Test;
use RESTful\Response;

/**
 * RESTful - Standalone RESTful server library
 * @author: Daniel Aranda (https://github.com/daniel-aranda/)
 *
 */

class ResponseTest extends Base
{

    /**
     * @var Response
     */
    private $response;

    protected function setUp() {
        $this->response = new Response();
    }

    public function testRenderResponse() {

        $output = null;
        $this->response->addEventHandler(Response::OUTPUT_EVENT, function(Response $response) use (&$output){
            $output = $response->getResponse();
        });

        $this->response->setResponse('Hello World');

        $this->response->render();

        $this->assertSame('"Hello World"', $output);

    }

    public function testMultiRenderResponse() {

        $output = '';
        $this->response->addEventHandler(Response::OUTPUT_EVENT, function(Response $response) use (&$output){
            $output .= $response->getResponse();
        });

        $this->response->setResponseType(Response::TEXT);

        $this->response->setResponse('Hello World ');

        $this->response->render();

        $this->response->setResponse('Lili is the best');

        $this->response->render();

        $this->assertSame('Hello World Lili is the best', $output);

    }

    public function testReceiveHeaders() {

        $received_header = null;
        $this->response->addEventHandler(Response::HEADER_ADDED_EVENT, function(Response $response, $header) use (&$received_header){
            $received_header = $header;
        });

        $this->response->render();

        $this->assertSame(Response::JSON, $this->response->getResponseType());
        $this->assertTrue($this->response->isJSON());
        $this->assertSame('Content-Type: application/json', $received_header);

    }

    public function testHtmlHeaders() {

        $received_header = null;
        $this->response->addEventHandler(Response::HEADER_ADDED_EVENT, function(Response $response, $header) use (&$received_header){
            $received_header = $header;
        });

        $this->response->setResponseType(Response::HTML);
        $this->response->render();

        $this->assertTrue($this->response->isHtml());
        $this->assertSame('Content-Type: text/html', $received_header);

    }

    public function testTextHeaders() {

        $received_header = null;
        $this->response->addEventHandler(Response::HEADER_ADDED_EVENT, function(Response $response, $header) use (&$received_header){
            $received_header = $header;
        });

        $this->response->setResponseType(Response::TEXT);
        $this->response->render();

        $this->assertTrue($this->response->isText());
        $this->assertSame('Content-Type: text/plain', $received_header);

    }

    public function testSwapHeadersWithContentNotYetRendered() {


        $received_header = null;
        $this->response->addEventHandler(Response::HEADER_ADDED_EVENT, function(Response $response, $header) use (&$received_header){
            $received_header = $header;
        });

        $this->response->setResponseType(Response::HTML);

        $this->response->setResponseType(Response::TEXT);

        $this->response->render();

        $this->assertSame('Content-Type: text/plain', $received_header);

    }

    public function testSwapHeadersWithContentRendered() {


        $this->setExpectedException('RESTful\Exception\Response\CanNotSwapResponseType');

        $received_header = null;
        $this->response->addEventHandler(Response::HEADER_ADDED_EVENT, function(Response $response, $header) use (&$received_header){
            $received_header = $header;
        });

        $this->response->setResponseType(Response::HTML);
        $this->response->render();

        $this->assertSame('Content-Type: text/html', $received_header);

        $this->response->setResponseType(Response::TEXT);

    }

    public function testSetInvalidResponseType() {


        $this->setExpectedException('RESTful\Exception\Response\InvalidResponseType');

        $this->response->setResponseType('RANDOM');

    }

}