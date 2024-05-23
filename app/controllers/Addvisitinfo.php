<?php

class Addvisitinfo extends Controller
{
    public function index()
    {
        $this->view('addvisitinfo');
    }

    public function add(){
        $this->model('SeeVisitinfo');
        $this->model('Inmate');

        $visitInfo = new Visitinfo(0, $_POST['request-id'],
                                    $_POST['prisoner-cnp'],
                                    $_POST['objects'],
                                    $_POST['conversation'],
                                    $_POST['health'],
                                    $_POST['mood'],
                                    explode(", ", $_POST['witness']));
        $vService = new VisitInfoService();
        $vService->create($visitInfo);
    }
}