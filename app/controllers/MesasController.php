<?php

require_once './models/Mesas.php';

class MesasController extends Mesas 
{

    public function CargarUna($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $estado_id = $parametros['estado_id'];

        $mesas = new Mesas();
        $mesas->estado_id = $estado_id;

        $mesas->crearMesa();

        $payload = json_encode(array("mensaje" => "Mesa creada"));

        $response->getBody()->write($payload);
        
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Mesas::obtenerTodasMesas();

        $payload = json_encode(array("listadoMesas" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        $id = $args['id'];
        
        $id = Mesas::obtenerMesa($id);
        $payload = json_encode($id);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $id = $parametros['id'];

        Mesas::modificarMesa($id);

        $payload = json_encode(array("mensaje" => "Mesa modificado"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $id = $parametros['id'];

        Mesas::borrarMesa($id);

        $payload = json_encode(array("mensaje" => "Mesa borrado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }



}