<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

// DB Connection
require __DIR__ . '/../src/config/db.php';

$app = AppFactory::create();
$app->setBasePath('/Traversy-PHP-Server');
$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();

$app->get('/', function (Request $request, Response $response, array $args) {
    $response->getBody()->write("Hello World");
    return $response;
});

$app->get('/{name}', function (Request $request, Response $response, array $args) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello {$name}");
    return $response;
});

// Customer Routes
require '../src/routes/customers.php';

$app->run();
