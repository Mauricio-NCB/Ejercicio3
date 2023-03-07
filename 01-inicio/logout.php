<?php
require_once 'includes/config.php';

//Doble seguridad: unset + destroy
unset($_SESSION['login']);
unset($_SESSION['esAdmin']);
unset($_SESSION['nombre']);


session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Logout</title>
	<link rel="stylesheet" type="text/css" href="estilo.css" />
</head>
<body>
<div id="contenedor">
<?php
require('includes/vistas/comun/cabecera.php');
require('includes/vistas/comun/sidebarIzq.php');
?>
<main>
	<article>
		<h1>Hasta pronto!</h1>
	</article>
</main>
<?php
require('includes/vistas/comun/sidebarDer.php');
require('includes/vistas/comun/pie.php');
?>
</div>
</body>
</html>
