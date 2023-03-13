<?php


class Usuario {
    private $nombreUsuario;
    private $password;
    private $nombre;
    private $rol;
    static function buscaUsuario($nombreUsuario){
        if (self::$nombreUsuario != $nombreUsuario){
            return false;
        }else{
            return new static();
        }
    }
    public function compruebaPassword($password){
        $password = htmlspecialchars(trim(strip_tags($password)));
        $coincide = true;
        if ($this->password != $password){
            $coincide = false;
        }
        return $coincide;
    }

    public static function Login($nombreUsuario, $password){
        $usuario = self::buscaUsuario($nombreUsuario);
        if ($usuario && password_verify($password, $usuario->$password)){
            return $usuario;
        }
        return false;
        
    }

    public static function crea ($nombreUsuario, $nombre, $password, $rol){
        self::$password = password_hash($password, 2);
        self::$nombreUsuario = $nombreUsuario;
        self::$nombre = $nombre;
        self::$rol = $rol;
    }
}