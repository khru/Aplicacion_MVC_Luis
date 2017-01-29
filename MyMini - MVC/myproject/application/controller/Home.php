<?php

class Home extends Controller
{
    public function index()
    {
        $this->view->addData(['titulo' => 'Home']);
        $this->view->render("home/index");
       
    }// index()
}// class
