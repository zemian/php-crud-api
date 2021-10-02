<?php

// Test: http://localhost:3000/my-examples/my-api.php/status/ping

use Tqdev\PhpCrudApi\Api;
use Tqdev\PhpCrudApi\Config;
use Tqdev\PhpCrudApi\RequestFactory;
use Tqdev\PhpCrudApi\ResponseUtils;

require '../vendor/autoload.php';

$config = new Config([
    'username' => 'php-crud-api',
    'password' => 'php-crud-api',
    'database' => 'php-crud-api',
]);
$api = new Api($config);
$response = $api->handle(RequestFactory::fromGlobals());
ResponseUtils::output($response);
