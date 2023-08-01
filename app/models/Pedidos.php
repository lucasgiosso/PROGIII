<?php

class Pedidos
{
    public $id;
    public $pedidoCliente_id;
    public $mesa_id;
    public $cliente;
    public $foto;
    public $productos_id;
    public $empleado_id;
    public $precio;
    public $cantidad;
    public $tiempoEstimado;
    public $estado_id;
    public $fechaBaja;
    public $fechaPedido;

    public function crearPedido()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $precio_ = 0;
        
        $precioProducto = Productos::obtenerProducto($this->productos_id);

        foreach($precioProducto as $producto)
        {
          $precio_ = $producto->precio;
          
        } 

        $consulta = $objAccesoDatos->prepararConsulta(" INSERT INTO pedidos (mesa_id, pedidoCliente_id, cliente, productos_id, empleado_id, precio,cantidad, estado_id, fechaPedido) 
                                                        VALUES (:mesa_id, :pedidoCliente_id, :cliente, :productos_id, :empleado_id, :precio,:cantidad, :estado_id, :fechaPedido)");
        
        $consulta->bindValue(':mesa_id', $this->mesa_id, PDO::PARAM_INT);
        $consulta->bindValue(':pedidoCliente_id', $this->pedidoCliente_id, PDO::PARAM_STR);
        $consulta->bindValue(':cliente', $this->cliente, PDO::PARAM_STR);
        $consulta->bindValue(':productos_id', $this->productos_id, PDO::PARAM_INT);
        $consulta->bindValue(':precio', $precio_, PDO::PARAM_INT);
        $consulta->bindValue(':empleado_id', $this->empleado_id, PDO::PARAM_INT);
        $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_STR);
        $consulta->bindValue(':fechaPedido', $this->fechaPedido, PDO::PARAM_STR);
        $consulta->bindValue(':estado_id', $this->estado_id, PDO::PARAM_INT);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodosPedidos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
    
        $consulta = $objAccesoDatos->prepararConsulta(" SELECT P.pedidoCliente_id, P.mesa_id, P.cliente, P.tiempoEstimado, Pr.nombreProducto, Pr.precio, P.cantidad, E.nombre, Es.descripcion
                                                        FROM pedidos P 
                                                        INNER JOIN productos Pr ON P.productos_id = Pr.id
                                                        INNER JOIN estados Es ON P.estado_id = Es.id
                                                        INNER JOIN empleados E ON P.empleado_id = E.id");
                                                           
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_OBJ);

    }

    public static function obtenerPedido($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDatos->prepararConsulta(" SELECT P.pedidoCliente_id, P.mesa_id, P.cliente, P.tiempoEstimado,Pr.nombreProducto, Pr.precio, P.cantidad, E.nombre, Es.descripcion
                                                        FROM pedidos P 
                                                        INNER JOIN productos Pr ON P.productos_id = Pr.id
                                                        INNER JOIN estados Es ON P.estado_id = Es.id
                                                        INNER JOIN empleados E ON P.empleado_id = E.id
                                                        WHERE P.pedidoCliente_id = :pedidoCliente_id");

        $consulta->bindValue(':pedidoCliente_id', $id, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }

    public static function modificarPedido($pedidos)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDato->prepararConsulta("  UPDATE pedidos 
                                                        SET mesa_id = :mesa_id, cliente = :cliente, productos_id = :productos_id, empleado_id = :empleado_id, cantidad = :cantidad, precioFinal = :precioFinal 
                                                        WHERE id = :id");
        
        $consulta->bindValue(':mesa_id', $pedidos->mesa_id, PDO::PARAM_INT);
        $consulta->bindValue(':cliente', $pedidos->cliente, PDO::PARAM_STR);
        $consulta->bindValue(':productos_id', $pedidos->productos_id, PDO::PARAM_INT);
        $consulta->bindValue(':empleado_id', $pedidos->empleado_id, PDO::PARAM_INT);
        $consulta->bindValue(':cantidad', $pedidos->cantidad, PDO::PARAM_STR);
        $consulta->bindValue(':precioFinal', $pedidos->precioFinal, PDO::PARAM_STR);
        $consulta->bindValue(':id', $pedidos->id, PDO::PARAM_INT);
        
        $consulta->execute();

    }

    public static function borrarPedido($id)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDato->prepararConsulta("DELETE FROM pedidos WHERE id = :id");
        $fecha = new DateTime(date("d-m-Y"));
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        //$consulta->bindValue(':fechaBaja', date_format($fecha, 'Y-m-d H:i:s'));

        $consulta->execute();
    }

    public static function CalcularPrecio($pedidoCliente_id)
    {
        $precio = 0;
    
        $objAccesoDato = AccesoDatos::obtenerInstancia();
    
        $consulta = $objAccesoDato->prepararConsulta("SELECT SUM(precio * cantidad) AS precioFinal FROM pedidos WHERE pedidoCliente_id = :pedidoCliente_id");
    
        $consulta->bindValue(':pedidoCliente_id', $pedidoCliente_id, PDO::PARAM_INT);
    
        $consulta->execute();
    
        $precio = $consulta->fetch();
    
        return $precio['precioFinal'];
    }

    public function GuardarImagen()
    {
        $nombreFoto = "foto_asociada". $this->id . ".jpg";
        $destino = "." . DIRECTORY_SEPARATOR . "fotos" . DIRECTORY_SEPARATOR;

        if (!file_exists($destino))
        {
            mkdir($destino, 0777, true);
        }

        $directorio = $destino.$nombreFoto;
        move_uploaded_file($this->foto, $directorio);
        $this->foto = $directorio;
        Pedidos::InsertarFoto($this);

        return $directorio;
    }

    public static function InsertarFoto($pedidos)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE pedidos SET foto = :foto WHERE pedidoCliente_id = :pedidoCliente_id");

        $consulta->bindValue(':pedidoCliente_id', $pedidos->id, PDO::PARAM_INT);
        $consulta->bindValue(':foto', $pedidos->foto, PDO::PARAM_STR);

        $consulta->execute();
    }

    public static function CambiarEstadoEnPreparacion($empleado_id, $pedidoCliente_id, $estado_id, $tiempoEstimado)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE pedidos SET empleado_id = :empleado_id,
                                                                         estado_id = :estado_id, 
                                                                         tiempoEstimado = :tiempoEstimado 
                                                                         WHERE pedidoCliente_id = :pedidoCliente_id");

        $consulta->bindValue(':empleado_id', $empleado_id, PDO::PARAM_INT);
        $consulta->bindValue(':estado_id', $estado_id, PDO::PARAM_INT);
        $consulta->bindValue(':tiempoEstimado', $tiempoEstimado, PDO::PARAM_INT);
        $consulta->bindValue(':pedidoCliente_id', $pedidoCliente_id, PDO::PARAM_INT);

        $consulta->execute();
        
    }

    public static function CambiarEstadoListoParaServir($empleado_id, $pedidoCliente_id, $estado_id)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDato->prepararConsulta("UPDATE pedidos SET empleado_id = :empleado_id,
                                                                         estado_id = :estado_id
                                                                         WHERE pedidoCliente_id = :pedidoCliente_id");

        $consulta->bindValue(':empleado_id', $empleado_id, PDO::PARAM_INT);
        $consulta->bindValue(':estado_id', $estado_id, PDO::PARAM_INT);
        $consulta->bindValue(':pedidoCliente_id', $pedidoCliente_id, PDO::PARAM_INT);

        $consulta->execute();
        
    }

    public static function DemoraPedido($mesa_id, $pedidoCliente_id)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDato->prepararConsulta("  SELECT P.tiempoEstimado
                                                        FROM pedidos P 
                                                        INNER JOIN productos Pr ON P.productos_id = Pr.id
                                                        INNER JOIN estados Es ON P.estado_id = Es.id
                                                        INNER JOIN empleados E ON P.empleado_id = E.id
                                                        WHERE P.pedidoCliente_id = :pedidoCliente_id");

        
        $consulta->bindValue(':pedidoCliente_id', $pedidoCliente_id, PDO::PARAM_INT);

        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }

    public static function DemoraPedidoSocio($pedidoCliente_id)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDato->prepararConsulta("  SELECT P.tiempoEstimado
                                                        FROM pedidos P 
                                                        INNER JOIN productos Pr ON P.productos_id = Pr.id
                                                        INNER JOIN estados Es ON P.estado_id = Es.id
                                                        INNER JOIN empleados E ON P.empleado_id = E.id
                                                        WHERE P.pedidoCliente_id = :pedidoCliente_id");

        
        $consulta->bindValue(':pedidoCliente_id', $pedidoCliente_id, PDO::PARAM_INT);

        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }

    public function TraerDemoras($request, $response, $args)
  {
    $objAccesoDatos = AccesoDatos::obtenerInstancia();
    
    $consulta = $objAccesoDatos->prepararConsulta(" SELECT DISTINCT P.pedidoCliente_id
                                                    FROM pedidos P
                                                    JOIN (
                                                        SELECT 
                                                            Guid,
                                                            TIMESTAMPDIFF(
                                                                MINUTE,
                                                                DATE_ADD(Fecha, INTERVAL TiempoEstimado MINUTE),
                                                                (SELECT Fecha FROM pedidos WHERE Guid = P.pedidoCliente_id AND IdEstado = 3)
                                                            ) AS Diferencia
                                                        FROM pedidos
                                                        WHERE IdEstado = 2
                                                    ) AS subconsulta ON P.pedidoCliente_id = subconsulta.Guid
                                                    WHERE subconsulta.Diferencia > 2;");
    $consulta->execute();
    $payload = json_encode(array("mensaje" => $consulta->fetchAll(PDO::FETCH_OBJ)));
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
  }

    
}





?>