<?php

class Inmateprofile extends Controller
{
    public function index()
    {
        $inmates = [];

        if(isset($_GET['prisoner-cnp']) && strlen($_GET['prisoner-cnp'] != 0)){
            $cnp = $_GET['prisoner-cnp'];

            $this->model('inmate');
            $this->model('prison');
            $iService = new InmateService();

            $inmate = $iService->getInmateByCnp($cnp);
            if(!is_null($inmate))
                $inmates[] = $inmate;

            $this->view('inmateprofile', $inmates);
        } else{
            $criteria = [];

            foreach ($_GET as $key => $value) {
                if(strlen($value) != 0){
                    if(strcmp($key, 'url') != 0){
                        $criteria[$key] = $value;
                    }
                } 
            }

            if(count($criteria) != 0){
                $this->model('inmate');
                $this->model('prison');
                $iService = new InmateService();

                $inmates = $iService->getInmateByCriteria($criteria);

                $this->view('inmateprofile', $inmates);
            }
        }
    }
}