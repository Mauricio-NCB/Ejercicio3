<?php
require_once 'includes/config.php';
require_once 'includes/Usuario.php';

$formEnviado = isset($_POST['login']);
if (! $formEnviado ) {
	header('Location: login.php');
	exit();
}

require_once 'includes/utils.php';

$erroresFormulario = [];

$nombreUsuario = filter_input(INPUT_POST, 'nombreUsuario', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if ( ! $nombreUsuario || empty($nombreUsuario=trim($nombreUsuario)) ) {
	$erroresFormulario['nombreUsuario'] = 'El nombre de usuario no puede estar vacío';
}

$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if ( ! $password || empty($password=trim($password)) ) {
	$erroresFormulario['password'] = 'El password no puede estar vacío.';
}

if (count($erroresFormulario) === 0) {
	
	$usuario = Usuario::login($nombreUsuario, $password);

	if ($usuario) {

					$_SESSION['login'] = true;
					$_SESSION['nombre'] = $usuario->getNombre();
					$_SESSION['esAdmin'] = array_search(ADMIN_ROLE, $usuario->getRoles()) !== false;
					header('Location: index.php');
					exit();

	} 
	else {
		$erroresFormulario[] = "El usuario o el password no coinciden";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Login</title>
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
		<h1>Acceso al sistema</h1>
		<?= generaErroresGlobalesFormulario($erroresFormulario) ?>
		<form action="procesarLogin.php" method="POST">
		<fieldset>
            <legend>Usuario y contraseña</legend>
            <div>
                <label for="nombreUsuario">Nombre de usuario:</label>
				<input id="nombreUsuario" type="text" name="nombreUsuario" value="<?= $nombreUsuario ?>" />
				<?=  generarError('nombreUsuario', $erroresFormulario) ?>
            </div>
            <div>
                <label for="password">Password:</label>
				<input id="password" type="password" name="password" value="<?= $password ?>" />
				<?=  generarError('password', $erroresFormulario) ?>
            </div>
            <div>
				<button type="submit" name="login">Entrar</button>
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