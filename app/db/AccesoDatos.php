<?php

class AccesoDatos
{
    private static $objAccesoDatos;
    private $objetoPDO;

    private function __construct()
    {
        try {
            $this->objetoPDO = new PDO('mysql:host='.$_ENV['MYSQL_HOST'].';dbname='.$_ENV['MYSQL_DB'].';charset=utf8;port='.$_ENV['MYSQL_PORT'], $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASS'], array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            $this->objetoPDO->exec("SET CHARACTER SET utf8");
        } catch (PDOException $e) {
            print "Error: " . $e->getMessage();
            die();
        }
    }

    public static function obtenerInstancia()
    {
        if (!isset(self::$objAccesoDatos)) 
        {
            self::$objAccesoDatos = new AccesoDatos();
        }
        return self::$objAccesoDatos;
    }

    public function prepararConsulta($sql)
    {
        return $this->objetoPDO->prepare($sql);
    }

    public function obtenerUltimoId()
    {
        return $this->objetoPDO->lastInsertId();
    }

    public static function ObtenerConsulta($sql, $clase=null)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta($sql);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, $clase);
    }

    public static function retornarObjetoPorCampo($valor, $campo, $tabla, $clase)
    {
        $sql = "SELECT * FROM $tabla WHERE $tabla.$campo = '$valor'";

        return AccesoDatos::ObtenerConsulta($sql, $clase);
    }

    public static function retornarObjetoActivo($id, $tabla, $clase)
    {
        $sql = "SELECT * FROM $tabla WHERE $id = $tabla.id AND $tabla.activo = 1";
        
        return AccesoDatos::ObtenerConsulta($sql, $clase);
    }

    public static function retornarActivoObjetoPorCampo($valor, $campo, $tabla, $clase)
    {
        $sql = "SELECT * FROM $tabla WHERE $tabla.$campo = '$valor' AND $tabla.activo = 1";

        return AccesoDatos::ObtenerConsulta($sql, $clase);
    }

    public static function ObtenerPedidosXArea($area)
    {
        $sql = "SELECT p.id, pp.pedido_id, AS pedido, pr.nombre AS producto, pp.cantidad AS cantidad, 
                CASE
                WHEN pp.estado = 0 THEN 'Pendiente'
                WHEN pp.estado = 1 THEN 'En preparacion'
                WHEN pp.estado = 2 THEN 'Listo'
                ELSE 'Error' END AS Estado
                FROM comanda pp
                LEFT JOIN productos pr ON pp.producto_id = pr.id
                LEFT JOIN area a ON pr.area_id = a.id
                WHERE a.id = $area AND pp.estado < 2
                ORDER BY pp.pedido_id";

        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta($sql);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS);
    }

    public function __clone()
    {
        trigger_error('ERROR: La clonación de este objeto no está permitida', E_USER_ERROR);
    }
}
