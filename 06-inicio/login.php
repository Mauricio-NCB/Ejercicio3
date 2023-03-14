<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioLogin';

$form = new FormularioLogin();
$htmlformLogin = $form->gestiona();

$tituloPagina = 'Login';

$contenidoPrincipal = <<<EOS
$htmlformLogin
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
