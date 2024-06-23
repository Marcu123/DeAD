<?php
const USERNAME_TAKEN = 1;
const EMAIL_TAKEN = 2;
const CNP_TAKEN = 3;

class Userlog extends Controller
{

    public function index()
    {
        session_start();
        if (isset($_SESSION['username'])) {
            header('Location: userprofile');
        } else if (isset($_SESSION['username_adm'])) {
            header('Location: adminpanel');
        } else {
            $this->view('userlog');
        }
        unset($_SESSION['error']);

    }

    public function login()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['log_btn'])) {
            require_once '../app/services/UserService.php';
            $userService = new UserService();


            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);


            if ($userService->getUserByUsername($username) && $userService->getEnabledByUsername($username)) {
                if (password_verify($password, $userService->getPasswordByUsername($username))) {

                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $password;

                    $_SESSION['cnp'] = $userService->getCNPByUsername($username);
                    $_SESSION['email'] = $userService->getEmailByUsername($username);
                    $_SESSION['phone_number'] = $userService->getPhoneByUsername($username);
                    unset($_SESSION['error']);
                    unset($_SESSION['good']);

                    header('Location: ../userprofile');

                } else {
                    $_SESSION['error'] = "Invalid username or password";
                    header('Location: ../userlog');

                }
            } else {
                $_SESSION['error'] = "Invalid username or password";
                header('Location: ../userlog');

            }
        }

    }

    public function register()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reg_btn'])) {
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
                include_once "../api/PhotoController.php";
                $photoController = new PhotoController();

                $photoController->processRequestFront($user->getCnp(), 'user');
                $to = $user->getEmail();
                $subject = 'Activation code';
                $message = 'Please visit to following page and activate your account with the following code: ' . $user->getActivationCode() . ' http://localhost/DeAD/public/activate';
                $headers = array(
                    'From' => 'marcugames03@gmail.com',
                    'Reply-To' => 'marcugames03@gmail.com',
                );

                mail($to, $subject, $message, $headers);

                $_SESSION['good'] = "Email sent! Please activate your account by clicking the link in the email";
                header('Location: ../userlog');
                exit;
            } else {
                header('Location: ../userlog');
                exit;
            }
        }

    }

    public function logout()
    {
        //echo $_SERVER['REQUEST_METHOD'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logout'])) {
            //echo "logout";
            session_destroy();
            header('Location: ../../userlog');
            exit;
        }
    }








}