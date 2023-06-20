<?php
<<<<<<< HEAD
require_once './models/Empleados.php'; 
=======
require_once './models/Empleados.php';
>>>>>>> a93f3d725bf13fb8677d4c7db0c5a4b59d8b5ed8
//srequire_once './interfaces/IApiUsable.php';


class EmpleadosController extends Empleados 
{

    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $rol = $parametros['rol'];
        $nombre = $parametros['nombre'];
        $fechaBaja = $parametros['fechaBaja'];
        $fechaSuspension = $parametros['fechaSuspension'];

        // Creamos el pedido
        $empleados = new Empleados();
        $empleados->rol = $rol;
        $empleados->nombre = $nombre;
        $empleados->fechaBaja = $fechaBaja;
        $empleados->fechaSuspension = $fechaSuspension;
        
        $empleados->crearEmpleado();

        $payload = json_encode(array("mensaje" => "Empleado dado de alta"));

        $response->getBody()->write($payload);
        
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $id = $parametros['id'];

        Empleados::modificarEmpleado($id);

        $payload = json_encode(array("mensaje" => "Empleado modificado"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $id = $parametros['id'];

        Empleados::borrarEmpleado($id);

        $payload = json_encode(array("mensaje" => "Empleado borrado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }



}

?>