<?php

class Encuesta
{
    public $id;
<<<<<<< HEAD
    public $mesa_id;
    public $cliente;
    public $pedido_id;
=======
>>>>>>> a93f3d725bf13fb8677d4c7db0c5a4b59d8b5ed8
    public $mesaPuntuacion;
    public $restaurantePuntuacion;
    public $mozoPuntuacion;
    public $cocineroPuntuacion;
    public $promedioPuntuacion;
    public $comentario;

<<<<<<< HEAD
    public function crearEncuesta()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $promedio = ($this->mesaPuntuacion + $this->restaurantePuntuacion + $this->mozoPuntuacion + $this->cocineroPuntuacion) / 4;

        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO encuestas (mesa_id, cliente, pedido_id, mesaPuntuacion, restaurantePuntuacion, mozoPuntuacion, cocineroPuntuacion, promedioPuntuacion, comentario)
                                                        VALUES (:mesa_id, :cliente, :pedido_id, :mesaPuntuacion, :restaurantePuntuacion, :mozoPuntuacion, :cocineroPuntuacion, :promedioPuntuacion, :comentario)");

        $consulta->bindValue(':mesa_id', $this->mesa_id, PDO::PARAM_INT);
        $consulta->bindValue(':cliente', $this->cliente, PDO::PARAM_STR);
        $consulta->bindValue(':pedido_id', $this->pedido_id, PDO::PARAM_STR);
        $consulta->bindValue(':mesaPuntuacion', $this->mesaPuntuacion, PDO::PARAM_INT);
        $consulta->bindValue(':restaurantePuntuacion', $this->restaurantePuntuacion, PDO::PARAM_INT);
        $consulta->bindValue(':mozoPuntuacion', $this->mozoPuntuacion, PDO::PARAM_INT);
        $consulta->bindValue(':cocineroPuntuacion', $this->cocineroPuntuacion, PDO::PARAM_INT);
        $consulta->bindValue(':promedioPuntuacion', $promedio, PDO::PARAM_STR);
        $consulta->bindValue(':comentario', $this->comentario, PDO::PARAM_STR);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodasEncuestasMejoresComentarios()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
    
        $consulta = $objAccesoDatos->prepararConsulta(" SELECT comentario
                                                        FROM encuestas
                                                        WHERE comentario LIKE '%excelente%'
                                                        OR comentario LIKE '%magnífico%'
                                                        OR comentario LIKE '%fantástico%'
                                                        OR comentario LIKE '%bueno todo%'");
                                                           
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_OBJ);

    }


    public function modificarEncuesta()
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDato->prepararConsulta("  UPDATE encuestas 
                                                        SET cliente = :cliente, pedido_id = :pedido_id, mesaPuntuacion = :mesaPuntuacion, restaurantePuntuacion = :restaurantePuntuacion, mozoPuntuacion = :mozoPuntuacion, cocineroPuntuacion = :cocineroPuntuacion, comentario = :comentario  
                                                        WHERE id = :id");
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':cliente', $this->cliente, PDO::PARAM_STR);
        $consulta->bindValue(':pedido_id', $this->pedido_id, PDO::PARAM_STR);
        $consulta->bindValue(':mesaPuntuacion', $this->mesaPuntuacion, PDO::PARAM_STR);
        $consulta->bindValue(':restaurantePuntuacion', $this->restaurantePuntuacion, PDO::PARAM_STR);
        $consulta->bindValue(':mozoPuntuacion', $this->mozoPuntuacion, PDO::PARAM_STR);
        $consulta->bindValue(':cocineroPuntuacion', $this->cocineroPuntuacion, PDO::PARAM_STR);
        $consulta->execute();

    }

    public static function CalcularPromedio($mesaPuntuacion,$restaurantePuntuacion,$mozoPuntuacion,$cocineroPuntuacion)
    {
        $promedioPuntuacion = 0;
    
        $objAccesoDato = AccesoDatos::obtenerInstancia();
    
        $consulta = $objAccesoDato->prepararConsulta("SELECT (:mesaPuntuacion + :restaurantePuntuacion + :mozoPuntuacion + :cocineroPuntuacion) / 4 AS promedio");
    
        $consulta->bindValue(':mesaPuntuacion', $mesaPuntuacion, PDO::PARAM_INT);
        $consulta->bindValue(':restaurantePuntuacion', $restaurantePuntuacion, PDO::PARAM_INT);
        $consulta->bindValue(':mozoPuntuacion', $mozoPuntuacion, PDO::PARAM_INT);
        $consulta->bindValue(':cocineroPuntuacion', $cocineroPuntuacion, PDO::PARAM_INT);
    
        $consulta->execute();
    
        $resultado = $consulta->fetch();
        $promedioPuntuacion = $resultado['promedio'];
    
        return $promedioPuntuacion;
    }




=======
>>>>>>> a93f3d725bf13fb8677d4c7db0c5a4b59d8b5ed8
}



?>