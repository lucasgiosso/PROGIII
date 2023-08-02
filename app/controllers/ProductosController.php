<?php

<<<<<<< HEAD
use Illuminate\Support\Facades\Process;

require_once './models/Productos.php';
require_once './models/CSV.php';
=======
require_once './models/Productos.php';
>>>>>>> a93f3d725bf13fb8677d4c7db0c5a4b59d8b5ed8

class ProductosController extends Productos 
{

    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

<<<<<<< HEAD
        $nombreProducto = $parametros['nombreProducto'];
=======
        $nombre = $parametros['nombre'];
>>>>>>> a93f3d725bf13fb8677d4c7db0c5a4b59d8b5ed8
        $precio = $parametros['precio'];
        $rol = $parametros['rol'];

        // Creamos el pedido
        $productos = new Productos();
<<<<<<< HEAD
        $productos->nombreProducto = $nombreProducto;
        $productos->precio = $precio;
        $productos->rol = $rol;

=======
        $productos->nombre = $nombre;
        $productos->precio = $precio;
        $productos->rol = $rol;


>>>>>>> a93f3d725bf13fb8677d4c7db0c5a4b59d8b5ed8
        $productos->crearProducto();

        $payload = json_encode(array("mensaje" => "Producto creado"));

        $response->getBody()->write($payload);
        
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

<<<<<<< HEAD
    public function TraerTodos($request, $response, $args)
    {
        $lista = Productos::obtenerTodosProductos();

        $payload = json_encode(array("listadoProductos" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        $id = $args['id'];

        $id = Productos::obtenerProducto($id);
        $payload = json_encode($id);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

=======
>>>>>>> a93f3d725bf13fb8677d4c7db0c5a4b59d8b5ed8
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

<<<<<<< HEAD
    public function ExportarProductos($request, $response, $args)
    {
        $nombreArchivo = "productos.csv";
        $destino = "." . DIRECTORY_SEPARATOR . "csv" . DIRECTORY_SEPARATOR;

        if (!file_exists($destino))
        {
            mkdir($destino, 0777, true);
        }

        Productos::ExportarProducto($destino . $nombreArchivo);

        $payload = json_encode(array("mensaje" => "Exportado"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function ImportarProductos($request, $response, $args)
    {
        $nombreArchivo = "productos.csv";
        $destino = "." . DIRECTORY_SEPARATOR . "csv" . DIRECTORY_SEPARATOR . $nombreArchivo;

        Productos::ImportarProducto($destino);

        $payload = json_encode(array("mensaje" => "Importado"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

=======
>>>>>>> a93f3d725bf13fb8677d4c7db0c5a4b59d8b5ed8


}