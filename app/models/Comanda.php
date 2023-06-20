<?php

class Comanda
{
    public $id;
    public $codigo;
    public $cliente;
    public $mesa_id;
    public $empleado_id;
    public $foto;
    public $tiempoInicio;   
    public $tiempoFin;      
    public $tiempoEstimado;
    public $encuesta_id;    
    
}

/*

    codigo: 11111
    estado: Pendiente

 hambur     1       Cocinero
 empana     1       Cocinero
 cerveza    1       Cervecero


SELECT Ped.* from Comanda C InnerJoin Pedidos Ped on C.codigo = Ped.CodigoComanda
                        InnerJoin Productos Prod on Prod.Id = Ped.IdProducto
WHERE C.Estado = "Pendiente" and Prod.Rol = "Cocinero"


*/

?>

