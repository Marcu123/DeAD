<?php

class Privacy extends Controller
{
    public function index()
    {
        session_start();
        $this->view('privacy');
    }

}