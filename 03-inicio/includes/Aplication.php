<?php


class Aplicacion {  
    private static $instancia;
    private $iniciada = false;
    private $conn;
    private $dbDatosdeConexion;

    function __construct(){

    }
    
    public static function getInstance(){
        if (self::$instancia != null){
            self::$instancia = new static();
        }
        return self::$instancia;
    }

    function init($dbDatosdeConexion){
        if (!$this->iniciada){
            $this->dbDatosdeConexion = $dbDatosdeConexion;
            $this->iniciada = true;
        }
    }

    public function shutdown(){
        $this->compruebaInstanciaIniciada();
    }

    private function compruebaInstanciaIniciada(){
        if (!$this->iniciada){
            echo "Aplicación no iniciada";
            exit();
        }
    }

    function getConexiónBd(){
        if (!$this->conn){
            $host = $this->dbDatosdeConexion['host'];
            $user = $this->dbDatosdeConexion['user'];
            $pass = $this->dbDatosdeConexion['pass'];
            $db = $this->dbDatosdeConexion['db'];


            $conn = new mysqli($host, $user, $pass, $db);
            if ($conn->connect_error){
                die("La conexión ha fallado" . $conn->connect_error);
            }
            if (!$conn->set_charset('utfmb8')){
                echo "Error al configurar la BD ({$conn->errno}): {$conn->error}";
                exit();
            }
            $this->conn = $conn;
        }
        return $this->conn;
    }
}