<?php
session_start();
class Adminlog extends Controller
{
    public function index()
    {
        $this->view('adminlog');
    }

    public function login(){

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

                    header('Location: ../adminpanel');

                }
                else {
                    header('Location: ../adminlog');

                }
            }else {
                header('Location: ../adminlog');

            }
        }

    }

    public function da(){
        $password = password_hash('baba', PASSWORD_DEFAULT);
        echo $password;
    }



}