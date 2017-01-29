<?php

class Login extends Controller{

    public function __construct(View $view, LoginModel $LoginModel)
    {
        //Recupero los parámetros recibidos
        $args = func_get_args();

        //Llamo al padre usando los mismos parámetros
        call_user_func_array('parent::__construct', $args);
    }// construct()

    public function index()
    {
        if(Session::userIsLoggedIn()){
            $this->view->render('login/usuarioLogueado');
        }else{
            $this->view->render('login/index');
        }
        
    }// index()

    public function doLogin()
    {
        if($this->LoginModel->doLogin($_POST)){
            if($origen = Session::get('origen')){ 
                Session::set('origen', null); 
                header ('location:' . $origen); 
                exit(); 
            }else{
                $this->view->render('login/usuarioLogueado');
            }
        } else {

            $this->view->render('login/index');
        }
    }// doLogin()

    public function salir()
    {
        Session::destroy();
        header('location: /');
        exit();
    }// salir()

}// class