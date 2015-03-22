<?php
/**
 * RESTful - Standalone RESTful server library
 * @author: Daniel Aranda (https://github.com/daniel-aranda/)
 *
 * This file(api.php) should be set in the public folder of the server and include the autoload from bootstrap, that
 * is all that you need to have it running. Just double checking something obvious, please remember that composer folder
 * should NOT be in the public folder.
 */
require __DIR__ . '/../vendor/autoload.php';

$response = new \RESTful\Response();

$response->addEventHandler(\RESTful\Response::HEADER_ADDED_EVENT, function(\RESTful\Response $response, $header){
    header($header);
});

$response->addEventHandler(\RESTful\Response::OUTPUT_EVENT, function(\RESTful\Response $response){
    echo $response->getResponse();
});

$request = \RESTful\Request::factory('test_service/add');

$server = new \RESTful\Server(
    $response
);

$server->addEventHandler(RESTful\Server::BEFORE_EXECUTE_SERVICE, function(\RESTful\Request $request){
    $request->setAllowed( $request->getGroup() != 'admin' );
});

$server->execute($request);
