<?php

require_once __DIR__.'/Aplicacion.php';

if (!isset($_SESSION)) {
    session_start();
}

//Configuración conexión BD

define('BD_HOST', 'localhost');
define('BD_USER', 'ejercicio3');
define('BD_PASS', 'ejercicio3');
define('BD_NAME', 'ejercicio3');


//Configuración localización y zona horaria

ini_set('default_chaset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');
date_default_timezone_set('Europe/Madrid');


//Inicar la aplicación
$app = Aplicacion::getInstancia();
$app->init(array('host'=>BD_HOST, 'user'=>BD_USER, 'pass'=>BD_PASS, 'bd'=>BD_NAME));
register_shutdown_function([$app, 'shutdown']);

