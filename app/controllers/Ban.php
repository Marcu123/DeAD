<?php

class Ban extends Controller
{
    public function index()
    {
        $this->view('ban');
    }
    public function execute(){
        $this->model('user');

        $uService = new UserService();
        $uService->delete($_POST['username']);

        header('Location: ../Ban');
    }
}