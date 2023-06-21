<?php

class Pedidos
{
    public $id;
    public $codigoComanda;
    public $productos_id;
    public $empleado_id;
    public $precio;
    public $cantidad;
    public $tiempoEstimado;
    public $estado;
    public $fechaBaja;


    public function crearPedido()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO pedidos (productos_id, empleado_id, precio, cantidad, tiempoEstimado, estado) VALUES (:productos_id, :empleado_id, :precio, :cantidad, :tiempoEstimado, :estado)");
        
        $consulta->bindValue(':productos_id', $this->productos_id, PDO::PARAM_STR);
        $consulta->bindValue(':empleado_id', $this->empleado_id, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_STR);
        $consulta->bindValue(':tiempoEstimado', $this->tiempoEstimado, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodosPedidos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM pedidos");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedidos');
    }

    public static function obtenerPedido($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, codigoComanda, productos_id, empleado_id, precio, cantidad, tiempoEstimado, estado FROM pedidos WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_STR);
        $consulta->execute();

//         SELECT Ped.* from Comanda C InnerJoin Pedidos Ped on C.codigo = Ped.CodigoComanda
//                         InnerJoin Productos Prod on Prod.Id = Ped.IdProducto
//          WHERE C.Estado = "Pendiente" and Prod.Rol = "Cocinero"

        return $consulta->fetchObject('Pedidos');
    }

    public function modificarPedido()
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDato->prepararConsulta("UPDATE pedidos SET productos_id = :productos_id, cantidad = :cantidad, precio = :precio  WHERE id = :id");
        $consulta->bindValue(':productos_id', $this->productos_id, PDO::PARAM_STR);
        $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->execute();

    }

    public static function borrarPedido($id)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE pedidos SET fechaBaja = :fechaBaja WHERE id = :id");
        $fecha = new DateTime(date("d-m-Y"));
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':fechaBaja', date_format($fecha, 'Y-m-d H:i:s'));
        $consulta->execute();
    }

}





?>