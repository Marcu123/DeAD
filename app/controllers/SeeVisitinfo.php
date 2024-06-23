<?php
session_start();
class SeeVisitinfo extends Controller
{
    public function index()
    {
        if(isset($_GET['id'])){
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
        } else if(isset($_GET['username'])){
            $this->model('visitinfo');
            $this->model('inmate');
            $this->model('prison');
            $this->model('witness');
            $this->model('visitor');
            $this->model('employee');
            $this->model('user');
            $this->model('request');

            $userService  = new UserService();
            $cnp = $userService->getCNPByUsername($_SESSION['username']);

            $requestService = new RequestService();
            $requestArray = $requestService->getAllRequestsByVisitorCnp($cnp);

            $viService = new VisitInfoService();
            $visitInfo = array();
            foreach($requestArray as $request){
                $visit = $viService->getVisitInfoByRequestID($request->getId());
                if(!is_null($visit))
                    $visitInfo[] = $viService->getVisitInfoByRequestID($request->getId());
            }

            $this->view('visitinfouser', $visitInfo);
        }
        else $this->view('seevisitinfo');
    }
}