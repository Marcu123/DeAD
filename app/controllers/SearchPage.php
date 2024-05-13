<?php

class SearchPage extends Controller { 
    public function index($name = ''){
        /*$user = $this->model('Home');
        $user->name = $name;
        
        $this->view('home/index', ['name' => $user->name]);

        echo $user->name;*/
        $this->view('searchpage');

    }
}