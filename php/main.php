<?php
@require_once 'InmateDAO.php';
@require_once 'Inmate.php';
@require_once 'Database.php';
@require_once "dbconfig.php";

try{
    Database::setConfig(include('dbconfig.php'));

    $filePath = 'C:\xampp1\htdocs\DeAD\php\inmate_photos\ion_popescu.png';
    $imageData = file_get_contents($filePath);
    $inmateDAO = new InmateDAO();
    $inmate = new Inmate($imageData,'ion', 'popescu', '12345290123', 23, 'M', 1, '2020-01-01', '2020-01-01', 'furt');

    $inmateDAO->addInmate($inmate);
    $inmateDAO->getInmateById(1);

    echo $inmateDAO->getInmateById(1)->__toString();
} catch(Exception $e){
    echo $e->getMessage() . '\n';
}
