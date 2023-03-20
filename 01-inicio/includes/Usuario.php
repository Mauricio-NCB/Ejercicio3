<?php

require_once 'Aplicacion.php';

class Usuario {

    private $id;
    private $nombreUsuario;
    private $nombre;
    private $password;
    private $roles;

    private function __construct($id, $nombreUsuario, $nombre, $password, $roles) {
        $this->id = $id;
        $this->nombreUsuario = $nombreUsuario;
        $this->nombre = $nombre;
        $this->password = $password;
        $this->roles = $roles;
    }

    public static function buscaUsuario($nombreUsuario) {
        $app = Aplicacion::getInstancia();
        $conn = $app->getConexionBd();
        $sql = "SELECT * FROM Usuarios WHERE nombreUsuario = 'nombreUsuario'";
        $result = $conn->query($sql);
        if ($result == null) {
            
            $usuario = false;
        }
        else {
            $fila = $result->fetch_assoc();
            $usuario = new Usuario($fila['id'], $fila['nombreUsuario'], $fila['nombre'], $fila['password'], $fila['roles']);
        }

        return $usuario;
    }

    public function coincidePassword($password) {
        
        return password_verify($this->$password, $password);
    }

    public static function login($nombreUsuario, $password) {

        $usuario = self::buscaUsuario($nombreUsuario);
        if ($usuario->coincidePassword($password)){
            return $usuario;
        }
        return false;

    }

    public static function registro($nombreUsuario, $nombre, $password) {
        $usuario = self::buscaUsuario($nombreUsuario);

        if (!$usuario) {
            return self::crea($nombreUsuario, $nombre, $password, [2]);
        }
        
        return false;
    }

    public static function crea($nombreUsuario, $nombre, $password, $rol) {
        self::$nombreUsuario = $nombreUsuario;
        self::$nombre = $nombre;
        self::$password = password_hash($password, PASSWORD_DEFAULT);
        self::$rol = $rol;

        $app = Aplicacion::getInstancia();
        $conn = $app->getConexionBd();
        $sql = "INSERT INTO Usuarios (nombreUsuario, nombre, password) VALUES
                ('$nombreUsuario, $nombre, $password)";
        $result = $conn->query($sql);

        if ($result) {
            self::$id = $conn->insert_id;
            $result = self::generaRoles(self::$id, $rol);
        }
        else{
            error_log("Error BD ({$conn->errno}):{$conn->error}");
        }

        return $result;
    }

    private static function generaRoles($idUsuario, $roles) {

        $app = Aplicacion::getInstancia();
        $conn = $app->getConexionBd();

        foreach($roles as $rol) {
            $sql = "INSERT INTO RolesUsuario(usuario, rol) VALUES
                    ('$idUsuario', '$rol')";
            
            $result = $conn->query($sql);
            if (!$result) {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
                return false;
            }
        }

        return true;
    }

}