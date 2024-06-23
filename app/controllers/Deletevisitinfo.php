<?php

class Deletevisitinfo extends Controller
{
    public function index()
    {
        session_start();
        if (!isset($_SESSION['username_adm'])) {
            header('Location: adminlog');
        }

        $this->view('deletevisitinfo');
    }
    public function delete(){
        session_start();
        $this->model('visitinfo');
        $this->model('admin');
        $this->model('inmate');
        $this->model('prison');

        $visitInfoService = new VisitInfoService();
        $adminService = new AdminService();
        $prisonService = new PrisonService();

        $prisonID = $adminService->getPrisonIdByUsername($_SESSION['username_adm']);
        include_once '../app/services/RequestService.php';
        $requestService = new RequestService();
        if (!$requestService->existsRequestById($_POST['id'])) {
            unset($_SESSION['error']);
            $_SESSION['error'] = 'Visit info not found';
            header('Location: ../Deletevisitinfo');
            return;
        }

        if($prisonID == $prisonService->getPrisonIdByRequestId($_POST['id'])) {
            $visitInfoService->delete($_POST['id']);
            $_SESSION['good'] = 'Visit info deleted';
        }
        else{
            unset($_SESSION['error']);
            $_SESSION['error'] = 'Visit info not found';
        }

        header('Location: ../Deletevisitinfo');
    }
}