<?php

require_once './middlewares/VerificadorPMW.php';
require_once './middlewares/AuthenticadorJWT.php';
require_once './db/AccesoDatos.php';

use GuzzleHttp\Psr7\Response;

class VerificadorPMW
{
    public static function ValidarToken($request, $handler)
    {
        $header = $request->getHeaderLine('Authorization');
        $response = new Response();

        if (!empty($header))
        {
            $token = trim(explode("Bearer", $header)[1]);
            AuthenticadorJWT::VerificarToken($token);
            $response = $handler->handle($request);
        }
        else 
        {
            $response->getBody()->write(json_encode(array("Token error" => "No hay token")));
            $response = $response->withStatus(401);
        }
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function ValidarAdmin($request, $handler)
    {
            $header = $request->getHeaderLine('Authorization');
            $response = new Response();
            
            if(!empty($header))
            {
                $token = trim(explode("Bearer", $header)[1]);
                
                $data = AuthenticadorJWT::ObtenerPayLoad($token);
                                
                if (isset($data) && isset($data->tipo) && $data->tipo == "Admin") 
                {
                    return $handler->handle($request);
                }
                else 
                {
                    $response->getBody()->write(json_encode(array("Error. Usuario no autorizado" => "Unicamente el tipo de usuario Admin tiene acceso")));
                    $response = $response->withStatus(401);
                }
            }
            else
            {
                $response->getBody()->write(json_encode(array("Error de admin. Usuario no autorizado" => "Necesitas un token de admin")));
                $response = $response->withStatus(401);
            }
            return $response->withHeader('Content-Type', 'application/json');;
    }

    public function ValidarEmpleado($request, $handler)
    {
            $header = $request->getHeaderLine('Authorization');
            $response = new Response();
            
            if(!empty($header))
            {
                $token = trim(explode("Bearer", $header)[1]);
                               
                $data = AuthenticadorJWT::ObtenerPayLoad($token);
                                
                if (isset($data) && isset($data->tipo) && $data->tipo == "empleado") 
                {
                    return $handler->handle($request);
                }
                else 
                {
                    $response->getBody()->write(json_encode(array("Error" => "Unicamente el tipo de usuario empleado tiene acceso")));
                    $response = $response->withStatus(401);

                }
            }
            else
            {
                $response->getBody()->write(json_encode(array("Error" => "Necesitas un token")));
                $response = $response->withStatus(401);
            }
            return $response->withHeader('Content-Type', 'application/json');;
    }

    public function ValidarSocio($request, $handler)
    {
            $header = $request->getHeaderLine('Authorization');
            $response = new Response();
            $data = null;
            
            if(!empty($header))
            {
                $token = trim(explode("Bearer", $header)[1]);
                
                $data = AuthenticadorJWT::ObtenerPayLoad($token);
                                
                if (isset($data) && isset($data->rol) && $data->rol == "Socio" || $data->rol == "Socia") 
                {
                    return $handler->handle($request);
                }
                else 
                {
                    $response->getBody()->write(json_encode(array("Error. Usuario no autorizado" => "Unicamente el rol Socio/a tiene acceso")));
                    $response = $response->withStatus(401);
                }
            }
            else
            {
                
                $response->getBody()->write(json_encode(array("Error de admin. Usuario no autorizado" => "Necesitas un token de Socio/a")));
                $response = $response->withStatus(401);
            }
            return $response->withHeader('Content-Type', 'application/json');;
    }

    public function ValidarBartender($request, $handler)
    {
            $header = $request->getHeaderLine('Authorization');
            $response = new Response();
            
            if(!empty($header))
            {
                $token = trim(explode("Bearer", $header)[1]);
                
                $data = AuthenticadorJWT::ObtenerPayLoad($token);
                                
                if (isset($data) && isset($data->rol) && $data->rol == "Bartender") 
                {
                    return $handler->handle($request);
                }
                else 
                {
                    $response->getBody()->write(json_encode(array("Error. Usuario no autorizado" => "Unicamente el tipo de usuario Bartender tiene acceso")));
                    $response = $response->withStatus(401);
                }
            }
            else
            {
                $response->getBody()->write(json_encode(array("Error de admin. Usuario no autorizado" => "Necesitas un token de Bartender")));
                $response = $response->withStatus(401);
            }
            return $response->withHeader('Content-Type', 'application/json');;
    }

    public function ValidarCocinero($request, $handler)
    {
            $header = $request->getHeaderLine('Authorization');
            $response = new Response();
            
            if(!empty($header))
            {
                $token = trim(explode("Bearer", $header)[1]);
                
                $data = AuthenticadorJWT::ObtenerPayLoad($token);
                                
                if (isset($data) && isset($data->rol) && $data->rol == "Cocinero" || $data->rol == "Cocinera") 
                {
                    return $handler->handle($request);
                }
                else 
                {
                    $response->getBody()->write(json_encode(array("Error. Usuario no autorizado" => "Unicamente el tipo de usuario Cocinero/a tiene acceso")));
                    $response = $response->withStatus(401);
                }
            }
            else
            {
                $response->getBody()->write(json_encode(array("Error de admin. Usuario no autorizado" => "Necesitas un token de Cocinero/a")));
                $response = $response->withStatus(401);
            }
            return $response->withHeader('Content-Type', 'application/json');;
    }

    public function ValidarMozo($request, $handler)
    {
            $header = $request->getHeaderLine('Authorization');
            $response = new Response();
            
            if(!empty($header))
            {
                $token = trim(explode("Bearer", $header)[1]);
                
                $data = AuthenticadorJWT::ObtenerPayLoad($token);
                                
                if (isset($data) && isset($data->rol) && $data->rol == "Mozo" || $data->rol == "Moza") 
                {
                    return $handler->handle($request);
                }
                else 
                {
                    $response->getBody()->write(json_encode(array("Error. Usuario no autorizado" => "Unicamente el tipo de usuario Mozo/a tiene acceso")));
                    $response = $response->withStatus(401);
                }
            }
            else
            {
                $response->getBody()->write(json_encode(array("Error de admin. Usuario no autorizado" => "Necesitas un token de Mozo/a")));
                $response = $response->withStatus(401);
            }
            return $response->withHeader('Content-Type', 'application/json');;
    }

    public function ValidarCervecero($request, $handler)
    {
            $header = $request->getHeaderLine('Authorization');
            $response = new Response();
            
            if(!empty($header))
            {
                $token = trim(explode("Bearer", $header)[1]);
                
                $data = AuthenticadorJWT::ObtenerPayLoad($token);
                                
                if (isset($data) && isset($data->rol) && $data->rol == "Cervecero" || $data->rol == "Cervecera") 
                {
                    return $handler->handle($request);
                }
                else 
                {
                    $response->getBody()->write(json_encode(array("Error. Usuario no autorizado" => "Unicamente el tipo de usuario Cervecero/a tiene acceso")));
                    $response = $response->withStatus(401);
                }
            }
            else
            {
                $response->getBody()->write(json_encode(array("Error de admin. Usuario no autorizado" => "Necesitas un token de Cervecero/a")));
                $response = $response->withStatus(401);
            }
            return $response->withHeader('Content-Type', 'application/json');;
    }

    public function ValidarCliente($request, $handler)
    {
        try 
        {
            $header = $request->getHeaderLine('Authorization');
            if(!empty($header))
            {
                $token = trim(explode("Bearer", $header)[1]);
                $data = AutentificadorJWT::ObtenerData($token);
                
                if($data->tipo == 'cliente')
                {
                    return $handler->handle($request);
                }
                throw new Exception("Usuario no autorizado");
            }
            else
            {                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
                throw new Exception("Token vacío");
            }
        } 
        catch (\Throwable $th) 
        {
            $response = new Response();
            $payload = json_encode(array("mensaje" => "ERROR, ".$th->getMessage()));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');;
        }
    }




























    public function ValidarUsuario($request, $handler)
    {
        try 
        {
            $header = $request->getHeaderLine('Authorization');
            
            if(!empty($header))
            {
                $token = trim(explode("Bearer", $header)[1]);
                AutentificadorJWT::VerificarToken($token);
                return $handler->handle($request);
            }
            else
            {
                throw new Exception("Token vacío");
            }
        } 
        catch (\Throwable $th)
        {
            $response = new Response();
            $payload = json_encode(array("mensaje" => "ERROR, ".$th->getMessage()));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');;
        }
    }
}