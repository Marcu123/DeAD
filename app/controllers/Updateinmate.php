<?php

class Updateinmate extends Controller
{
    public function index()
    {
        session_start();
        if (!isset($_SESSION['username_adm'])) {
            header('Location: adminlog');
        }
        $this->view('updateinmate');
    }
    public function update(){
        $this->model('admin');
        $this->model('inmate');
        $this->model('prison');

        $criteria = [];

        foreach ($_POST as $key => $value) {
            if(strlen($value) != 0){
                if(strcmp($key, 'prisoner-cnp') != 0){
                    $criteria[$key] = $value;
                }
            } 
        }

        $cnp = $_POST['prisoner-cnp'];

        $inmateService = new InmateService();
        $adminService  = new AdminService();

        $prisonID = $adminService->getPrisonIdByUsername($_SESSION['username_adm']);
        $inmateService = new InmateService();
        $inmate = $inmateService->getInmateByCnp($cnp);
        //check for same prison
        if($prisonID == $inmateService->getInmatePrisonId($inmate->getId())){
            if(count($criteria) != 0){
                $this->model('inmate');
                $this->model('prison');
                $iService = new InmateService();

                $iService->updateByCriteria($cnp, $criteria);
            }
        }
        header('Location: ../UpdateInmate');
    }
}