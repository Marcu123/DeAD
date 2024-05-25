<?php

class SearchPage extends Controller { 
    public function index($name = ''){
        session_start();
        $this->view('searchpage');
    }
}