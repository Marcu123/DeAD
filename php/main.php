<?php
@require_once 'InmateDAO.php';
@require_once 'Inmate.php';

$dbHost = 'localhost';
$dbName = 'DeAD';
$dbUser = 'postgres';
$dbPass = 'marcu';

try {
    $pdo = new PDO("pgsql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $filePath = 'C:\xampp\htdocs\DeAD\php\inmate_photos\ion_popescu.png';
    $imageData = file_get_contents($filePath);
    $inmateDAO = new InmateDAO($pdo);
    $inmate = new Inmate($imageData,'ion', 'popescu', '12345290123', 23, 'M', 1, '2020-01-01', '2020-01-01', 'furt');

    $inmateDAO->addInmate($inmate);
    $inmateDAO->getInmateById(1);

    echo $inmateDAO->getInmateById(1)->__toString();
} catch (PDOException $e) {
    die("Error with database" . $e->getMessage());
}
