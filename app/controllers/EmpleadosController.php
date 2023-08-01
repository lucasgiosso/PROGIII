<?php
require_once './models/Empleados.php';
require_once './models/CSV.php'; 

//srequire_once './interfaces/IApiUsable.php';

class EmpleadosController extends Empleados
{
  public function CrearTokenLogin($request, $response, $args)
  {
      $parametros = $request->getParsedBody();
  
      $usuarioEnBD = Empleados::obtenerEmpleado($parametros["id"]);
        
      if ($usuarioEnBD != null) 
      {
          if ($parametros["clave"] == $usuarioEnBD->clave) 
          {
                array(
                  'id' => $usuarioEnBD->id, 
                  'clave' => $usuarioEnBD->clave,
                  'rol' => $usuarioEnBD->rol,
                  'tipo' => $usuarioEnBD->tipo
                );
  
              $token = AuthenticadorJWT::CrearToken($parametros["id"], $parametros["clave"], $parametros["rol"], $parametros["tipo"]);
              $payload = json_encode(array('jwt' => $token));
              $response->getBody()->write($payload);
          } 
          else 
          {
            $response->getBody()->write("Error en los datos ingresados");
              
          }
      } else {
          $response->getBody()->write("El usuario no existe");
      }
  
      return $response->withHeader('Content-Type', 'application/json');
  }

    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $clave = $parametros['clave'];
        $rol = $parametros['rol'];
        $nombre = $parametros['nombre'];
        //$fechaBaja = $parametros['fechaBaja'];
        //$fechaSuspension = $parametros['fechaSuspension'];
        $tipo = $parametros['tipo'];

        // Creamos el pedido
        $empleados = new Empleados();
        $empleados->clave = $clave;
        $empleados->rol = $rol;
        $empleados->nombre = $nombre;
        //$empleados->fechaBaja = $fechaBaja;
        //$empleados->fechaSuspension = $fechaSuspension;
        $empleados->tipo = $tipo;
        
        $empleados->crearEmpleado();

        $payload = json_encode(array("mensaje" => "Empleado dado de alta"));

        $response->getBody()->write($payload);
        
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Empleados::obtenerTodosEmpleados();

        $payload = json_encode(array("listadoEmpleados" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        $id = $args['id'];
        
        $id = Empleados::obtenerEmpleado($id);
        $payload = json_encode($id);

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

    public function PendientesCocinero($request, $response, $args)
    {       
        
        $lista = Empleados::obtenerPendientesCocinero();

        $payload = json_encode(array("Listado Pendiente/s Cocinero" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function EnPreparacionCocinero($request, $response, $args)
    {   
        $lista = Empleados::obtenerEnPreparacionCocinero();

        $payload = json_encode(array("Listado En Preparacion Cocinero" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function PendientesBartender($request, $response, $args)
    {   
        $lista = Empleados::obtenerPendientesBartender();

        $payload = json_encode(array("Listado Pendiente/s Bartender" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function EnPreparacionBartender($request, $response, $args)
    {   
        $lista = Empleados::obtenerEnPreparacionBartender();

        $payload = json_encode(array("Listado En Preparacion Bartender" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function PendientesCervecero($request, $response, $args)
    {   
        $lista = Empleados::obtenerPendientesCervecero();

        $payload = json_encode(array("Listado Pendiente/s Cervecero" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function EnPreparacionCervecero($request, $response, $args)
    {   
        $lista = Empleados::obtenerEnPreparacionCervecero();

        $payload = json_encode(array("Listado En Preparacion Cervecero" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function ListosParaServirMozo($request, $response, $args)
    {   
        $lista = Empleados::obtenerListosParaServirMozo();

        $payload = json_encode(array("Listado Listo para servir del mozo" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function ExportarEmpleados($request, $response, $args)
    {
        $nombreArchivo = "empleados.csv";
        $destino = "." . DIRECTORY_SEPARATOR . "csv" . DIRECTORY_SEPARATOR;

        if (!file_exists($destino))
        {
            mkdir($destino, 0777, true);
        }

        Empleados::ExportarEmpleado($destino . $nombreArchivo);

        $payload = json_encode(array("mensaje" => "Exportado"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function ImportarEmpleados($request, $response, $args)
    {
        $nombreArchivo = "empleados.csv";
        $destino = "." . DIRECTORY_SEPARATOR . "csv" . DIRECTORY_SEPARATOR . $nombreArchivo;

        Empleados::ImportarEmpleado($destino);

        $payload = json_encode(array("mensaje" => "Importado"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    

}

?>