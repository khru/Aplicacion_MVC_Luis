<?php

class LoginModel extends Model
{

    public function doLogin($datos)
    {
        if(!$datos){

            Session::add('feedback_negative', 'No tengo los datos de Login');
            return false;
        }

        $campos = ["usuario", "clave"];
        $datos = CleanUp::secure($datos, $campos);

        foreach ($datos as $campo) {
            CleanUp::clean($campo);
        }

        if(strpos($datos['usuario'], '@') !== false){
            $tipo = 'email';
        }else{
            $tipo = 'nick';
        }

        if($tipo == 'email'){
            if(($error = Validation::email($datos['usuario'])) !== true){
                Session::add('feedback_negative', $error);
        
            }
        }

        if($tipo == 'nick'){
            if(($error = Validation::nick($datos['usuario'])) !== true){

                Session::add('feedback_negative', $error);
        
            }
        }
        
        if(($error = Validation::password($datos['clave'])) !== true){

            Session::add('feedback_negative', $error);
        
        }

        if(Session::get('feedback_negative')){
            return false;
        }

        if($tipo == 'email'){
            $ssql = "SELECT nick, password, email, categoria FROM usuario WHERE email=:usuario";
        }

        if($tipo == 'nick'){
            $ssql = "SELECT nick, password, email, categoria FROM usuario WHERE nick=:usuario";
        }

        $query = $this->conexion->prepare($ssql);
        $query->bindValue(':usuario', $datos['usuario'], PDO::PARAM_STR);
        $query->execute();

        if($query->rowCount() != 1){
            Session::add('feedback_negative', 'Usuario o contraseña incorrectos');
            return false;
        }

        $usuario = $query->fetch();
        if($usuario->password != md5($datos['clave'])){
            Session::add('feedback_negative', 'Usuario o contraseña incorrectos');
            return false;
        }

        Session::set('user_nick', $usuario->nick);
        Session::set('user_email', $usuario->email);
        Session::set('user_categoria', $usuario->categoria);
        Session::set('user_logged_in', true);
        
        return true;

    }

}