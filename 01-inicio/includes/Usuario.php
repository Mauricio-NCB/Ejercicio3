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

    public function getNombre() {
        return $this->nombre;
    }

    public function getRoles() {
        return $this->roles;
    }

    public static function buscaUsuario($nombreUsuario) {
        $app = Aplicacion::getInstancia();
        $conn = $app->getConexionBd();
        $sql = "SELECT * FROM Usuarios WHERE nombreUsuario = '$nombreUsuario'";
        $result = $conn->query($sql);
        if ($result->num_rows == 0) {
            
            $usuario = false;
        }
        else {
            $fila = $result->fetch_assoc();

            $rolesUsuario = self::cargaRoles($fila['id']);
            $usuario = new Usuario($fila['id'], $fila['nombreUsuario'], $fila['nombre'], $fila['password'], $rolesUsuario);
        }

        return $usuario;
    }

    public function coincidePassword($password) {
        
        return password_verify($password, $this->password);
    }

    public static function login($nombreUsuario, $password) {

        $usuario = self::buscaUsuario($nombreUsuario);
        if ($usuario && $usuario->coincidePassword($password)){
            return $usuario;
        }
        return false;

    }

    public static function registro($nombreUsuario, $nombre, $password) {
        $usuario = self::buscaUsuario($nombreUsuario);

        if (!$usuario) {
            $roles[] = 2;

            return self::crea($nombreUsuario, $nombre, $password, $roles);
        }
        
        return false;
    }

    public static function crea($nombreUsuario, $nombre, $password, $rol) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $app = Aplicacion::getInstancia();
        $conn = $app->getConexionBd();
        $sql = "INSERT INTO Usuarios (nombreUsuario, password, nombre) VALUES
                ('$nombreUsuario', '$hashedPassword', '$nombre')";
        $result = $conn->query($sql);

        if ($result) {
            $id = $conn->insert_id;

            if (self::insertaRoles($id, $rol)) {
                $usuario = new Usuario($id, $nombreUsuario, $nombre, $hashedPassword, $rol);

                return $usuario;
            }
        }
        else{
            error_log("Error BD ({$conn->errno}):{$conn->error}");
        }

        return false;
    }

    private static function cargaRoles($idUsuario) {
        $app = Aplicacion::getInstancia();
        $conn = $app->getConexionBd();

        $sql = "SELECT * FROM RolesUsuario WHERE usuario = '$idUsuario'";
        $result = $conn->query($sql);

        $roles = [];

        if ($result) {
            $rolesRows = $result->fetch_all(MYSQLI_ASSOC);

            foreach ($rolesRows as $rol) {
                $roles[] = $rol['rol'];
            }
        }
        else {
            error_log("Error BD ({$conn->errno}):  {$conn->error}");
		    exit();
        }
            
        return $roles;
    }

    private static function insertaRoles($idUsuario, $roles) {

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