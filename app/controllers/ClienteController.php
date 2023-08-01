<?php
require_once './models/Cliente.php'; 
//srequire_once './interfaces/IApiUsable.php';


class ClienteController extends Cliente 
{

    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $id = $parametros['id'];
        $nombre = $parametros['nombre'];

        $cliente = new Cliente();
        $cliente->id = $id;
        $cliente->nombre = $nombre;
        
        $cliente->crearCliente();

        $payload = json_encode(array("mensaje" => "Cliente dado de alta"));

        $response->getBody()->write($payload);
        
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Cliente::obtenerTodosClientes();

        $payload = json_encode(array("listadoCliente/s" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $id = $parametros['id'];

        Cliente::modificarCliente($id);

        $payload = json_encode(array("mensaje" => "Cliente modificado"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

}