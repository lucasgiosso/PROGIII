<?php

require_once '../vendor/autoload.php';
use Firebase\JWT\JWT;

<<<<<<< HEAD

class AuthenticadorJWT
=======
class AutentificadorJWT
>>>>>>> a93f3d725bf13fb8677d4c7db0c5a4b59d8b5ed8
{
    private static $claveSecreta = '1234@';
    private static $tipoEncriptacion = ['HS256'];
    
    
<<<<<<< HEAD
    public static function CrearToken($id, $clave, $rol, $tipo)
    {
        $ahora = time();

=======
    public static function CrearToken($datos)
    {
        $ahora = time();
        /*
         parametros del payload
         https://tools.ietf.org/html/rfc7519#section-4.1
         + los que quieras ej="'app'=> "API REST CD 2017" 
        */
>>>>>>> a93f3d725bf13fb8677d4c7db0c5a4b59d8b5ed8
        $payload = array(
        	'iat'=>$ahora,
            'exp' => $ahora + (60*60),
            'aud' => self::Aud(),
<<<<<<< HEAD
            'id' => $id,
            'clave' => $clave,
            'rol' => $rol,
            'tipo' => $tipo
=======
            'data' => $datos,
            'app'=> "API REST CD 2017"
>>>>>>> a93f3d725bf13fb8677d4c7db0c5a4b59d8b5ed8
        );
     
        return JWT::encode($payload, self::$claveSecreta);
    }
    
    public static function VerificarToken($token)
    {
<<<<<<< HEAD
=======
       
>>>>>>> a93f3d725bf13fb8677d4c7db0c5a4b59d8b5ed8
        if(empty($token)|| $token== " ")
        {
            throw new Exception("El token esta vacio.");
        } 
<<<<<<< HEAD

        try 
        {
=======
        // las siguientes lineas lanzan una excepcion, de no ser correcto o de haberse terminado el tiempo       
        try {
>>>>>>> a93f3d725bf13fb8677d4c7db0c5a4b59d8b5ed8
            $decodificado = JWT::decode(
            $token,
            self::$claveSecreta,
            self::$tipoEncriptacion
            );
<<<<<<< HEAD
        } catch (Exception $e) 
        {

           throw new Exception("Clave fuera de tiempo");
        }
        
=======
        } catch (Exception $e) {
            //var_dump($e);
           throw new Exception("Clave fuera de tiempo");
        }
        
        // si no da error,  verifico los datos de AUD que uso para saber de que lugar viene  
>>>>>>> a93f3d725bf13fb8677d4c7db0c5a4b59d8b5ed8
        if($decodificado->aud !== self::Aud())
        {
            throw new Exception("No es el usuario valido");
        }
    }
    
   
<<<<<<< HEAD
    public static function ObtenerPayLoad($token)
=======
     public static function ObtenerPayLoad($token)
>>>>>>> a93f3d725bf13fb8677d4c7db0c5a4b59d8b5ed8
    {
        return JWT::decode(
            $token,
            self::$claveSecreta,
            self::$tipoEncriptacion
        );
    }
<<<<<<< HEAD

    public static function ObtenerData($token)
    {
        $data = JWT::decode(
=======
     public static function ObtenerData($token)
    {
        return JWT::decode(
>>>>>>> a93f3d725bf13fb8677d4c7db0c5a4b59d8b5ed8
            $token,
            self::$claveSecreta,
            self::$tipoEncriptacion
        )->data;
<<<<<<< HEAD

        if (isset($data->rol)) 
        {
            return $data->rol;
        } 
        else 
        {
            return null;
        }
    }


=======
    }
>>>>>>> a93f3d725bf13fb8677d4c7db0c5a4b59d8b5ed8
    private static function Aud()
    {
        $aud = '';
        
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $aud = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $aud = $_SERVER['REMOTE_ADDR'];
        }
        
        $aud .= @$_SERVER['HTTP_USER_AGENT'];
        $aud .= gethostname();
        
        return sha1($aud);
    }
}