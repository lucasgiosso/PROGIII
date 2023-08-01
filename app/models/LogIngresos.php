<?php

date_default_timezone_set('America/Buenos_Aires');

class LogIngresos 
{
    public $id;
    public $empleado_id;
    public $clave;
    public $tipo;
    public $rol;
    public $fechaIngreso;

    public static function Alta($log)
    {
        return $log->crearLog();
    }
    
    // public function crearLog()
    // {
    //     $objAccesoDatos = AccesoDatos::obtenerInstancia();
    
    //     $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO logueos (empleado_id, clave, rol, tipo, fechaIngreso) VALUES (:empleado_id, :clave, :rol, :tipo ,:fechaIngreso)");
        
    //     $consulta->bindValue(':empleado_id', $this->empleado_id, PDO::PARAM_STR);
    //     $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
    //     $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
    //     $consulta->bindValue(':rol', $this->rol, PDO::PARAM_STR);
    //     $fecha = new DateTime(date("d-m-Y H:i:s"));
    //     $consulta->bindValue(':fechaIngreso', date_format($fecha, 'Y-m-d H:i:s'));
        
    //     $consulta->execute();
    
    //     return $objAccesoDatos->obtenerUltimoId();
    // }

    public function modificarLog()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDatos->prepararConsulta("UPDATE logueos SET empleado_id, tipo, rol, fechaIngreso WHERE :empleado_id = :empleado_id");
        
        $consulta->bindValue(':empleado_id', $this->empleado_id, PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
        $consulta->bindValue(':rol', $this->rol, PDO::PARAM_STR);
        $fecha = new DateTime(date("d-m-Y H:i:s"));
        $consulta->bindValue(':fechaIngreso', date_format($fecha, 'Y-m-d H:i:s'));
        
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }
}

?>