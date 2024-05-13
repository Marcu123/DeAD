<?php

class Inmateprofile extends Controller
{
    public function index()
    {
        if(isset($_GET['prisoner-cnp'])){
            $cnp = $_GET['prisoner-cnp'];

            $this->model('inmate');
            $iService = new InmateService();

            $inmate = $iService->getInmateByCnp($cnp);

            $this->view('inmateprofile', ['inmate' => $inmate]);
        }
    }
}