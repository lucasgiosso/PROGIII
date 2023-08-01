<?php

require_once './models/Pedidos.php';

class PedidosController 
{

    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $longitud = 5;

        $mesa_id = $parametros['mesa_id'];
        $cliente = $parametros['cliente'];
        $empleado_id = $parametros['empleado_id'];
        $estado_id = $parametros['estado_id'];
        $productos_id = $parametros['productos_id'];
        $cantidad = $parametros['cantidad'];

        $precioProducto = Productos::obtenerProducto($productos_id);
        
        foreach($precioProducto as $producto)
        {
          $precio_ = $producto->precio;
        } 

        // Creamos el pedido
        $pedidos = new Pedidos();
        $codigoAlfaNum = bin2hex(random_bytes($longitud));
        $pedidos->pedidoCliente_id = substr($codigoAlfaNum, 0, $longitud);
        $pedidos->mesa_id = $mesa_id;
        $pedidos->cliente = $cliente;
        $pedidos->productos_id = $productos_id;
        $pedidos->empleado_id = $empleado_id;
        $pedidos->precio = $precio_;
        $pedidos->cantidad = $cantidad;
        $pedidos->estado_id = $estado_id;

        $pedidos->crearPedido();

        $payload = json_encode(array("mensaje" => "Pedido creado"));

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

    public static function ModificarUno($request, $response, $args)
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

    public function SubirFoto($request, $response, $args)
    {
      $parametros = $request->getParsedBody();

      $pedidos = new Pedidos();
      $pedidos->id = $parametros['id'];
      $archivo = $_FILES["foto"];
      $pedidos->foto = ($archivo["tmp_name"]);
      $pedidos->GuardarImagen();

      $payload = json_encode(array("mensaje" => "Foto subida asociada al pedido"));

      $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');

    }

    public function CambiarEstadoEnPreparacion($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        
        Pedidos::CambiarEstadoEnPreparacion($parametros['empleado_id'], $parametros['pedido_id'], $parametros['estado_id'], $parametros['tiempoEstimado']);

        $payload = json_encode(array("mensaje" => "Pedido " . $parametros['pedido_id'] . " actualizado a en preparacion"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function CambiarEstadoListoParaServir($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        
        Pedidos::CambiarEstadoListoParaServir($parametros['empleado_id'], $parametros['pedido_id'], $parametros['estado_id']);

        $payload = json_encode(array("mensaje" => "Pedido " . $parametros['pedido_id'] .  " actualizado a listo para servir"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TiempoDemoraPedido($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        
        
        Pedidos::DemoraPedido($parametros['mesa_id'], $parametros['pedido_id']);
        
        $pedidos = Pedidos::obtenerPedido($parametros['pedido_id']);

        foreach($pedidos as $pedido)
        {
          $tiempoEstimado = $pedido->tiempoEstimado;
        }        

        $payload = "El tiempo de demora del pedido " . $parametros['pedido_id'] . " es de ". $tiempoEstimado . " minutos.";
        
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TiempoDemoraPedidoSocio($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        
        
        Pedidos::DemoraPedidoSocio($parametros['pedido_id']);
        
        $pedidos = Pedidos::obtenerPedido($parametros['pedido_id']);

        foreach($pedidos as $pedido)
        {
          $tiempoEstimado = $pedido->tiempoEstimado;
        }        

        $payload = "El tiempo de demora del pedido " . $parametros['pedido_id'] . " es de ". $tiempoEstimado . " minutos.";
        
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    

}