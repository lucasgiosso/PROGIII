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
require_once './middlewares/AuthenticadorJWT.php';
require_once './middlewares/VerificadorPMW.php';

require_once './controllers/EmpleadosController.php';
<<<<<<< HEAD
require_once './controllers/EncuestaController.php';
require_once './controllers/MesasController.php';
require_once './controllers/PedidosController.php';
require_once './controllers/ProductosController.php';
require_once './controllers/LogIngresosController.php';
=======
require_once './controllers/ProductosController.php';
require_once './controllers/PedidosController.php';
require_once './controllers/MesasController.php';
>>>>>>> 561cd04d31978d7eb71751c2b67fc5f7eb3abf09

// Load ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Instantiate App
$app = AppFactory::create();

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add parse body
$app->addBodyParsingMiddleware();

$app->post('/empleados/login[/]', \EmpleadosController::class . ':CrearTokenLogin');
$app->post('/prueba/login[/]', \LogIngresosController::class . ':CrearTokenLogin');

// Routes
$app->group('/empleados', function (RouteCollectorProxy $group) {
    $group->get('[/]', \EmpleadosController::class . ':TraerTodos');
    $group->get('/{id}', \EmpleadosController::class . ':TraerUno');
<<<<<<< HEAD
    $group->get('/pendientes/mozo', \EmpleadosController::class . ':PendientesMozo') ->add(\VerificadorPMW::class . ':ValidarMozo');
    $group->get('/pendientes/cocinero', \EmpleadosController::class . ':PendientesCocinero')->add(\VerificadorPMW::class . ':ValidarCocinero'); 
    $group->get('/enPreparacion/cocinero', \EmpleadosController::class . ':EnPreparacionCocinero')->add(\VerificadorPMW::class . ':ValidarCocinero');
    $group->get('/pendientes/bartender', \EmpleadosController::class . ':PendientesBartender')->add(\VerificadorPMW::class . ':ValidarBartender');
    $group->get('/enPreparacion/bartender', \EmpleadosController::class . ':EnPreparacionBartender')->add(\VerificadorPMW::class . ':ValidarBartender');
    $group->get('/pendientes/cervecero', \EmpleadosController::class . ':PendientesCervecero')->add(\VerificadorPMW::class . ':ValidarCervecero');
    $group->get('/enPreparacion/cervecero', \EmpleadosController::class . ':EnPreparacionCervecero')->add(\VerificadorPMW::class . ':ValidarCervecero');
    $group->get('/listoParaServir/mozo', \EmpleadosController::class . ':ListosParaServirMozo')->add(\VerificadorPMW::class . ':ValidarMozo');
    $group->get('/guardar/CSV[/]', \EmpleadosController::class . ':ExportarEmpleados')->add(\VerificadorPMW::class . ':ValidarSocio');
    $group->get('/leer/CSV[/]', \EmpleadosController::class . ':ImportarEmpleados')->add(\VerificadorPMW::class . ':ValidarSocio');
    $group->post('[/]', \EmpleadosController::class . ':CargarUno')->add(\VerificadorPMW::class . ':ValidarSocio');
  }) ->add(\VerificadorPMW::class . ':ValidarToken');

$app->group('/productos', function (RouteCollectorProxy $group) {
    $group->get('[/]', \ProductosController::class . ':TraerTodos');
    $group->get('/{id}', \ProductosController::class . ':TraerUno');
    $group->post('[/]', \ProductosController::class . ':CargarUno');
    $group->get('/guardar/CSV[/]', \ProductosController::class . ':ExportarProductos');
    $group->get('/leer/CSV[/]', \ProductosController::class . ':ImportarProductos');
  })  ->add(\VerificadorPMW::class . ':ValidarSocio')
      ->add(\VerificadorPMW::class . ':ValidarToken');

$app->group('/pedidos', function (RouteCollectorProxy $group) {
    $group->get('[/]', \PedidosController::class . ':TraerTodos');
    $group->get('/{id}', \PedidosController::class . ':TraerUno');
    $group->post('/cargar[/]', \PedidosController::class . ':CargarUno') ->add(\VerificadorPMW::class . ':ValidarMozo'); 
    $group->post('/borrar', \PedidosController::class . ':BorrarUno') ->add(\VerificadorPMW::class . ':ValidarMozo');
    $group->post('/enPreparacion/bartender[/]', \PedidosController::class . ':CambiarEstadoEnPreparacion')->add(\VerificadorPMW::class . ':ValidarBartender');
    $group->post('/listoParaServir/bartender[/]', \PedidosController::class . ':CambiarEstadoListoParaServir')->add(\VerificadorPMW::class . ':ValidarBartender');
    $group->post('/enPreparacion/cocinero[/]', \PedidosController::class . ':CambiarEstadoEnPreparacion')->add(\VerificadorPMW::class . ':ValidarCocinero');
    $group->post('/listoParaServir/cocinero[/]', \PedidosController::class . ':CambiarEstadoListoParaServir')->add(\VerificadorPMW::class . ':ValidarCocinero');
    $group->post('/enPreparacion/cervecero[/]', \PedidosController::class . ':CambiarEstadoEnPreparacion')->add(\VerificadorPMW::class . ':ValidarCervecero');
    $group->post('/listoParaServir/cervecero[/]', \PedidosController::class . ':CambiarEstadoListoParaServir')->add(\VerificadorPMW::class . ':ValidarCervecero');
    $group->post('/subirFoto[/]', \PedidosController::class . ':SubirFoto') ->add(\VerificadorPMW::class . ':ValidarMozo');
    $group->post('/consulta/pedido', \PedidosController::class . ':TiempoDemoraPedido');
    $group->get('/socio/listadoPedido', \PedidosController::class . ':TraerTodos')->add(\VerificadorPMW::class . ':ValidarSocio');
    $group->post('/socio/consulta/pedido', \PedidosController::class . ':TiempoDemoraPedidoSocio')->add(\VerificadorPMW::class . ':ValidarSocio');
    //$group->post('/socio/consulta/demora', \PedidosController::class . ':')->add(\VerificadorPMW::class . ':ValidarSocio');
  }); //->add(\VerificadorPMW::class . ':ValidarToken');

$app->group('/mesas', function (RouteCollectorProxy $group) {
    $group->get('[/]', \MesasController::class . ':TraerTodos');
    $group->get('/{id}', \MesasController::class . ':TraerUno');
    $group->post('[/]', \MesasController::class . ':CargarUna')->add(\VerificadorPMW::class . ':ValidarSocio'); 
    $group->post('/mozo/clienteComiendo', \MesasController::class . ':MesaComiendo')->add(\VerificadorPMW::class . ':ValidarMozo');
    $group->post('/mozo/clientePagando', \MesasController::class . ':MesaPagando')->add(\VerificadorPMW::class . ':ValidarMozo');
    $group->post('/socio/mesacerrada', \MesasController::class . ':MesaCerrada')->add(\VerificadorPMW::class . ':ValidarSocio'); 
    $group->get('/socio/mesaMasUsada', \MesasController::class . ':mesaVecesMasUsada')->add(\VerificadorPMW::class . ':ValidarSocio'); 
  })->add(\VerificadorPMW::class . ':ValidarToken');;

$app->group('/clientes', function (RouteCollectorProxy $group) {
  $group->get('/consulta/pedido', \ClienteController::class . ':DemoraPedidoCliente');
});

$app->group('/encuestas', function (RouteCollectorProxy $group) {
  $group->post('/responder/encuesta', \EncuestasController::class . ':CargarUna');
  $group->get('/comentarios/socios', \EncuestasController::class . ':TraerBuenosComentarios')->add(\VerificadorPMW::class . ':ValidarSocio'); 
});
=======
    $group->post('[/]', \EmpleadosController::class . ':CargarUno');
  });
>>>>>>> 561cd04d31978d7eb71751c2b67fc5f7eb3abf09

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
    $payload = json_encode(array("mensaje" => "La Comanda 2023"));
    
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
