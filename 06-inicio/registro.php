<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioRegistro.php';

$form = new FormularioRegistro();
$htmlformRegistro = $form->gestiona();

$tituloPagina = 'Registro';

$contenidoPrincipal = <<<EOS
$htmlformRegistro
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
