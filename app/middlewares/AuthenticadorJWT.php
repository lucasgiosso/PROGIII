<?php

require_once '../vendor/autoload.php';
use Firebase\JWT\JWT;


class AuthenticadorJWT
{
    private static $claveSecreta = '1234@';
    private static $tipoEncriptacion = ['HS256'];
    
    
    public static function CrearToken($id, $clave, $rol, $tipo)
    {
        $ahora = time();

        $payload = array(
        	'iat'=>$ahora,
            'exp' => $ahora + (60*60),
            'aud' => self::Aud(),
            'id' => $id,
            'clave' => $clave,
            'rol' => $rol,
            'tipo' => $tipo
        );
     
        return JWT::encode($payload, self::$claveSecreta);
    }
    
    public static function VerificarToken($token)
    {
        if(empty($token)|| $token== " ")
        {
            throw new Exception("El token esta vacio.");
        } 

        try 
        {
            $decodificado = JWT::decode(
            $token,
            self::$claveSecreta,
            self::$tipoEncriptacion
            );
        } catch (Exception $e) 
        {

           throw new Exception("Clave fuera de tiempo");
        }
        
        if($decodificado->aud !== self::Aud())
        {
            throw new Exception("No es el usuario valido");
        }
    }
    
   
    public static function ObtenerPayLoad($token)
    {
        return JWT::decode(
            $token,
            self::$claveSecreta,
            self::$tipoEncriptacion
        );
    }

    public static function ObtenerData($token)
    {
        $data = JWT::decode(
            $token,
            self::$claveSecreta,
            self::$tipoEncriptacion
        )->data;

        if (isset($data->rol)) 
        {
            return $data->rol;
        } 
        else 
        {
            return null;
        }
    }


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