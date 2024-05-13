<?php

class SearchPage extends Controller { 
    public function index($name = ''){
        /*$user = $this->model('Home');
        $user->name = $name;
        
        $this->view('home/index', ['name' => $user->name]);

        echo $user->name;*/
        $this->view('searchpage');

    }
    public function getInfo(){
        if(isset($_GET['prisoner-cnp'])){
            $cnp = $_GET['prisoner-cnp'];

            $this->model('inmate');
            $iService = new InmateService();

            $inmate = $iService->getInmateByCnp($cnp);

            $this->view('inmateprofile', $inmate);
        }
    }

}