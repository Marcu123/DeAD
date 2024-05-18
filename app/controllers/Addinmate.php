<?php

class Addinmate extends Controller
{
    public function index()
    {
        $this->view('addinmate');
    }

    public function add(){
        $this->model('inmate');
        $inmate = new Inmate(0, 
        'test', 
        $_GET['first_name'], 
        $_GET['last_name'],
        $_GET['prisoner-cnp'],
        $_GET['age'],
        $_GET['gender'],
        0,
        $_GET['date'],
        $_GET['end'],
        $_GET['crime']);

        $inmateService = new InmateService();
        $inmateService->addInmate($inmate);

        header('Location: ../Addinmate');
    }
}