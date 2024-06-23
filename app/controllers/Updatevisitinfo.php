<?php

class Updatevisitinfo extends Controller
{
    public function index()
    {
        $this->view('updatevisitinfo');
    }

    public function update(){
        $this->model('visitinfo');
        $this->model('admin');
        $this->model('inmate');
        $this->model('prison');

        $adminService = new AdminService();
        $prisonService = new PrisonService();

        $criteria = [];

        foreach ($_POST as $key => $value) {
            if(strlen($value) != 0){
                if(strcmp($key, 'id') != 0){
                    $criteria[$key] = $value;
                }
            }
        }

        $requestID = $_POST['id'];
        $prisonID = $adminService->getPrisonIdByUsername($_SESSION['username_adm']);

        if($prisonID == $prisonService->getPrisonIdByRequestId($requestID))

        if(count($criteria) != 0){
            $viService = new VisitInfoService();

            if($prisonID == $prisonService->getPrisonIdByRequestId($requestID))
                $viService->updateByCriteria($requestID, $criteria);

            header('Location: ../UpdateVisitInfo');
        }
    }
}