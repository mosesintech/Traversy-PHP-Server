<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();
$app->setBasePath('/Traversy-PHP-Server');
$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->get('/', function (Request $request, Response $response, array $args) {
    $response->getBody()->write("Hello World");
    return $response;
});

$app->get('/{name}', function (Request $request, Response $response, array $args) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello {$name}");
    return $response;
});

$app->run();
