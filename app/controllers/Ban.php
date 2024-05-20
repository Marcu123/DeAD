<?php

class Ban extends Controller
{
    public function index()
    {
        session_start();
        if (!isset($_SESSION['username_adm'])) {
            header('Location: adminlog');
        }
        $this->view('ban');
    }
    public function execute(){
        $this->model('user');

        $uService = new UserService();
        $uService->delete($_POST['username']);

        header('Location: ../Ban');
    }
}