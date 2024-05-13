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
                    $_SESSION['username'] = $username;
                    $_SESSION['admin_key'] = $admin_key;

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



}