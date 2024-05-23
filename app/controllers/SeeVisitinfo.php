<?php

class SeeVisitinfo extends Controller
{
    public function index()
    {
        $this->view('seevisitinfo');
    }
    public function see(){
        $this->model('visitinfo');
        $this->model('inmate');
        $this->model('prison');
        $this->model('witness');
        $this->model('visitor');
        $this->model('employee');

        $requestID = $_GET['id'];

        $viService = new VisitInfoService();
        $visitInfo = $viService->getVisitInfoByRequestID($requestID);

        $this->view('visitinfo', ['visitInfo' => $visitInfo]);
    }
}