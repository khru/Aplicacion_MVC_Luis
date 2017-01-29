<?php

class Controller
{
    public $view = null;

    function __construct(View $view)
    {
        $this->view = $view;

        Session::init();

        //Se obtienen los argumentos recibidos
        $args = func_get_args();

        //Se crean atributos modelo con el nombre de la clase
        foreach ($args as $arg) {
        	if(is_subclass_of($arg, 'Model')){
        		$this->{get_class($arg)} = $arg;
        	}
        }
    }

}
