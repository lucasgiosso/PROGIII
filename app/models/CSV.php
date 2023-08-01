<?php

class CSV
{
    public static function LeerCSV($archivo)
    {
        $aux = fopen($archivo, 'r');
        $array = [];
        if (isset($aux)) 
        {
            while (!feof($aux))
            {
                $leer = fgets($aux);
                
                if (!empty($leer)) 
                {
                    array_push($array, $leer);
                }
            }           
        }
        fclose($aux);

        return $array;
    }

    public static function GuardarCSV($item, $ruta)
    {
        $retorno = false;

        if ($item) 
        {
            $separador = implode(',', (array)$item);
            
            $archivo = fopen($ruta, 'a+');
            
            if ($archivo) 
            {
                fwrite($archivo, $separador.PHP_EOL);
            }
            fclose($archivo);
            $retorno = true;
        }

        return $retorno;
    }

}





?>