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
        $_POST['first_name'],
            $_POST['last_name'],
            $_POST['prisoner-cnp'],
            $_POST['age'],
            $_POST['gender'],
        $prisonID,
            $_POST['date'],
            $_POST['end'],
            $_POST['crime']);

        $inmateService = new InmateService();
        $result = $inmateService->addInmate($inmate);
        $prisonerCNP = $_POST['prisoner-cnp'];
        //cnp check
        if($result === 2){

            $_SESSION['error'] = 'Invalid CNP format';
            header('Location: ../Addinmate');
            return;
        }

        //exists check
        if($result === 0){
            file_put_contents('debug.txt', "bun", FILE_APPEND);
            include_once "../api/PhotoController.php";
            $photoController = new PhotoController();
            file_put_contents("dada.txt", $_SERVER['REQUEST_METHOD']. "    " .print_r($_FILES,true), FILE_APPEND);

            $photoController->processRequestFront($prisonerCNP, 'inmate');

            $_SESSION['inmates_nr']++;
            $_SESSION['good'] = 'Inmate added successfully';

        }
        else if($result === 1){
            file_put_contents('debug.txt', "exista", FILE_APPEND);
            $_SESSION['error'] = 'CNP is already in use';
        }
        header('Location: ../Addinmate');
    }
}