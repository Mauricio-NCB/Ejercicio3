<?php
require_once __DIR__."/Formulario.php";
require_once __DIR__."/Usuario.php";
class FormularioRegistro extends Formulario{

    public function __construct(){
        parent::__construct('formRegistro', ['urlRedireccion' => 'index.php']);
    }

    protected function generaCamposFormulario(&$datos){
        $nombreUsuario = $datos['nombreUsuario']??'';
        $nombre = $datos['nombre']??'';
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombreUsuario', 'nombre', 'password', 'password2'], $this->errores, 'span', array('class' => 'error'));
        
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Formulario de Registro</legend>
            <div>
                <label for="nombreUsuario">Nombre de usuario: </label>
                <input id="nombreUsuario" type="text" name="nombreUsuario" value="$nombreUsuario" />
                {$erroresCampos["nombreUsuario"]}
            </div>
             <div>
                <label for="nombre">Nombre: </label>
                <input id="nombre" type="text" name="nombre" value="$nombre" />
                {$erroresCampos["nombre"]}
            </div>
             <div>
                <label for="password">Contraseña: </label>
                <input id="password" type="password" name="password" />
                {$erroresCampos["password"]}
            </div>
            <div>
                <label for="password2">Repetir contraseña: </label>
                <input id="password2" type="password" name="password2" />
                {$erroresCampos["password2"]}
            </div>
            <div>
                <button type="submit" name="registro">Entrar</button>
            </div>
        EOF;
        return $html;
    }
    

    protected function procesaFormulario(&$datos){
        $this->errores = [];
        $nombreUsuario = trim($datos['nombreUsuario']??'');
        $nombreUsuario = filter_var($nombreUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if(! $nombreUsuario || mb_strlen($nombreUsuario) < 5){
            $this->errores['nombreUsuario'] = 'El nombre de usuario tiene que tener una longitud de al menos 5 caracteres.';
        }
        $nombre = trim($datos['nombre']??'');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if(! $nombre || mb_strlen($nombre) < 5){
            $this->errores['nombre'] = 'El nombre tiene que tener una longitud de al menos 5 caracteres.';
        }
        $password = trim($datos['password']??'');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if(! $password || mb_strlen($password) < 5){
            $this->errores['password'] = 'El password tiene que tener una longitud de al menos 5 caracteres.';
        }
        $password2 = trim($datos['password2']??'');
        $password2 = filter_var($password2, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if(! $password2 || $password != $password2){
            $this->errores['password2'] = 'Las password deben coincidir';
        }

        if (count($this->errores) === 0 && $password == $password2){
            $usuario = Usuario::buscaUsuario($nombreUsuario);
            if ($usuario){
                $this->errores[] =  "El usuario ya existe";
            }else{
                $usuario = Usuario::crea($nombreUsuario, $password, $nombre, Usuario::USER_ROLE);
                $_SESSION['login'] = true;
                $_SESSION['nombre'] = $usuario->getNombre();
            }
        }
    }
}