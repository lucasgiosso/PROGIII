<?php

class Empleados
{
    public $id;
    public $rol;
    public $nombre;
    public $fechaBaja;
    public $fechaSuspension;


    public function crearEmpleado()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO empleados (rol, nombre, fechaBaja, fechaSuspension) VALUES (:rol, :nombre, :precio, :fechaBaja, :fechaSuspension)");
        
        $consulta->bindValue(':rol', $this->rol, PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':fechaBaja', $this->fechaBaja, PDO::PARAM_STR);
        $consulta->bindValue(':fechaSuspension', $this->fechaSuspension, PDO::PARAM_STR);

        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodosEmpleados()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM empleados");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Empleados');
    }

    public static function obtenerEmpleado($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDatos->prepararConsulta("SELECT id FROM empleados WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Empleados');
    }

    public function modificarEmpleado()
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDato->prepararConsulta("UPDATE empleados SET rol = :rol, nombre = :nombre, fechaBaja = :fechaBaja, fechaSuspension = :fechaSuspension  WHERE id = :id");
        $consulta->bindValue(':rol', $this->rol, PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':fechaBaja', $this->fechaBaja, PDO::PARAM_STR);
        $consulta->bindValue(':fechaSuspension', $this->fechaSuspension, PDO::PARAM_STR);
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->execute();

    }

    public static function borrarEmpleado($id)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDato->prepararConsulta("UPDATE empleados SET fechaBaja = :fechaBaja WHERE id = :id");
        $fecha = new DateTime(date("d-m-Y"));
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':fechaBaja', date_format($fecha, 'Y-m-d H:i:s'));
        $consulta->execute();
    }












    public function obtenerDiasHorariosEmpleados($request, $response, $args) 
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $query = "SELECT id_empleado, fecha, hora FROM ingresos_empleados";
        
        $resultado = $objAccesoDatos->query($query);
      
        $ingresos = array();

        while ($fila = $resultado->fetch_assoc()) {
                                                    $idEmpleado = $fila["id_empleado"];
                                                    $fecha = $fila["fecha"];
                                                    $hora = $fila["hora"];
      
          $ingresos[$idEmpleado][] = array("fecha" => $fecha, "hora" => $hora);
        }
      
        $objAccesoDatos->close();
      
        return $ingresos;
      }
    
}




?>