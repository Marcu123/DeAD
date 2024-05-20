<?php

class Contact extends Controller
{
    public function index()
    {
        session_start();
        $this->view('contact');
    }

}