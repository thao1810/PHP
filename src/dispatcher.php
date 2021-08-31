<?php

namespace MVC;

use MVC\Request;
use MVC\Router;


class Dispatcher
{

    private $request;

    public function dispatch()
    {
        $this->request = new Request();
        
        Router::parse($this->request->url, $this->request);
        
        $controller = $this->loadController();

        call_user_func_array([$controller, $this->request->action], $this->request->params);
    }

    public function loadController()
    {
        $class = ucfirst($this->request->controller) . "Controller";
        //$file = ROOT . 'Controllers/' . $name . '.php';
        //require($file);
        //$name = 'MVC\Controllers\TasksController';
        
       
       

        $name = 'MVC\Controllers\\' . $class;
        //echo $name;
        $controller = new $name();
       

	    return new $controller;

    }

}
?>