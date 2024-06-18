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

        if(isset($data['firstName'])){
            $firstName = $data['firstName'];
        } else {
            $this->notEnoughParams();
            exit;
        }
        if(isset($data['lastName'])){
            $lastName = $data['lastName'];
        } else {
            $this->notEnoughParams();
            exit;
        }
        if(isset($data['cnp'])){
            $cnp = $data['cnp'];
        } else {
            $this->notEnoughParams();
            exit;
        }
        if(isset($data['age'])){
            $age = $data['age'];
        } else {
            $this->notEnoughParams();
            exit;
        }
        if(isset($data['gender'])){
            $gender = $data['gender'];
        } else {
            $this->notEnoughParams();
            exit;
        }
        if(isset($data['dateOfIncarceration'])){
            $dateOfIncarceration = $data['dateOfIncarceration'];
        } else {
            $this->notEnoughParams();
            exit;
        }
        if(isset($data['endOfIncarceration'])){
            $endOfIncarceration = $data['endOfIncarceration'];
        } else {
            $this->notEnoughParams();
            exit;
        }
        if(isset($data['crime'])){
            $crime = $data['crime'];
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


}