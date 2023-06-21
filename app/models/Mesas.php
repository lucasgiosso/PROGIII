<?php

class Mesas
{
    public $id;
    public $estado_id;
    public $fechaBaja;

    public function crearMesa()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO mesas (estado_id) VALUES (:estado_id)");
        
        $consulta->bindValue(':estado_id', $this->estado, PDO::PARAM_STR);

        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodasMesas()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM mesas");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Mesas');
    }

    public static function obtenerMesa($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, estado_id FROM mesas WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_STR);

        $consulta->execute();

        return $consulta->fetchObject('Mesas');
    }

    public function modificarMesa()
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDato->prepararConsulta("UPDATE mesas SET estado_id = :estado_id WHERE id = :id");
        
        $consulta->bindValue(':estado_id', $this->estado, PDO::PARAM_STR);

        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);

        $consulta->execute();

    }

    public static function borrarMesa($id)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDato->prepararConsulta("UPDATE mesas SET fechaBaja = :fechaBaja WHERE id = :id");

        $fecha = new DateTime(date("d-m-Y"));

        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':fechaBaja', date_format($fecha, 'Y-m-d H:i:s'));

        $consulta->execute();
    }

}



?>