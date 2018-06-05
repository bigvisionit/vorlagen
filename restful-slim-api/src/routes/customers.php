<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

$app->options('/{routes:.+}', function($request, $response, $args) {
    return $response;
});

$app->add(function($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

// Get All Customers
$app->get('/api/customers', function(Request $request, Response $response) {
    try {
        $db = new Database();
        $customers = $db->select("* FROM customers");
        echo json_encode($customers);
    } catch(PDOException $e) {
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Get Single Customer
$app->get('/api/customer/{id}', function(Request $request, Response $response) {
    $id = $request->getAttribute('id');
    try {
        $db = new Database();
        $customer = $db->selectOne("* FROM customers WHERE id = :id", [ 'id' => $id ]);
        echo json_encode($customer);
    } catch(PDOException $e) {
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Add Customer
$app->post('/api/customer/add', function(Request $request, Response $response) {
    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $phone = $request->getParam('phone');
    $email = $request->getParam('email');
    $address = $request->getParam('address');
    $city = $request->getParam('city');
    $state = $request->getParam('state');
    try {
        $db = new Database();
        $added = $db->insertInto(
            "customers 
             (first_name,last_name,phone,email,address,city,state) 
             VALUES (:first_name,:last_name,:phone,:email,:address,:city,:state)",
            [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'phone' => $phone,
                'email' => $email,
                'address' => $address,
                'city' => $city,
                'state' => $state
            ]
        );
        if($added) echo '{"notice": {"text": "Customer Added"}';
    } catch(PDOException $e) {
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Update Customer
$app->put('/api/customer/update/{id}', function(Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $phone = $request->getParam('phone');
    $email = $request->getParam('email');
    $address = $request->getParam('address');
    $city = $request->getParam('city');
    $state = $request->getParam('state');
    try {
        $db = new Database();
        $bindArr = [ 'id' => $id ];
        if($first_name != null) $bindArr['first_name'] = $first_name;
        if($last_name != null) $bindArr['last_name'] = $last_name;
        if($phone != null) $bindArr['phone'] = $phone;
        if($email != null) $bindArr['email'] = $email;
        if($address != null) $bindArr['address'] = $address;
        if($city != null) $bindArr['city'] = $city;
        if($state != null) $bindArr['state'] = $state;
        $updated = $db->update(
            "customers SET " .
            (($first_name != null)? "first_name = :first_name, " : "") .
            (($last_name != null)? "last_name = :last_name, " : "") .
            (($phone != null)? "phone = :phone, " : "") .
            (($email != null)? "email = :email, " : "") .
            (($address != null)? "address = :address, " : "") . 
            (($city != null)? "city = :city, " : "") .
            (($state != null)? "state = :state " : "") .
            "WHERE id = :id",
            $bindArr
        );
        if($updated) echo '{"notice": {"text": "Customer Updated"}';
    } catch(PDOException $e) {
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Delete Customer
$app->delete('/api/customer/delete/{id}', function(Request $request, Response $response) {
    $id = $request->getAttribute('id');
    try {
        $db = new Database();
        $deleted = $db->deleteFrom("customers WHERE id = :id", [ 'id' => $id ]);
        if($deleted) echo '{"notice": {"text": "Customer Deleted"}';
    } catch(PDOException $e) {
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});