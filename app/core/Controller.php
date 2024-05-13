<?php
/**
 * parent controller class
 */
class Controller{
    public function model($model){
        require_once "../app/models/" . $model . ".php";
        require_once "../app/services/" . $model . "Service.php";
    }

    public function view($src, $data = []){
        require_once "View.php";
        $view = new View($src);
        $view->show($data);
    }
}