<?php

class Adminpanel extends Controller
{
    public function index()
    {
        session_start();
        if (!isset($_SESSION['username_adm'])) {
            header('Location: adminlog');
        }
        $this->view('adminpanel');

    }

    public function logout()
    {
        session_start();

        session_destroy();
        header('Location: ../adminlog');
    }



}