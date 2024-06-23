<?php

class Addvisitinfo extends Controller
{
    public function index()
    {
        session_start();
        if (!isset($_SESSION['username_adm'])) {
            header('Location: adminlog');
        }
        $this->view('addvisitinfo');
    }

    public function add(){
        session_start();
        $this->model('visitinfo');
        $this->model('Inmate');

        include_once "../app/services/RequestService.php";
        $rService = new RequestService();
        if(!$rService->existsRequestById($_POST['request-id'])){
            $_SESSION['error'] = 'Request not found';
            header('Location: ../Addvisitinfo');
            return;
        }
        $visitInfo = new Visitinfo(0, $_POST['request-id'],
                                    $_POST['prisoner-cnp'],
                                    $_POST['objects'],
                                    $_POST['conversation'],
                                    $_POST['health'],
                                    $_POST['mood'],
                                    explode(", ", $_POST['witness']));
        $vService = new VisitInfoService();
        $vService->create($visitInfo);
        $_SESSION['good'] = 'Visit info added';
        header('Location: ../Addvisitinfo');
    }
}