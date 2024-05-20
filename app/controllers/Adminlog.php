<?php

class Adminlog extends Controller
{
    public function index()
    {
        session_start();
        $this->view('adminlog');
        unset($_SESSION['error_adm']);
    }

    public function login(){
        session_start();
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['log_btn'])){
            require_once '../app/services/AdminService.php';
            $adminService = new AdminService();


            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
            $admin_key = filter_input(INPUT_POST, 'admin_key', FILTER_SANITIZE_SPECIAL_CHARS);




            if ($adminService->getAdminByUsername($username)) {

                if (password_verify($admin_key, $adminService->getPasswordByUsername($username))) {
                    $_SESSION['username_adm'] = $username;
                    $_SESSION['admin_key'] = $admin_key;
                    $_SESSION['prison_name'] = $adminService->getPrisonByUsername($username);
                    $_SESSION['requests_nr'] = $adminService->getNewRequestsNr($username);
                    require_once '../app/services/PrisonService.php';
                    $prisonService = new PrisonService();
                    $_SESSION['inmates_nr'] = $prisonService->getNrOfInmatesById($username);

                    unset($_SESSION['error_adm']);
                    header('Location: ../adminpanel');

                }
                else {
                    $_SESSION['error_adm'] = "Invalid username or password";
                    header('Location: ../adminlog');

                }
            }else {
                $_SESSION['error_adm'] = "Invalid username or password";
                header('Location: ../adminlog');

            }
        }

    }
}