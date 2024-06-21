<?php

class RegisterController
{

    public function register()
    {
        //$_POST = json_decode(file_get_contents("php://input"), true);

        if(isset($_POST['username'])){
            $username = $_POST['username'];
        } else {
            $this->badRequest();
            exit;
        }
        echo 'aici';
        if(isset($_POST['password'])){
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        } else{
            $this->badRequest();
            exit;
        }
        if(isset($_POST['email'])){
            $email = $_POST['email'];
        } else{
            $this->badRequest();
            exit;
        }
        if(isset($_POST['cnp'])){
            $cnp = $_POST['cnp'];
        } else{
            $this->badRequest();
            exit;
        }
        if(isset($_POST['phone'])){
            $phone = $_POST['phone'];
        } else{
            $this->badRequest();
            exit;
        }

        require_once "../app/models/User.php";

        $user = new User();
        $user->setUsername($username);
        $user->setPassword($password);
        $user->setEmail($email);
        $user->setCnp($cnp);
        $user->setPhone($phone);
        $user->setPhoto('idk');
        $user->setEnabled(false);

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 10; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        $user->setActivationCode($randomString);

        require_once '../app/services/UserService.php';
        $userService = new UserService();

        if ($userService->registerUser($user)) {
            include_once "PhotoController.php";
            $photoController = new PhotoController();
            $photoController->processRequest($user->getCnp(), 'user');
            $to = $user->getEmail();
            $subject = 'Activation code';
            $message = 'Please visit to following page and activate your account with the following code: ' . $user->getActivationCode() . ' http://localhost/DeAD/public/activate';
            $headers = array(
                'From' => 'marcugames03@gmail.com',
                'Reply-To' => 'marcugames03@gmail.com',
            );

            mail($to, $subject, $message, $headers);

            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['content_type_header'] = 'Content-Type: application/json';
            $response['body'] = json_encode([
                'msg' => 'Email sent! Please activate your account by clicking the link in the email'
            ]);

            header($response['status_code_header']);
            header($response['content_type_header']);
            if ($response['body']) {
                echo $response['body'];
            }
        } else{
            header('HTTP/1.0 400 Bad Request');
            echo 'Can\'t create user';
        }
    }

    private function badRequest()
    {
    }
}