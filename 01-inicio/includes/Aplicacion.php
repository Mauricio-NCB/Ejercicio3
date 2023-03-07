<?php

require_once 'config.php';

class Aplicacion {

    private static $instancia = null;

    private $bdDatosConexion = null;

    private $inicializada = false;

    private $conexion = null;

    public static function getInstancia() {
        if (self::$instancia == null) {
            self::$instancia = new Aplicacion();
        }

        return self::$instancia;
    }

    public function init($bdDatosConexion) {
        if (!$this->inicializada) {
            $this->inicializada = true;
            $this->bdDatosConexion = $bdDatosConexion;
        }
    }

    public function getConexionBd() {
        if ($this->conexion == null) {
            $bdHost = $this->bdDatosConexion['localhost'];
            $bdUser = $this->bdDatosConexion['admin'];
            $bdPass = $this->bdDatosConexion['paswd'];
            $bdName = $this->bdDatosConexion['Ejercicio3'];
                    
            $conexion = new \mysqli($bdHost, $bdUser, $bdPass, $bdName);

            if ($conexion->connect_errno) {
                echo "Fallo al conectar a MySql: " . $conexion->connect_error;
                exit();
            }

            $this->conexion = $conexion;
        }

        return $this->conexion;
    }
}