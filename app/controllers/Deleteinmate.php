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
        $this->model('admin');
        $this->model('inmate');
        $this->model('prison');

        $cnp = $_POST['cnp'];

        $inmateService = new InmateService();
        $adminService = new AdminService();

        $prisonID = $adminService->getPrisonIdByUsername($_SESSION['username_adm']);
        $inmate = $inmateService->getInmateByCnp($cnp);
        //check for same prison
        file_put_contents('debug.txt', $prisonID . "////" . $inmateService->getInmatePrisonId($inmate->getId()), FILE_APPEND);
        if($prisonID == $inmateService->getInmatePrisonId($inmate->getId())){
            if($inmateService->deleteInmate($cnp))
                $_SESSION['inmates_nr']--;
        }

        header('Location: ../Deleteinmate');
    }
}