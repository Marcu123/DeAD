<?php

class Userprofile extends Controller
{
    public function index()
    {
        $this->view('userprofile');
    }

    public function logout()
    {
        session_start();

        session_destroy();
        header('Location: ../userlog');
    }

}