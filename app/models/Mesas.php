<?php

class Mesas
{
<<<<<<< HEAD
    public $mesa_id;
    public $estado_id;
    public $fechaBaja;

    public function crearMesa()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO mesas (estado_id) VALUES (:estado_id)");
        
        $consulta->bindValue(':estado_id', $this->estado_id, PDO::PARAM_STR);

        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodasMesas()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDatos->prepararConsulta(" SELECT M.mesa_id, Es.descripcion 
                                                        FROM mesas M
                                                        INNER JOIN estados Es ON M.estado_id = Es.id"); 
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }

    public static function obtenerMesa($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDatos->prepararConsulta(" SELECT M.mesa_id, Es.descripcion 
                                                        FROM mesas M
                                                        INNER JOIN estados Es ON M.estado_id = Es.id
                                                        WHERE M.mesa_id = :mesa_id");
        $consulta->bindValue(':mesa_id', $id, PDO::PARAM_STR);

        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }

    public function modificarMesa()
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDato->prepararConsulta("UPDATE mesas SET estado_id = :estado_id WHERE mesa_id = :mesa_id");
        
        $consulta->bindValue(':estado_id', $this->estado, PDO::PARAM_STR);

        $consulta->bindValue(':mesa_id', $this->id, PDO::PARAM_INT);

        $consulta->execute();

    }

    public function ConsultarTiempoRestante()
    {   
        $objAccesoDato = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDato->prepararConsulta("SELECT mesa_id, pedido_id FROM pedidos WHERE mesa_id = :mesa_id");

    }

    public function RealizarEncuesta()
    {   
        
    }


    public static function borrarMesa($id)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDato->prepararConsulta("UPDATE mesas SET fechaBaja = :fechaBaja WHERE mesa_id = :mesa_id");

        $fecha = new DateTime(date("d-m-Y"));

        $consulta->bindValue(':mesa_id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':fechaBaja', date_format($fecha, 'Y-m-d H:i:s'));

        $consulta->execute();
    }

    public static function CambiarEstadoMesa($mesa_id, $estado_id)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDato->prepararConsulta("UPDATE mesas SET  estado_id = :estado_id
                                                                        WHERE mesa_id = :mesa_id");

        $consulta->bindValue(':mesa_id', $mesa_id, PDO::PARAM_INT);
        $consulta->bindValue(':estado_id', $estado_id, PDO::PARAM_INT);

        $consulta->execute();
        
    }

    // public static function MesaMasUsada()
    // {
    //     $objAccesoDato = AccesoDatos::obtenerInstancia();

    //     $consulta = $objAccesoDato->prepararConsulta("  SELECT mesa_id, COUNT(*) AS veces_usada
    //                                                     FROM pedidos
    //                                                     GROUP BY mesa_id
    //                                                     ORDER BY veces_usada DESC
    //                                                     LIMIT 1");

    //     $consulta->execute();

    // }

    public static function MesaMasUsada()
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
    
        $consulta = $objAccesoDato->prepararConsulta("SELECT mesa_id, COUNT(*) AS veces_usada
                                                    FROM pedidos
                                                    GROUP BY mesa_id
                                                    ORDER BY veces_usada DESC
                                                    LIMIT 1");
    
        $consulta->execute();
    
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC); 
    
        if ($resultado && isset($resultado['mesa_id'])) 
        {
            $mesaMasUsada = $resultado['mesa_id'];
            $cantidadVecesUsada = $resultado['veces_usada'];
    
            return $mesaMasUsada . ' (Cantidad de veces usada: ' . $cantidadVecesUsada . ')';
        } 
        else 
        {
            
            return null;
        }
    }
    


    public static function CambiarEstado($pedido_id, $estado_idAux)
    {
        $pedido = AccesoDatos::retornarObjetoActivo($pedido_id, 'pedido', 'Pedido');
        $pedido[0]->estado_id = $estado_idAux; //comiendo
        $retorno = 'Mesa pasada a comiendo.';
        switch($estado_idAux)
        {
            case 3: 
                $pedido[0]->precio_final = Pedidos::CalcularPrecio($pedido_id);//calcular precio           
                $retorno = $pedido[0]->precio_final;
                break;
            case 4: 
                $fecha = new DateTime(date("d-m-Y H:i:s"));
                $pedido[0]->fecha_fin = $fecha->format("Y-m-d H:i:s");
                $retorno = 'Mesa cerrada';
                break;
        }
        Pedidos::modificarPedido($pedido[0]);
        return $retorno;

    }





    public static function CargarCsv($archivo)
    {
        $array = CSV::LeerCSV($archivo);

        for ($i=0;$i < sizeof($array); $i++)
        { 
            $mesa = new Mesas();
            $mesa->estado_id = $array[$i];
            $mesa->crearMesa();    
        }
    }

=======
    public $id;
<<<<<<< HEAD
    public $estado;
>>>>>>> a93f3d725bf13fb8677d4c7db0c5a4b59d8b5ed8
=======
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
>>>>>>> 561cd04d31978d7eb71751c2b67fc5f7eb3abf09

}



?>