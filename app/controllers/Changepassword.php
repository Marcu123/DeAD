<?php
session_start();
class Changepassword extends Controller
{
    public function index()
    {
        $this->view('changepassword');
    }

    public function newPassword()
    {
        echo $_SERVER['REQUEST_METHOD'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['password']) && isset($_POST['new_password'])) {
            require_once '../app/services/UserService.php';
            $userService = new UserService();

            $username = $_SESSION['username'];
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
            //$password = password_hash($password, PASSWORD_DEFAULT);

            if($userService->getUserByUsername($username)){
                if(password_verify($password, $userService->getPasswordByUsername($username))){
                    $new_password = filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_SPECIAL_CHARS);
                    $new_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $userService->updatePassword($new_password,$username);

                    session_destroy();

                    header('Location: ../userlog');
                }
                else{

                    header('Location: ../changepassword');
                }
            }
            else{
                header('Location: ../changepassword');
            }
        }
    }



}