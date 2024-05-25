<?php

class Addinmate extends Controller
{
    public function index()
    {
        session_start();
        if (!isset($_SESSION['username_adm'])) {
            header('Location: adminlog');
        }
        $this->view('addinmate');
        unset($_SESSION['error']);
        unset($_SESSION['good']);
    }

    public function add(){
        session_start();
        $this->model('inmate');
        $this->model('prison');

        $pService = new PrisonService();
        $prisonID = $pService->getIdByName($_SESSION['prison_name']);

        $inmate = new Inmate(0, 
        'test', 
        $_GET['first_name'], 
        $_GET['last_name'],
        $_GET['prisoner-cnp'],
        $_GET['age'],
        $_GET['gender'],
        $prisonID,
        $_GET['date'],
        $_GET['end'],
        $_GET['crime']);

        $inmateService = new InmateService();
        $result = $inmateService->addInmate($inmate);
        //cnp check
        if($result === 2){

            $_SESSION['error'] = 'Invalid CNP format';
            header('Location: ../Addinmate');
            return;
        }

        //exists check
        if($result === 0){
            file_put_contents('debug.txt', "bun", FILE_APPEND);
            $_SESSION['good'] = 'Inmate added successfully';

        }
        else if($result === 1){
            file_put_contents('debug.txt', "exista", FILE_APPEND);
            $_SESSION['error'] = 'CNP is already in use';
        }
        header('Location: ../Addinmate');
    }
}