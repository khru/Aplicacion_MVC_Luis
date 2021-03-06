<?php

class Session
{
    public static function init()
    {
        if(session_id() == ''){
            session_start();
        }
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        if(isset($_SESSION[$key])){
            return $_SESSION[$key];
        }
    }

    public static function add($key,$value)
    {
        $_SESSION[$key][] = $value;
    }

    public static function delete($key)
    {
        if(isset($_SESSION[$key])){
            unset($_SESSION[$key]);
        }
    }

    public static function destroy()
    {
        session_destroy();
    }

    public static function userIsLoggedIn()
    {
        return (Session::get('user_logged_in') ? true : false);
    }

    public static function userIsSub()
    {
        return ((Session::get('user_categoria') == 'subscriptor') ? true : false);
    }

    public static function userIsAdmin()
    {
        return ((Session::get('user_categoria') == 'administrador') ? true : false);
    }
}