# RESTful Slim API

This is a RESTful Slim API built with the SlimPHP framework and uses MySQL for storage.

### Version
1.0.1

### Usage

GET: http://localhost/restful-slim-api/public/api/customers

GET: http://localhost/restful-slim-api/public/api/customer/{id}

POST (INSERT): http://localhost/restful-slim-api/public/api/customer/add

PUT (UPDATE): http://localhost/restful-slim-api/public/api/customer/update/{id}

DELETE: http://localhost/restful-slim-api/public/api/customer/delete/{id}

### Example Code to get customer by id

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

### Installation

Create database or import from _sql/slimapp.sql

Edit the prarams in config/config.php

You can also install SlimPHP and dependencies with composer for new version of SlimPHP

```sh
$ composer require slim/slim "^3.10"
```
3.10 is the version you want to install (or change the version in "composer.json")
