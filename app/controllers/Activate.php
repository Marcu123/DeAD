<?php

class Activate extends Controller
{
    public function index()
    {
        session_start();
        $this->view('activate');
        unset($_SESSION['error']);
    }

    public function activate(){
        session_start();
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            require_once '../app/services/UserService.php';
            $userService = new UserService();
            $activationCode = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
            if ($userService->getUserByActivationCode($activationCode)) {
                $userService->activateUser($activationCode);
                header('Location: ../userlog');
            }else {
                $_SESSION['error'] = "Invalid activation code";
                header('Location: ../activate');
            }
        }
    }

}