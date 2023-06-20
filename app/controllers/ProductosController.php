<?php

require_once './models/Productos.php';

class ProductosController extends Productos 
{

    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $nombre = $parametros['nombre'];
        $precio = $parametros['precio'];
        $rol = $parametros['rol'];

        // Creamos el pedido
        $productos = new Productos();
        $productos->nombre = $nombre;
        $productos->precio = $precio;
        $productos->rol = $rol;


        $productos->crearProducto();

        $payload = json_encode(array("mensaje" => "Producto creado"));

        $response->getBody()->write($payload);
        
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $id = $parametros['id'];

        Productos::modificarProducto($id);

        $payload = json_encode(array("mensaje" => "Producto modificado"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $id = $parametros['id'];

        Productos::borrarProducto($id);

        $payload = json_encode(array("mensaje" => "Producto borrado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }



}