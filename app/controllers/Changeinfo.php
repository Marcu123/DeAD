<?php

class Changeinfo extends Controller
{
    public function index()
    {
        session_start();
        if (!isset($_SESSION['username'])) {
            header('Location: userlog');
        }
        $this->view('changeinfo');
    }

    public function change()
    {
        require_once '../app/services/UserService.php';
        $userService = new UserService();
        session_start();

        $oldUsername = $_SESSION['username'];

        if(!empty($_POST['email'])){
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
            $userService->setEmail($email, $oldUsername);
            $_SESSION['email'] = $email;
        }

        if(!empty($_POST['phone-number'])){
            $phone = filter_input(INPUT_POST, 'phone-number', FILTER_SANITIZE_SPECIAL_CHARS);
            $userService->setPhone($phone, $oldUsername);
            $_SESSION['phone_number'] = $phone;
        }

        if(!empty($_POST['cnp'])){
            $cnp = filter_input(INPUT_POST, 'cnp', FILTER_SANITIZE_SPECIAL_CHARS);
            $userService->setCNP($cnp, $oldUsername);
            $_SESSION['cnp'] = $cnp;
        }

        if(!empty($_POST['username'])){
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
            $userService->setUsername($username, $oldUsername);
            $_SESSION['username'] = $username;
        }

        header('Location: ../userprofile');




    }



}