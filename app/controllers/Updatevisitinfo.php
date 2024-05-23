<?php

class Updatevisitinfo extends Controller
{
    public function index()
    {
        $this->view('updatevisitinfo');
    }

    public function update(){
        $this->model('visitinfo');

        $criteria = [];

        foreach ($_POST as $key => $value) {
            if(strlen($value) != 0){
                if(strcmp($key, 'id') != 0){
                    $criteria[$key] = $value;
                }
            }
        }

        $requestID = $_POST['id'];

        if(count($criteria) != 0){
            $this->model('visitinfo');
            $viService = new VisitInfoService();

            $viService->updateByCriteria($requestID, $criteria);

            header('Location: ../UpdateVisitInfo');
        }
    }
}