<?php

require_once './models/Encuesta.php';

class EncuestasController 
{

    public function CargarUna($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        
        $mesa_id = $parametros['mesa_id'];
        $cliente = $parametros['cliente'];
        $pedido_id = $parametros['pedido_id'];
        $mesaPuntuacion = $parametros['mesaPuntuacion'];
        $restaurantePuntuacion = $parametros['restaurantePuntuacion'];
        $mozoPuntuacion = $parametros['mozoPuntuacion'];
        $cocineroPuntuacion = $parametros['cocineroPuntuacion'];
        $comentario = $parametros['comentario'];

        $promedioEncuesta = Encuesta::CalcularPromedio($mesaPuntuacion,$restaurantePuntuacion,$mozoPuntuacion,$cocineroPuntuacion);
        

        $encuestas = new Encuesta();
        
        $encuestas->mesa_id = $mesa_id;
        $encuestas->pedido_id = $pedido_id;
        $encuestas->cliente = $cliente;
        $encuestas->mesaPuntuacion = $mesaPuntuacion;
        $encuestas->restaurantePuntuacion = $restaurantePuntuacion;
        $encuestas->mozoPuntuacion = $mozoPuntuacion;
        $encuestas->cocineroPuntuacion = $cocineroPuntuacion;
        $encuestas->promedioPuntuacion = $promedioEncuesta;
        $encuestas->comentario = $comentario;

        $encuestas->crearEncuesta();

        $payload = json_encode(array("mensaje" => "Encuesta creada"));

        $response->getBody()->write($payload);
        
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerBuenosComentarios($request, $response, $args)
    {
        $lista = Encuesta::obtenerTodasEncuestasMejoresComentarios();

        $payload = json_encode(array("Los Mejores comentarios son: " => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
}