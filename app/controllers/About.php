<?php

class About extends Controller
{
    public function index()
    {
        session_start();
        $this->view('about');
    }

}