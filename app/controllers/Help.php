<?php

class Help extends Controller
{
    public function index()
    {
        session_start();
        $this->view('help');
    }

}