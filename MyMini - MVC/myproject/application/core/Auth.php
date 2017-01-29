<?php

class Auth
{
    public static function checkSubAutentication()
    {
        Session::init();
        if(!(Session::userIsLoggedIn() && (Session::userIsSub()) || Session::userIsAdmin())){
            Session::destroy();
            Session::init(); 
    		Session::set('origen', $_SERVER['REQUEST_URI']); 
            header('location: /Login');
            exit();
        }
    }// checkSubAutentication()

    public static function checkAdminAutentication()
    {
        Session::init();
        if(!Session::userIsLoggedIn()){

            Session::destroy();
            Session::init(); 
            Session::set('origen', $_SERVER['REQUEST_URI']); 
            header('location: /Login');
            exit();

        } else {
            if(!Session::userIsAdmin()){
                Session::add('warning', 'No tienes privilegios para acceder a esa página'); 
                header('location: /Home');
                exit();
            }
        }
    }// checkAdminAutentication()
}// class