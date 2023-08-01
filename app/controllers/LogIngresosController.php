<?php

require_once './models/Empleados.php';
require_once './models/LogIngresos.php';

class LogIngresosController extends Empleados
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
                Empleados::crearLog($parametros["id"], $parametros["tipo"], $parametros["rol"]);
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
}
?>