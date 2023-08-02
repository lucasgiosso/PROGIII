<?php

<<<<<<< HEAD
use Illuminate\Support\Facades\Process;

class Productos
{
    public $id; //1 
    public $nombreProducto; // hamburg
=======
class Productos
{
    public $id; //1 
    public $nombre; // hamburg
>>>>>>> a93f3d725bf13fb8677d4c7db0c5a4b59d8b5ed8
    public $precio; // 1400
    public $rol;  // cocinero

    public function crearProducto()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

<<<<<<< HEAD
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO productos (nombreProducto, precio, rol) VALUES (:nombreProducto, :precio, :rol)");
        
        $consulta->bindValue(':nombreProducto', $this->nombreProducto, PDO::PARAM_STR);
=======
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO productos (nombre, precio, rol) VALUES (:nombre, :precio, :rol)");
        
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
>>>>>>> a93f3d725bf13fb8677d4c7db0c5a4b59d8b5ed8
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

<<<<<<< HEAD
<<<<<<< HEAD
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, nombreProducto, precio, rol FROM productos WHERE id = :id");
        
=======
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id FROM productos WHERE id = :id");
>>>>>>> a93f3d725bf13fb8677d4c7db0c5a4b59d8b5ed8
=======
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, nombre, precio, rol FROM productos WHERE id = :id");
>>>>>>> 561cd04d31978d7eb71751c2b67fc5f7eb3abf09
        $consulta->bindValue(':id', $id, PDO::PARAM_STR);

        $consulta->execute();

<<<<<<< HEAD
        return $consulta->fetchAll(PDO::FETCH_OBJ);
=======
        return $consulta->fetchObject('Productos');
>>>>>>> a93f3d725bf13fb8677d4c7db0c5a4b59d8b5ed8
    }

    public function modificarProducto()
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();

<<<<<<< HEAD
        $consulta = $objAccesoDato->prepararConsulta("UPDATE productos SET nombreProducto = :nombreProducto, precio = :precio WHERE id = :id");
        
        $consulta->bindValue(':nombreProducto', $this->nombreProducto, PDO::PARAM_STR);
=======
        $consulta = $objAccesoDato->prepararConsulta("UPDATE productos SET nombre = :nombre, precio = :precio WHERE id = :id");
        
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
>>>>>>> a93f3d725bf13fb8677d4c7db0c5a4b59d8b5ed8
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

<<<<<<< HEAD
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

=======
>>>>>>> a93f3d725bf13fb8677d4c7db0c5a4b59d8b5ed8
}
?>