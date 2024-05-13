<?php
session_start();

class Userlog extends Controller{

    public function index(){
        $this->view('userlog');
    }

    public function login(){

        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['log_btn'])){
            require_once '../app/services/UserService.php';
            $userService = new UserService();


            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);




            if ($userService->getUserByUsername($username)) {
                if (password_verify($password, $userService->getPasswordByUsername($username))) {

                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $password;

                    $_SESSION['cnp'] = $userService->getCNPByUsername($username);
                    $_SESSION['email'] = $userService->getEmailByUsername($username);
                    $_SESSION['phone_number'] = $userService->getPhoneByUsername($username);

                    header('Location: ../userprofile');

                }
                else {
                    header('Location: ../userlog');

                }
            }else {
                header('Location: ../userlog');

            }
        }

    }

    public function register(){
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reg_btn'])){
            require_once '../app/models/User.php';

            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
            $password = password_hash($password, PASSWORD_DEFAULT);

            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
            $cnp = filter_input(INPUT_POST, 'cnp', FILTER_SANITIZE_SPECIAL_CHARS);
            $phone = filter_input(INPUT_POST, 'phone-number', FILTER_SANITIZE_SPECIAL_CHARS);
            $photo = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_SPECIAL_CHARS);

            $user = new User();
            $user->setUsername($username);
            $user->setPassword($password);
            $user->setEmail($email);
            $user->setCnp($cnp);
            $user->setPhone($phone);
            $user->setPhoto($photo);

            require_once '../app/services/UserService.php';
            $userService = new UserService();


            if ($userService->registerUser($user)){
                header('Location: ../userlog');
                exit;
            }
            else{
                header('Location: ../userlog');
                exit;
            }
        }
        
    }

    public function logout(){
        //echo $_SERVER['REQUEST_METHOD'];
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logout'])){
            //echo "logout";
            session_destroy();
            header('Location: ../../userlog');
            exit;
        }
    }

    public function __toString()
    {
        return "Userlog";
    }


}