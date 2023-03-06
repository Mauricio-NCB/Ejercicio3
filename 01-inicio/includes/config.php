<?php

require_once __DIR__.'/Aplicacion.php';

if (!isset($_SESSION)) {
    session_start();
}

//Configuración conexión BD

define('BD_HOST', 'localhost');
define('BD_NAME', 'Ejercicio3');
define('BD_USER', 'admin');
define('BD_PASS', 'paswd');


//Configuración localización y zona horaria

ini_set('default_chaset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');
date_default_timezone_set('Europe/Madrid');


//Inicar la aplicación
