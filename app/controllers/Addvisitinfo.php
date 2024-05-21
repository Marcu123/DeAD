<?php

class Addvisitinfo extends Controller
{
    public function index()
    {
        $this->view('addvisitinfo');
    }

    public function add(){
        $this->model('Visitinfo');

        $visitInfo = new Visitinfo(0, $_POST['request-id'],
                                    $_POST['prisoner-cnp'],
                                    $_POST['objects'],
                                    $_POST['conversation'],
                                    $_POST['health'],
                                    $_POST['mood'],
                                    []);
        $vService = new VisitInfoService();
        $vService->create($visitInfo);
    }
}