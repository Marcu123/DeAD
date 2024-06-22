<?php
/**
 * parent controller class
 */
class Controller{
    public function model($model){
        if(strcmp($model, 'request') == 0)
            require_once "../app/models/RequestM.php";
        else
            require_once "../app/models/" . $model . ".php";

        if(file_exists("../app/services/" . $model . "Service.php")){
            include_once "../app/services/" . $model . "Service.php";
        }
    }

    public function view($src, $data = []){
        require_once "View.php";
        $view = new View($src);
        $view->show($data);
    }
}