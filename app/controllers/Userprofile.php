<?php

class Userprofile extends Controller
{
    public function index()
    {
        session_start();
        if (!isset($_SESSION['username'])) {
            header('Location: userlog');
        }
        $this->view('userprofile');
    }

    public function logout()
    {
        session_start();

        session_destroy();
        header('Location: ../userlog');
    }

}