<?php
	require_once 'includes/config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Admin</title>
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
<?php if (! isset($_SESSION['esAdmin']) || !$_SESSION['esAdmin']): ?>
		<h1>Acceso denegado!</h1>
		<p>No tienes permisos suficientes para administrar la web.</p>
<?php else: ?>
		<h1>Consola de administración</h1>
		<p>Aquí estarían todos los controles de administración</p>
<?php endif; ?>
	</article>
</main>
<?php
require('includes/vistas/comun/sidebarDer.php');
require('includes/vistas/comun/pie.php');
?>
</div>
</body>
</html>
