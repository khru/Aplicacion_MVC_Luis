<?php

class Error extends Controller
{
    private $msg;

    public function __construct($msg = "",View $view)
    {
        parent::__construct($view);
        $this->msg = $msg;
    }// construct()

    public function index()
    {
         $this->view->addData(['titulo' => 'Error 404']);
        $this->view->render('error/index', array(
            'msg' => $this->msg
        ));
    }// index()
}// class
