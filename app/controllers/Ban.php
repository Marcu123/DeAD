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
        unset($_SESSION['error']);
        unset($_SESSION['good']);
    }
    public function execute(){
        session_start();
        $this->model('user');

        $uService = new UserService();
        $result = $uService->delete($_POST['username']);

        if($result>0){
            $_SESSION['good'] = "User banned";
            header('Location: ../ban');

        }
        else{
            $_SESSION['error'] = "User not found";
            header('Location: ../ban');
        }

    }
}