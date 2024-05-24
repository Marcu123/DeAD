<?php

class Changepassword extends Controller
{
    public function index()
    {
        session_start();
        if (!isset($_SESSION['username'])) {
            header('Location: userlog');
        }
        $this->view('changepassword');
        unset($_SESSION['error']);
        unset($_SESSION['good']);
    }

    public function newPassword()
    {
        echo $_SERVER['REQUEST_METHOD'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['password']) && isset($_POST['new_password'])) {
            require_once '../app/services/UserService.php';
            $userService = new UserService();
            session_start();
            $username = $_SESSION['username'];
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
            //$password = password_hash($password, PASSWORD_DEFAULT);

            if($userService->getUserByUsername($username)){
                if(password_verify($password, $userService->getPasswordByUsername($username))){
                    $new_password = filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_SPECIAL_CHARS);
                    $new_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $result = $userService->existsPassword($new_password);
                    file_put_contents('delete_log.txt', $new_password, FILE_APPEND);
                    if($result){
                        $_SESSION['error'] = 'Password already exists';
                        header('Location: ../changepassword');
                        exit;
                    }


                    $userService->updatePassword($new_password,$username);

                    session_destroy();

                    $_SESSION['good'] = 'Password changed successfully';
                    header('Location: ../userlog');
                }
                else{

                    $_SESSION['error'] = 'Incorrect password';
                    header('Location: ../changepassword');
                }
            }
            else{
                $_SESSION['error'] = 'User not found';
                header('Location: ../changepassword');
            }
        }
    }



}