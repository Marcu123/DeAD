<?php

class Adminpanel extends Controller
{
    public function index()
    {
        $this->view('adminpanel');

    }

    public function logout()
    {
        session_start();

        session_destroy();
        header('Location: ../adminlog');
    }

}