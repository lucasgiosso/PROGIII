<?php

class Logger
{
    public static function LogOperacion($request, $response, $next)
    {
        $retorno = $next($request, $response);
        return $retorno;
    }

    public static function validarGP($request, $handler){
        
        $requestType = $request->getMethod();
        $response = $handler->handle($request);

        if($requestType == 'GET')
        {
            $response->getBody()->write('<h1>GET</h1>');
        }
        else if($requestType == 'POST')
        {
            $response->getBody()->write('<h1>POST</h1>');
            $data = $request->getParsedBody();
            $name = $data['name'];
            $type = $data['type'];

            if ($type == 'Admin') 
            {
                $response->getBody()->write('<h1> Bienvenido '.$name.'!</h1>');
            }
            else
            {
                $response->getBody()->write('<h1> No tiene acceso a esta pagina.</h1>');
            }
        }

        return $response;
    }
}