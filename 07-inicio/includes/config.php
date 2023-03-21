<?php

namespace es\ucm\fdi\aw;
use es\ucm\fdi\aw\Aplicacion;

spl_autoload_register(function ($class){    
    $prefix ='es\\ucm\\fdi\\aw\\';

    $length = strlen($prefix);
    $base_directory= __DIR__.'/';

    if (strncmp($prefix, $class, $length) !== 0){
        return;
    }
    $relative_class = substr($class, $length);
    $file = $base_directory.str_replace('\\', '/', $relative_class).'.php';

    if (file_exists($file)){
        require $file;
    }
});
/**
 * Parámetros de conexión a la BD
 */
define('BD_HOST', 'localhost');
define('BD_NAME', 'ejercicio3');
define('BD_USER', 'ejercicio3');
define('BD_PASS', 'ejercicio3');

/**
 * Parámetros de configuración utilizados para generar las URLs y las rutas a ficheros en la aplicación
 */
define('RAIZ_APP', __DIR__);
define('RUTA_APP', '/Ejercicio3/07-inicio');
define('RUTA_IMGS', RUTA_APP.'/img');
define('RUTA_CSS', RUTA_APP.'/css');
define('RUTA_JS', RUTA_APP.'/js');

/**
 * Configuración del soporte de UTF-8, localización (idioma y país) y zona horaria
 */
ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');
date_default_timezone_set('Europe/Madrid');



// Inicializa la aplicación
$app = Aplicacion::getInstance();
$app->init(['host'=>BD_HOST, 'bd'=>BD_NAME, 'user'=>BD_USER, 'pass'=>BD_PASS]);

/**
 * @see http://php.net/manual/en/function.register-shutdown-function.php
 * @see http://php.net/manual/en/language.types.callable.php
 */
register_shutdown_function([$app, 'shutdown']);