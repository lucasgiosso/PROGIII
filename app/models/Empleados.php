<?php


class Empleados
{
    public $id;
    public $clave;
    public $nombre;
    public $rol;
    public $fechaBaja;
    public $fechaSuspension;
    public $tipo;

    public function crearEmpleado()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO empleados (clave, nombre, rol, fechaBaja, fechaSuspension, tipo) VALUES (:clave, :nombre, :rol, :fechaBaja, :fechaSuspension, :tipo)");
        
        //$claveHash = password_hash($this->clave, PASSWORD_DEFAULT);
        $consulta->bindValue(':clave', $this->clave);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':rol', $this->rol, PDO::PARAM_STR);
        $consulta->bindValue(':fechaBaja', $this->fechaBaja, PDO::PARAM_STR);
        $consulta->bindValue(':fechaSuspension', $this->fechaSuspension, PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);

        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function crearLog($id, $rol, $tipo)
    {

        $objAccesoDatos = AccesoDatos::obtenerInstancia();
    
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO logueos (empleado_id, rol, tipo, fechaIngreso) VALUES (:empleado_id, :rol, :tipo ,:fechaIngreso)");
        
        $consulta->bindValue(':empleado_id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':tipo', $tipo, PDO::PARAM_STR);
        $consulta->bindValue(':rol', $rol, PDO::PARAM_STR);
        $fecha = new DateTime(date("d-m-Y H:i:s"));
        $consulta->bindValue(':fechaIngreso', date_format($fecha, 'Y-m-d H:i:s'));
        
        $consulta->execute();
    
        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function validarEmpleado($tipo)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDatos->prepararConsulta("SELECT tipo FROM empleados WHERE tipo=:tipo");
        $consulta->bindValue(':tipo', $tipo);
        $consulta->execute();

        return $consulta->fetch(PDO::FETCH_ASSOC);

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

        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, clave, rol, nombre, tipo FROM empleados WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('Empleados');
    }

    public function modificarEmpleado()
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDato->prepararConsulta("UPDATE empleados SET clave = :clave, rol = :rol, nombre = :nombre, fechaBaja = :fechaBaja, fechaSuspension = :fechaSuspension  WHERE id = :id");
        
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':rol', $this->rol, PDO::PARAM_STR);
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

    public function obtenerPendientesCocinero() 
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        
        $consulta = $objAccesoDatos->prepararConsulta(" SELECT P.pedidoCliente_id, Pr.nombreProducto, P.cantidad, E.nombre, Es.descripcion, Pr.rol
                                                        FROM pedidos P 
                                                        INNER JOIN productos Pr ON P.productos_id = Pr.id
                                                        INNER JOIN estados Es ON P.estado_id = Es.id
                                                        INNER JOIN empleados E ON P.empleado_id = E.id
                                                        WHERE P.estado_id = 1 AND Pr.rol = 'Cocinero' ");
                                                           
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_OBJ);    
    }

    public function obtenerEnPreparacionCocinero() 
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        
        $consulta = $objAccesoDatos->prepararConsulta(" SELECT P.pedidoCliente_id, Pr.nombreProducto, P.cantidad, E.nombre, Es.descripcion, Pr.rol
                                                        FROM pedidos P 
                                                        INNER JOIN productos Pr ON P.productos_id = Pr.id
                                                        INNER JOIN estados Es ON P.estado_id = Es.id
                                                        INNER JOIN empleados E ON P.empleado_id = E.id
                                                        WHERE P.estado_id = 2 AND Pr.rol = 'Cocinero' ");
                                                           
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_OBJ);    
    }

    public function obtenerPendientesBartender() 
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        
        $consulta = $objAccesoDatos->prepararConsulta(" SELECT P.pedidoCliente_id, Pr.nombreProducto, P.cantidad, E.nombre, Es.descripcion, Pr.rol
                                                        FROM pedidos P 
                                                        INNER JOIN productos Pr ON P.productos_id = Pr.id
                                                        INNER JOIN estados Es ON P.estado_id = Es.id
                                                        INNER JOIN empleados E ON P.empleado_id = E.id
                                                        WHERE P.estado_id = 1 AND Pr.rol = 'Bartender' ");
                                                           
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_OBJ);    
    }

    public function obtenerEnPreparacionBartender() 
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        
        $consulta = $objAccesoDatos->prepararConsulta(" SELECT P.pedidoCliente_id, Pr.nombreProducto, P.cantidad, E.nombre, Es.descripcion, Pr.rol
                                                        FROM pedidos P 
                                                        INNER JOIN productos Pr ON P.productos_id = Pr.id
                                                        INNER JOIN estados Es ON P.estado_id = Es.id
                                                        INNER JOIN empleados E ON P.empleado_id = E.id
                                                        WHERE P.estado_id = 2 AND Pr.rol = 'Bartender' ");
                                                           
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_OBJ);    
    }

    public function obtenerPendientesCervecero() 
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        
        $consulta = $objAccesoDatos->prepararConsulta(" SELECT P.pedidoCliente_id , Pr.nombreProducto, P.cantidad, E.nombre, Es.descripcion, Pr.rol
                                                        FROM pedidos P 
                                                        INNER JOIN productos Pr ON P.productos_id = Pr.id
                                                        INNER JOIN estados Es ON P.estado_id = Es.id
                                                        INNER JOIN empleados E ON P.empleado_id = E.id
                                                        WHERE P.estado_id = 1 AND Pr.rol = 'Cervecero' ");
                                                           
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_OBJ);    
    }

    public function obtenerEnPreparacionCervecero() 
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        
        $consulta = $objAccesoDatos->prepararConsulta(" SELECT P.pedidoCliente_id, Pr.nombreProducto, P.cantidad, E.nombre, Es.descripcion, Pr.rol
                                                        FROM pedidos P 
                                                        INNER JOIN productos Pr ON P.productos_id = Pr.id
                                                        INNER JOIN estados Es ON P.estado_id = Es.id
                                                        INNER JOIN empleados E ON P.empleado_id = E.id
                                                        WHERE P.estado_id = 2 AND Pr.rol = 'Cervecero' ");
                                                           
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_OBJ);    
    }

    public function obtenerListosParaServirMozo() 
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        
        $consulta = $objAccesoDatos->prepararConsulta(" SELECT P.pedidoCliente_id, Pr.nombreProducto, P.cantidad, E.nombre, Es.descripcion, Pr.rol
                                                        FROM pedidos P 
                                                        INNER JOIN productos Pr ON P.productos_id = Pr.id
                                                        INNER JOIN estados Es ON P.estado_id = Es.id
                                                        INNER JOIN empleados E ON P.empleado_id = E.id
                                                        WHERE P.estado_id = 3 ");
                                                           
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_OBJ);    
    }

    public static function ImportarEmpleado($archivo)
    {
        $array = CSV::LeerCSV($archivo);
        
        for ($i=0; $i < sizeof($array); $i++) 
        { 
            $data = explode(',', $array[$i]);

            $empleados = new Empleados();

            $empleados->id = $data[0];
            $empleados->clave = $data[1];
            $empleados->nombre = $data[2];
            $empleados->rol = $data[3];
            $empleados->fechaBaja = $data[4];
            $empleados->fechaSuspension = $data[5];
            $empleados->tipo = $data[6];
            
            $empleados->crearEmpleado();
        }
    }

    public static function ExportarEmpleado($ruta)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM empleados");

        $consulta->execute();

        $listadoEmpleados = $consulta->fetchAll(PDO::FETCH_OBJ);

        foreach($listadoEmpleados as $item)
        {
            CSV::GuardarCSV($item,$ruta);
        }
    }
}

?>