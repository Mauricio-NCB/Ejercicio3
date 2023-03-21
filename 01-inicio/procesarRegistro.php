<?php
require_once 'includes/config.php';
require_once 'includes/Usuario.php';

$formEnviado = isset($_POST['registro']);
if (! $formEnviado ) {
	header('Location: registro.php');
	exit();
}

require_once 'includes/utils.php';

$erroresFormulario = [];

$nombreUsuario = filter_input(INPUT_POST, 'nombreUsuario', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if ( ! $nombreUsuario || empty($nombreUsuario=trim($nombreUsuario)) || mb_strlen($nombreUsuario) < 5) {
	$erroresFormulario['nombreUsuario'] = 'El nombre de usuario tiene que tener una longitud de al menos 5 caracteres.';
}

$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if ( ! $nombre || empty($nombre=trim($nombre)) || mb_strlen($nombre) < 5) {
	$erroresFormulario['nombre'] = 'El nombre tiene que tener una longitud de al menos 5 caracteres.';
}

$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if ( ! $password || empty($password=trim($password)) || mb_strlen($password) < 5 ) {
	$erroresFormulario['password'] = 'El password tiene que tener una longitud de al menos 5 caracteres.';
}

$password2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if ( ! $password2 || empty($password2=trim($password2)) || $password != $password2 ) {
	$erroresFormulario['password2'] = 'Los passwords deben coincidir';
}

if (count($erroresFormulario) === 0) {

	$usuario = Usuario::registro($nombreUsuario, $nombre, $password);

	if ($usuario) {
			
					$_SESSION['login'] = true;
					$_SESSION['nombre'] = $nombre;
					$_SESSION['esAdmin'] = false;
					header('Location: index.php');
					exit();
		
	} else {
		$erroresFormulario[] = 'El usuario ya existe';
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Registro</title>
	<link rel="stylesheet" type="text/css" href="css/estilo.css" />
</head>
<body>
<div id="contenedor">
<?php
require('includes/vistas/comun/cabecera.php');
require('includes/vistas/comun/sidebarIzq.php');
?>
<main>
	<article>
		<h1>Registro de usuario</h1>
		<?= generaErroresGlobalesFormulario($erroresFormulario) ?>
		<form action="procesarRegistro.php" method="POST">
		<fieldset>
            <legend>Datos para el registro</legend>
            <div>
                <label for="nombreUsuario">Nombre de usuario:</label>
				<input id="nombreUsuario" type="text" name="nombreUsuario" value="<?= $nombreUsuario ?>" />
				<?=  generarError('nombreUsuario', $erroresFormulario) ?>
            </div>
            <div>
                <label for="nombre">Nombre:</label>
				<input id="nombre" type="text" name="nombre" value="<?= $nombre ?>" />
				<?=  generarError('nombre', $erroresFormulario) ?>
            </div>
            <div>
                <label for="password">Password:</label>
				<input id="password" type="password" name="password" value="<?= $password ?>" />
				<?=  generarError('password', $erroresFormulario) ?>
            </div>
            <div>
                <label for="password2">Reintroduce el password:</label>
				<input id="password2" type="password" name="password2" value="<?= $password2 ?>" />
				<?=  generarError('password2', $erroresFormulario) ?>
            </div>
            <div>
				<button type="submit" name="registro">Registrar</button>
			</div>
		</fieldset>
		</form>
	</article>
</main>

<?php
require('includes/vistas/comun/sidebarDer.php');
require('includes/vistas/comun/pie.php');
?>
</div>
</body>
</html>
