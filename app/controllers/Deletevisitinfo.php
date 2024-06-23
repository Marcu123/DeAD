<?php

class Deletevisitinfo extends Controller
{
    public function index()
    {
        $this->view('deletevisitinfo');
    }
    public function delete(){
        $this->model('visitinfo');
        $this->model('admin');
        $this->model('inmate');
        $this->model('prison');

        $visitInfoService = new VisitInfoService();
        $adminService = new AdminService();
        $prisonService = new PrisonService();

        $prisonID = $adminService->getPrisonIdByUsername($_SESSION['username_adm']);

        if($prisonID == $prisonService->getPrisonIdByRequestId($_POST['id']))
            $visitInfoService->delete($_POST['id']);

        header('Location: ../Deletevisitinfo');
    }
}