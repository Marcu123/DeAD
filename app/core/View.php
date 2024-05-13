<?php

class View{
    private $source;
    public function __construct($src){
        $this->source = $src;
    }

    public function show($data){
        require_once "../src/pages/" . $this->source . ".php";
    }
}
