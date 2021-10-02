<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Tqdev\PhpCrudApi\Api;
use Tqdev\PhpCrudApi\Config;
use Tqdev\PhpCrudApi\Controller\Responder;
use Tqdev\PhpCrudApi\Middleware\Router\Router;
use Tqdev\PhpCrudApi\Record\RecordService;
use Tqdev\PhpCrudApi\RequestFactory;
use Tqdev\PhpCrudApi\ResponseUtils;

require '../vendor/autoload.php';

class MyHelloController {
    /**
     * @var RecordService
     */
    private $service;
    /**
     * @var Responder
     */
    private $responder;

    public function __construct(Router $router, Responder $responder, RecordService $service)
    {
        $this->service = $service;
        $this->responder = $responder;

        $router->register('GET', '/hello', array($this, '_getHello'));
    }

    function _getHello(ServerRequestInterface $request): ResponseInterface
    {
        return $this->responder->success(['message' => "Hello World!"]);
    }
}

$config = new Config([
    'username' => 'php-crud-api',
    'password' => 'php-crud-api',
    'database' => 'php-crud-api',
    'customControllers' => 'MyHelloController',
]);
$api = new Api($config);
$response = $api->handle(RequestFactory::fromGlobals());
ResponseUtils::output($response);
