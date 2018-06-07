<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../src/config/config.php';
spl_autoload_register(function($className) {
    require_once '../src/libraries/'. $className . '.php';
});

// Customer Routes
require '../src/routes/customers.php';

$app->run();