<?php

class Deleteinmate extends Controller
{
    public function index()
    {
        session_start();
        if (!isset($_SESSION['username_adm'])) {
            header('Location: adminlog');
        }
        $this->view('deleteinmate');
    }
    public function delete(){
        $this->model('inmate');
        $inmateService = new InmateService();
        $inmateService->deleteInmate($_POST['cnp']);

        header('Location: ../Deleteinmate');
    }
}