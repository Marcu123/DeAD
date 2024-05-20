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
        $this->model('inmate');

        $criteria = [];

        foreach ($_POST as $key => $value) {
            if(strlen($value) != 0){
                if(strcmp($key, 'prisoner-cnp') != 0){
                    $criteria[$key] = $value;
                }
            } 
        }

        $cnp = $_POST['prisoner-cnp'];

        if(count($criteria) != 0){
            $this->model('inmate');
            $this->model('prison');
            $iService = new InmateService();

            $iService->updateByCriteria($cnp, $criteria);

            header('Location: ../UpdateInmate');
        }
    }
}