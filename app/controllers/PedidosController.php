<?php

require_once './models/Pedidos.php';

class PedidosController extends Empleados 
{

    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $productos_id = $parametros['productos_id'];
        $empleado_id = $parametros['empleado_id'];
        $cantidad = $parametros['cantidad'];
        $tiempoEstimado = $parametros['tiempoEstimado'];
        $estado = $parametros['estado'];

        // Creamos el pedido
        $pedidos = new Pedidos();
        $pedidos->productos_id = $productos_id;
        $pedidos->empleado_id = $empleado_id;
        $pedidos->precio = Productos::obtenerTodosProductos($productos_id);
        $pedidos->cantidad = $cantidad;
        $pedidos->tiempoEstimado = $tiempoEstimado;
        $pedidos->estado = $estado;

        $pedidos->crearPedido();

        $payload = json_encode(array("mensaje" => "Pedido creado, enviado a comanda..."));

        $response->getBody()->write($payload);
        
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Pedidos::obtenerTodosPedidos();

        $payload = json_encode(array("listadoPedidos" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        $id = $args['id'];
        
        $id = Pedidos::obtenerPedido($id);
        $payload = json_encode($id);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $id = $parametros['id'];

        Pedidos::modificarPedido($id);

        $payload = json_encode(array("mensaje" => "Pedido modificado"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $id = $parametros['id'];

        Pedidos::borrarPedido($id);

        $payload = json_encode(array("mensaje" => "Pedido borrado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }



}