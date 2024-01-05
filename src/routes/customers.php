<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// GET All Customers
$app->get('/api/customers', function (Request $request, Response $response) {
    $sql = "SELECT * FROM customers";

    try {
        // Get DB Object
        $db = new DB();
        // connect
        $db = $db->connect();
        $stmt = $db->query($sql);
        $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        $customers = json_encode($customers);
    } catch (PDOException $e) {
        $customers = '{ "error": { "text": ' . $e->getMessage() . '} }';
    }

    $response->getBody()->write($customers);
    return $response;
});
