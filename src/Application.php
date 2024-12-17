<?php 

namespace Src;

class Application 
{
    private $controller;

    private function setApplication() {
        $loadName = 'Src\Controllers\\';
        @$url = explode('/', $_GET['url']); //@ para não aparecer error
        if(empty($url[0])) {
            $loadName .= 'Home';
        } else {
            $loadName .= ucfirst(strtolower($url[0]));
        }
        $loadName .= 'Controller';

        // var_dump($loadName);die;
        if(file_exists($loadName . '.php')) {
            $this->controller = new $loadName;
        } else {
            include 'Views/errors/notFound.php';
            die();
        }
    }

    public function load() {
        $this->setApplication();
        $this->controller->index();
    }
}