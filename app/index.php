<?php
// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;

require __DIR__ . '/../vendor/autoload.php';

require_once './db/AccesoDatos.php';
// require_once './middlewares/Logger.php';

require_once './controllers/EmpleadosController.php';
require_once './controllers/ProductosController.php';
require_once './controllers/PedidosController.php';
require_once './controllers/MesasController.php';

// Load ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Instantiate App
$app = AppFactory::create();

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add parse body
$app->addBodyParsingMiddleware();

// Routes
$app->group('/empleados', function (RouteCollectorProxy $group) {
    $group->get('[/]', \EmpleadosController::class . ':TraerTodos');
    $group->get('/{id}', \EmpleadosController::class . ':TraerUno');
    $group->post('[/]', \EmpleadosController::class . ':CargarUno');
  });

$app->group('/productos', function (RouteCollectorProxy $group) {
    $group->get('[/]', \ProductosController::class . ':TraerTodos');
    $group->get('/{id}', \ProductosController::class . ':TraerUno');
    $group->post('[/]', \ProductosController::class . ':CargarUno');
  });

$app->group('/pedidos', function (RouteCollectorProxy $group) {
    $group->get('[/]', \PedidosController::class . ':TraerTodos');
    $group->get('/{id}', \PedidosController::class . ':TraerUno');
    $group->post('[/]', \PedidosController::class . ':CargarUno');
  });

$app->group('/mesas', function (RouteCollectorProxy $group) {
    $group->get('[/]', \MesasController::class . ':TraerTodos');
    $group->get('/{id}', \MesasController::class . ':TraerUno');
    $group->post('[/]', \MesasController::class . ':CargarUna');
  });


$app->get('[/]', function (Request $request, Response $response) {    
    $payload = json_encode(array("mensaje" => "Funciona nuevamente"));
    
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
