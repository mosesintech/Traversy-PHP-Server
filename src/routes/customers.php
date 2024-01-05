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


// GET Single Customer
$app->get('/api/customer/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $sql = "SELECT * FROM customers WHERE id = $id";

    try {
        // Get DB Object
        $db = new DB();
        // connect
        $db = $db->connect();
        $stmt = $db->query($sql);
        $customer = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        $customer = json_encode($customer);
    } catch (PDOException $e) {
        $customer = '{ "error": { "text": ' . $e->getMessage() . '} }';
    }

    $response->getBody()->write($customer);
    return $response;
});


// POST Single Customer
$app->post('/api/customer/create', function (Request $request, Response $response) {
    $params = $request->getParsedBody();
    $first_name = $params['first_name'];
    $last_name = $params['last_name'];
    $phone = $params['phone'];
    $email = $params['email'];
    $address = $params['address'];
    $city = $params['city'];
    $state = $params['state'];

    $sql = "INSERT INTO customers (first_name, last_name, phone, email, address, city, state) VALUES (:first_name, :last_name, :phone, :email, :address, :city, :state)";

    try {
        // Get DB Object
        $db = new DB();
        // connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);

        $stmt->execute();
        $db = null;
        $customer = '{ "notice": { "text": "Customer Added" } }';
    } catch (PDOException $e) {
        $customer = '{ "error": { "text": ' . $e->getMessage() . '} }';
    }

    $response->getBody()->write($customer);
    return $response;
});

// PUT Single Customer
$app->put('/api/customer/update/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $params = $request->getParsedBody();
    $first_name = $params['first_name'];
    $last_name = $params['last_name'];
    $phone = $params['phone'];
    $email = $params['email'];
    $address = $params['address'];
    $city = $params['city'];
    $state = $params['state'];

    $sql = "UPDATE customers SET 
                first_name  = :first_name, 
                last_name   = :last_name, 
                phone       = :phone, 
                email       = :email, 
                address     = :address, 
                city        = :city, 
                state       = :state
            WHERE id=$id";

    try {
        // Get DB Object
        $db = new DB();
        // connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);

        $stmt->execute();
        $db = null;
        $customer = '{ "notice": { "text": "Customer Updated" } }';
    } catch (PDOException $e) {
        $customer = '{ "error": { "text": ' . $e->getMessage() . '} }';
    }

    $response->getBody()->write($customer);
    return $response;
});


// DELETE Single Customer
$app->delete('/api/customer/delete/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $sql = "DELETE FROM customers WHERE id = $id";

    try {
        // Get DB Object
        $db = new DB();
        // connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();

        $db = null;
        $customer = '{ "notice": { "text": "Customer Deleted" } }';
    } catch (PDOException $e) {
        $customer = '{ "error": { "text": ' . $e->getMessage() . '} }';
    }

    $response->getBody()->write($customer);
    return $response;
});
