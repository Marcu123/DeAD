<?php
require_once "../app/services/InmateService.php";
require_once "../app/services/PrisonService.php";
require_once "../app/models/Prison.php";
class InmateController
{
    private $uri;
    public function __construct($uri){
        $this->uri = $uri;
    }
    public function getByCnp(){
        $inmateService = new InmateService();
        $inmate = $inmateService->getInmateByCnp($this->uri[4]);

        if(is_null($inmate)){
            header('HTTP/1.0 400 Bad Request');
            echo 'No inmate found';
            exit;
        }

        $response = array();

        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['content_type_header'] = 'Content-Type: application/json';
        $response['body'] = json_encode([
            'id' => $inmate->getId(),
            //'photo' => $inmate->getPhoto(),
            'firstName' => $inmate->getFirstName(),
            'lastName' => $inmate->getLastName(),
            'cnp' => $inmate->getCnp(),
            'age' => $inmate->getAge(),
            'gender' => $inmate->getGender(),
            'idPrison' => $inmate->getIdPrison(),
            'dateOfIncarceration' => $inmate->getDateOfIncarceration(),
            'endOfIncarceration' => $inmate->getEndOfIncarceration(),
            'crime' => $inmate->getCrime()
        ]);

        header($response['status_code_header']);
        header($response['content_type_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    public function delete(array $uri, $type, $username)
    {
        //add check for admin
        require_once "../app/services/AdminService.php";

        $inmateService = new InmateService();
        $inmate = $inmateService->getInmateByCnp($this->uri[4]);

        if(is_null($inmate)){
            header('HTTP/1.0 400 Bad Request');
            echo 'No inmate found';
            exit;
        }

        $adminService = new AdminService();
        $prisonID = $adminService->getPrisonIdByUsername($username);

        //check for same prison
        if($prisonID != $inmateService->getInmatePrisonId($inmate->getId())){
            header('HTTP/1.0 400 Bad Request');
            echo 'Different prison';
            exit;
        }

        $inmateService->deleteInmate($this->uri[4]);

        $response = array();

        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['content_type_header'] = 'Content-Type: application/json';
        $response['body'] = json_encode([
            'message' => "Inmate deleted"
        ]);

        header($response['status_code_header']);
        header($response['content_type_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    public function create($type, $username)
    {
        require_once "../app/services/AdminService.php";
        $data = json_decode(file_get_contents("php://input"), true);

        if (isset($_POST['firstName'])) {
            $firstName = $_POST['firstName'];
        } else {
            $this->notEnoughParams();
            exit;
        }

        if (isset($_POST['lastName'])) {
            $lastName = $_POST['lastName'];
        } else {
            $this->notEnoughParams();
            exit;
        }

        if (isset($_POST['cnp'])) {
            $cnp = $_POST['cnp'];
        } else {
            $this->notEnoughParams();
            exit;
        }

        if (isset($_POST['age'])) {
            $age = $_POST['age'];
        } else {
            $this->notEnoughParams();
            exit;
        }

        if (isset($_POST['gender'])) {
            $gender = $_POST['gender'];
        } else {
            $this->notEnoughParams();
            exit;
        }

        if (isset($_POST['dateOfIncarceration'])) {
            $dateOfIncarceration = $_POST['dateOfIncarceration'];
        } else {
            $this->notEnoughParams();
            exit;
        }

        if (isset($_POST['endOfIncarceration'])) {
            $endOfIncarceration = $_POST['endOfIncarceration'];
        } else {
            $this->notEnoughParams();
            exit;
        }

        if (isset($_POST['crime'])) {
            $crime = $_POST['crime'];
        } else {
            $this->notEnoughParams();
            exit;
        }

        $adminService = new AdminService();

        $prisonID = $adminService->getPrisonIdByUsername($username);

        $inmate = new Inmate(0,
        'ceva',
        $firstName,
        $lastName,
        $cnp,
        $age,
        $gender,
        $prisonID,
        $dateOfIncarceration,
        $endOfIncarceration,
        $crime);

        $inmateService = new InmateService();
        $inmateService->addInmate($inmate);

        include_once "PhotoController.php";
        $photoController = new PhotoController();
        $photoController->processRequest($cnp, 'inmate');

        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['content_type_header'] = 'Content-Type: application/json';
        $response['body'] = json_encode([
            'message' => "Inmate added"
        ]);

        header($response['status_code_header']);
        header($response['content_type_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function notEnoughParams()
    {
        header('HTTP/1.0 400 Bad Request');
        echo 'Not enough params';
        exit;
    }

    public function update(array $uri, $type, $username)
    {
        $cnp = $uri[4];

        require_once "../app/services/AdminService.php";
        $data = json_decode(file_get_contents("php://input"), true);

        $criteria = array();
        if(isset($data['firstName'])){
            $criteria['first_name'] = $data['firstName'];
        }
        if(isset($data['lastName'])){
            $criteria['last_name'] = $data['lastName'];
        }
        if(isset($data['cnp'])){
            $criteria['cnp'] = $data['cnp'];
        }
        if(isset($data['age'])){
            $criteria['age'] = $data['age'];
        }
        if(isset($data['gender'])){
            $criteria['gender'] = $data['gender'];
        }
        if(isset($data['dateOfIncarceration'])){
            $criteria['date_of_incarceracion'] = $data['dateOfIncarceration'];
        }
        if(isset($data['endOfIncarceration'])){
            $criteria['end_of_incarceration'] = $data['endOfIncarceration'];
        }
        if(isset($data['crime'])){
            $criteria['crime'] = $data['crime'];
        }

        $adminService = new AdminService();

        $criteria['id_prison'] = $adminService->getPrisonIdByUsername($username);

        $inmateService = new InmateService();
        $inmateService->updateByCriteria($cnp, $criteria);

        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['content_type_header'] = 'Content-Type: application/json';
        $response['body'] = json_encode([
            'message' => "Inmate updated"
        ]);

        header($response['status_code_header']);
        header($response['content_type_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    public function search(array $uri)
    {
        require_once "../app/services/AdminService.php";
        $data = json_decode(file_get_contents("php://input"), true);

        $criteria = array();
        if(isset($_GET['firstName'])){
            $criteria['first_name'] = $_GET['firstName'];
        }
        if(isset($_GET['lastName'])){
            $criteria['last_name'] = $_GET['lastName'];
        }
        if(isset($_GET['cnp'])){
            $criteria['cnp'] = $_GET['cnp'];
        }
        if(isset($_GET['age'])){
            $criteria['age'] = $_GET['age'];
        }
        if(isset($_GET['gender'])){
            $criteria['gender'] = $_GET['gender'];
        }
        if(isset($_GET['dateOfIncarceration'])){
            $criteria['date_of_incarceracion'] = $_GET['dateOfIncarceration'];
        }
        if(isset($_GET['endOfIncarceration'])){
            $criteria['end_of_incarceration'] = $_GET['endOfIncarceration'];
        }
        if(isset($_GET['crime'])){
            $criteria['crime'] = $_GET['crime'];
        }
        if(isset($_GET['prison'])){
            $criteria['prison'] = $_GET['prison'];
        }

        $adminService = new AdminService();

        $inmateService = new InmateService();
        $inmates = $inmateService->getInmatesByCriteria($criteria);

        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['content_type_header'] = 'Content-Type: application/json';
        $inmatesArray = array_map(function($inmate) {

            return [
                'id' => $inmate->getId(),
                'photo' => 'http://localhost/DeAD/api/uploads/inmates/' . $inmate->getCnp() . '.webp',
                'firstName' => $inmate->getFirstName(),
                'lastName' => $inmate->getLastName(),
                'cnp' => $inmate->getCnp(),
                'age' => $inmate->getAge(),
                'gender' => $inmate->getGender(),
                'prison' => $inmate->getIdPrison(),
                'dateOfIncarceration' => $inmate->getDateOfIncarceration(),
                'endOfIncarceration' => $inmate->getEndOfIncarceration(),
                'crime' => $inmate->getCrime()
            ];
        }, $inmates);

        $response['body'] = json_encode($inmatesArray);

        header($response['status_code_header']);
        header($response['content_type_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }


}