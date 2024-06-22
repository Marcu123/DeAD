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
    public function seeUser(){
        $this->model('visitinfo');
        $this->model('inmate');
        $this->model('prison');
        $this->model('witness');
        $this->model('visitor');
        $this->model('employee');
        $this->model('user');

        $userService  = new UserService();
        $cnp = $userService->getCNPByUsername($_SESSION['username']);

        $requestService = new RequestService();
        $requestArray = $requestService->getAllRequestsByVisitorCnp($cnp);

        $viService = new VisitInfoService();
        $visitInfo = array();
        foreach($requestArray as $request){
            $visitInfo[] = $viService->getVisitInfoByRequestID($request->getId());
        }

        $this->view('visitinfouser', $visitInfo);
    }
}