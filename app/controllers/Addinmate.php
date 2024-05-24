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
        $result = $inmateService->addInmate($inmate);
        if($result==='rau'){
            file_put_contents('debug.txt', $result, FILE_APPEND);
            $_SESSION['error'] = 'Invalid CNP format';
            header('Location: ../Addinmate');
            return;
        }

        if($result){
            $_SESSION['good'] = 'Inmate added successfully';
        }
        else{
            $_SESSION['error'] = 'Inmate already exists';
        }
        header('Location: ../Addinmate');
    }
}