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

$response->addHeaderHandler = function(\RESTful\Response $response, $header){
    header($header);
};

$response->outputHandler = function(\RESTful\Response $response){
    echo $response->getResponse();
};

$request = new \RESTful\Request(
    '/test_service/add',
    new \RESTful\Util\OptionableArray([]),
    new \RESTful\Util\OptionableArray([]),
    ''
);

$server = new \RESTful\Server(
    $response
);
$server->execute($request);
