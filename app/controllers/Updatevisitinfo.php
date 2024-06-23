<?php

class Updatevisitinfo extends Controller
{
    public function index()
    {
        session_start();
        if (!isset($_SESSION['username_adm'])) {
            header('Location: adminlog');
        }
        $this->view('updatevisitinfo');
    }

    public function update(){
        session_start();
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
        include_once '../app/services/RequestService.php';
        $requestService = new RequestService();
        if(!$requestService->existsRequestById($requestID)){
            unset($_SESSION['error']);
            $_SESSION['error'] = 'Visit info not found';
            header('Location: ../UpdateVisitInfo');
            return;
        }

        if($prisonID == $prisonService->getPrisonIdByRequestId($requestID))

        if(count($criteria) != 0){
            $viService = new VisitInfoService();

            if($prisonID == $prisonService->getPrisonIdByRequestId($requestID)) {
                $viService->updateByCriteria($requestID, $criteria);
                $_SESSION['good'] = 'Visit info updated';
            }
            else{
                unset($_SESSION['error']);
                $_SESSION['error'] = 'Visit info not found';
            }

            header('Location: ../UpdateVisitInfo');
        }
    }
}