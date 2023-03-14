<?php

class FormularioRegistro extends Formulario{

    public function __construct(){
        
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
                <input id="nombreUsuario" type="text" name="nombreUsuario" value=$nombreUsuario/>
            {$erroresCampos["nombreUsuario"]}
            </div>
             <div>
                <label for="nombre">Nombre: </label>
                <input id="nombre" type="text" name="nombre" value=$nombre/>
            {$erroresCampos["nombre"]}
            </div>
             <div>
                <label for="password">Contraseña: </label>
                <input id="password" type="text" name="passsword"/>
            {$erroresCampos["password"]}
            </div>
            <div>
                <label for="password2">Repetir contraseña: </label>
                <input id="password2" type="text" name="passsword2"/>
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
        if(! $nombreUsuario || empty($nombreUsuario)){
            $this->errores['nombreUsuario'] = 'El nombre de usuario no puede estar vacío';
        }
        $nombre = trim($datos['nombre']??'');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if(! $nombre || empty($nombre)){
            $this->errores['nombre'] = 'El nombre no puede estar vacío';
        }
        $password = trim($datos['password']??'');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if(! $password || empty($password)){
            $this->errores['password'] = 'El password no puede estar vacío';
        }
        $password2 = trim($datos['password2']??'');
        $password2 = filter_var($password2, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if(! $password2 || empty($password2)){
            $this->errores['password2'] = 'La repetición del password no puede estar vacío';
        }
        if (count($this->errores) === 0 && $password == $password2){
            $usuario = Usuario::crea($nombreUsuario, $password, $nombre, USER_ROLE);
            if (!$usuario){
                $this->errores[] =  "El usuario y la contraseña no coinciden";
            }else{
                $_SESSION['login'] = true;
                $_SESSION['nombre'] = $usuario->getNombre();
                $_SESSION['login'] = $usuario->tieneRol(Usuario::USER_ROLE);
            }
        }
    }
}