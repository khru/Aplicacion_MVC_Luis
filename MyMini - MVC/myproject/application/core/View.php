<?php

class View
{
    private $templates;

    public function __construct(League\Plates\Engine $e)
    {
        
        $this->templates = $e;
        $this->addData(['titulo' => 'Revista Guardabosques']);
        $this->templates->registerFunction('borrar_msg_feedback', function(){
                Session::set('feedback_negative', null);
                Session::set('feedback_positive', null);
                Session::set('warning', null);
        });
    }

    public function render($plantilla, $datos=[])
    { 
        echo $this->templates->render($plantilla, $datos); 
    }

    //Permite añadir variables globales a toda la plantilla
    public function addData($datos)
    {
        $this->templates->addData($datos);
    }
}