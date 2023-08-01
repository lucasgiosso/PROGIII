<?php

use Illuminate\Support\Facades\Process;

class Productos
{
    public $id; //1 
    public $nombreProducto; // hamburg
    public $precio; // 1400
    public $rol;  // cocinero

    public function crearProducto()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO productos (nombreProducto, precio, rol) VALUES (:nombreProducto, :precio, :rol)");
        
        $consulta->bindValue(':nombreProducto', $this->nombreProducto, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindValue(':rol', $this->rol, PDO::PARAM_STR);

        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodosProductos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM productos");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Productos');
    }

    public static function obtenerProducto($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, nombreProducto, precio, rol FROM productos WHERE id = :id");
        
        $consulta->bindValue(':id', $id, PDO::PARAM_STR);

        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }

    public function modificarProducto()
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDato->prepararConsulta("UPDATE productos SET nombreProducto = :nombreProducto, precio = :precio WHERE id = :id");
        
        $consulta->bindValue(':nombreProducto', $this->nombreProducto, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);

        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);

        $consulta->execute();

    }

    public static function borrarProducto($id)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDato->prepararConsulta("UPDATE productos SET fechaBaja = :fechaBaja WHERE id = :id");

        $fecha = new DateTime(date("d-m-Y"));

        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':fechaBaja', date_format($fecha, 'Y-m-d H:i:s'));

        $consulta->execute();
    }

    public static function ImportarProducto($archivo)
    {
        $array = CSV::LeerCSV($archivo);
        
        for ($i=0; $i < sizeof($array); $i++) 
        { 
            $data = explode(',', $array[$i]);

            $productos = new Productos();

            $productos->id = $data[0];
            $productos->nombreProducto = $data[1];
            $productos->precio = $data[2];
            $productos->rol = $data[3];
            
            $productos->crearProducto();
        }
    }

    public static function ExportarProducto($ruta)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM productos");

        $consulta->execute();

        $listadoProductos = $consulta->fetchAll(PDO::FETCH_OBJ);

        foreach($listadoProductos as $item)
        {
            CSV::GuardarCSV($item,$ruta);
        }
    }

}
?>