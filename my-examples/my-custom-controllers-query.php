<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Tqdev\PhpCrudApi\Api;
use Tqdev\PhpCrudApi\Config;
use Tqdev\PhpCrudApi\Controller\Responder;
use Tqdev\PhpCrudApi\Database\GenericDB;
use Tqdev\PhpCrudApi\Middleware\Router\Router;
use Tqdev\PhpCrudApi\Record\RecordService;
use Tqdev\PhpCrudApi\RequestFactory;
use Tqdev\PhpCrudApi\ResponseUtils;

require '../vendor/autoload.php';

class MyHelloController {
    private RecordService $service;
    private Responder $responder;
    private GenericDB $db;

    public function __construct(Router $router, Responder $responder, RecordService $service)
    {
        $this->service = $service;
        $this->responder = $responder;

        // TODO: Is there alternative way than this hack?
        // Extract private "db" property from RecordService
        $privateDbProp = new ReflectionProperty(RecordService::class, 'db');
        $privateDbProp->setAccessible(true);
        $this->db = $privateDbProp->getValue($service);

        $router->register('GET', '/hello', array($this, '_getHello'));
    }

    function _getHello(ServerRequestInterface $request): ResponseInterface
    {
        $query = "SELECT * FROM posts WHERE content like '%blog%'";
        $stmt = $this->db->pdo()->prepare($query);
        $stmt->execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $this->responder->success($records);
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
