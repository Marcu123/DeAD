<?php

class Inmateprofile extends Controller
{
    public function index()
    {
        session_start();
        $inmates = [];

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

                $inmates = $iService->getInmatesByCriteria($criteria);

                $this->view('inmateprofile', $inmates);
            }
        }
}