<?php

class Deleteinmate extends Controller
{
    public function index()
    {
        $this->view('deleteinmate');
    }
    public function delete(){
        $this->model('inmate');
        $inmateService = new InmateService();
        $inmateService->deleteInmate($_POST['cnp']);

        header('Location: ../Deleteinmate');
    }
}