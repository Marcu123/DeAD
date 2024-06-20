<?php

class RequestController
{
    private $db;
    private $request_method;
    private $type;
    private $username;
    private $uri;

    public function __construct($db, $request_method, $type,$username,$uri)
    {
        $this->db = $db;
        $this->request_method = $request_method;
        $this->type = $type;
        $this->username = $username;
        $this->uri = $uri;
    }

    public function processRequest()
    {
        if($this->type==="admin"){
            switch ($this->request_method) {
                case 'PUT':
                    require_once "../app/services/RequestService.php";
                    require_once "../app/services/UserService.php";

                    $data = json_decode(file_get_contents("php://input"), true);
                    if($data['status'] !== 'accepted' && $data['status'] !== 'denied'){
                        header('HTTP/1.0 400 Bad Request');
                        echo 'Invalid status';
                        exit;
                    }
                    $requestService = new RequestService();

                    if ($request = $requestService->updateStatus($this->uri[4],$data['status'])) {
                        $email = $requestService->getEmailByRequestId($this->uri[4]);
                        $inmateName = $requestService->getInmateNameByRequestId($this->uri[4]);
                        $to = $email;
                        $subject = 'Request status updated';
                        $message = 'Your request for ' . $inmateName . ' has been ' . $data['status'] . ' by the admin. You can visit him/her on ' . $requestService->getDateOfVisitByRequestId($this->uri[4]);
                        $headers = array(
                            'From' => 'marcugames03@gmail.com',
                            'Reply-To' => 'marcugames03@gmail.com',
                        );

                        mail($to, $subject, $message, $headers);
                        echo json_encode(['success' => true]);
                    } else {
                        echo json_encode(['success' => false, 'error' => 'Failed to update request status']);
                    }
                    if(!$request){
                        header('HTTP/1.0 400 Bad Request');
                        echo 'No request found';
                        exit;
                    }

                    $response['status_code_header'] = 'HTTP/1.1 200 OK';
                    $response['content_type_header'] = 'Content-Type: application/json';
                    $response['body'] = json_encode([
                        'message' => 'Request updated'
                    ]);

                    header($response['status_code_header']);
                    header($response['content_type_header']);
                    if ($response['body']) {
                        echo $response['body'];
                    }
                    break;
                case 'GET':
                    require_once "../app/services/RequestService.php";
                    require_once "../app/services/UserService.php";
                    require_once "../app/services/VisitorService.php";

                    $requestService = new RequestService();
                    $visitorService = new VisitorService();

                    $requests=$requestService->getAllRequestsByPrisonId($this->username);
                    if(!$requests){

                        header('HTTP/1.0 400 Bad Request');
                        echo 'No request found';
                        exit;
                    }
                    $requestsArray = array_map(function($request) use ($visitorService, $requestService) {
                        $visitorArray = $visitorService->findVisitorsCnpsByRequestId($request->getId());

                        $response = [
                            'id' => $request->getId(),
                            'visitor_type' => $request->getVisitorType(),
                            'visit_type' => $request->getVisitType(),
                            'date_of_visit' => $request->getDateOfVisit(),
                            'status' => $request->getStatus(),
                            'id_inmate' => $request->getIdInmate(),
                            'visitor_name' => $request->getVisitorName(),
                            'request_created' => $request->getRequestCreated(),
                            'cnp' => $requestService->getCnpByVisitorName($request->getVisitorName()),
                            'email' => $requestService->getEmailByVisitorName($request->getVisitorName()),
                            'phone_number' => $requestService->getPhoneNumberByVisitorName($request->getVisitorName()),
                            'inmate_name' => $request->getInmateName(),
                            'inmate_cnp' => $request->getInmateCnp(),
                            'photo' => 'http://localhost/DeAD/api/uploads/visitors/' . $this->findPhoto($requestService->getCnpByVisitorName($request->getVisitorName()))
                        ];

                        if (isset($visitorArray[2])) {
                            $response['visitor1_name'] = $visitorService->getVisitorNameByCnp($visitorArray[2]);
                            $response['visitor1_cnp'] = $visitorArray[2];
                            $response['visitor1_email'] = $visitorService->getEmailByCnp($visitorArray[2]);
                            $response['visitor1_phone'] = $visitorService->getPhoneNumberByCnp($visitorArray[2]);
                            $response['visitor1_photo'] = 'http://localhost/DeAD/api/uploads/visitors/' . $this->findPhoto($visitorArray[2]);
                        }

                        if(isset($visitorArray[4])){
                            $response['visitor2_name'] = $visitorService->getVisitorNameByCnp($visitorArray[4]);
                            $response['visitor2_cnp'] = $visitorArray[4];
                            $response['visitor2_email'] = $visitorService->getEmailByCnp($visitorArray[4]);
                            $response['visitor2_phone'] = $visitorService->getPhoneNumberByCnp($visitorArray[4]);
                            $response['visitor2_photo'] = 'http://localhost/DeAD/api/uploads/visitors/' . $this->findPhoto($visitorArray[4]);
                        }

                        return $response;
                    }, $requests);


                    if(!$requestsArray){
                        $response = $this->notFoundResponse();
                        return $response;
                    }

                    $response['status_code_header'] = 'HTTP/1.1 200 OK';
                    $response['content_type_header'] = 'Content-Type: application/json';
                    $response['body'] = json_encode([
                        'requests' => $requestsArray
                    ]);

                    header($response['status_code_header']);
                    header($response['content_type_header']);
                    if ($response['body']) {
                        echo $response['body'];
                    }
                    break;
                    default:
                        header('HTTP/1.0 400 Bad Request');
            }


        }
        else if($this->type==="user"){
            switch ($this->request_method) {
                case 'GET':
                    require_once "../app/services/UserService.php";
                    require_once "../app/services/RequestService.php";
                    require_once "../app/services/VisitorService.php";

                    $userService = new UserService();
                    $requestService = new RequestService();
                    $visitorService = new VisitorService();

                    $requests=$requestService->getAllRequestsByVisitorCnp($userService->getCNPByUsername($this->username));
                    if(!$requests){

                        header('HTTP/1.0 400 Bad Request');
                        echo 'No request found';
                        exit;
                    }
                    $requestsArray = array_map(function($request) use ($visitorService, $userService) {
                        $visitorArray = $visitorService->findVisitorsCnpsByRequestId($request->getId());

                        $response = [
                            'id' => $request->getId(),
                            'visitor_type' => $request->getVisitorType(),
                            'visit_type' => $request->getVisitType(),
                            'date_of_visit' => $request->getDateOfVisit(),
                            'status' => $request->getStatus(),
                            'id_inmate' => $request->getIdInmate(),
                            'visitor_name' => $request->getVisitorName(),
                            'request_created' => $request->getRequestCreated(),
                            'cnp' => $userService->getCNPByUsername($this->username),
                            'email' => $userService->getEmailByUsername($this->username),
                            'phone_number' => $userService->getPhoneByUsername($this->username),
                            'inmate_name' => $request->getInmateName(),
                            'inmate_cnp' => $request->getInmateCnp(),
                            'photo' => 'http://localhost/DeAD/api/uploads/visitors/' . $this->findPhoto($userService->getCNPByUsername($this->username))
                        ];

                        if (isset($visitorArray[2])) {
                            $response['visitor1_name'] = $visitorService->getVisitorNameByCnp($visitorArray[2]);
                            $response['visitor1_cnp'] = $visitorArray[2];
                            $response['visitor1_email'] = $visitorService->getEmailByCnp($visitorArray[2]);
                            $response['visitor1_phone'] = $visitorService->getPhoneNumberByCnp($visitorArray[2]);
                            $response['visitor1_photo'] = 'http://localhost/DeAD/api/uploads/visitors/' . $this->findPhoto($visitorArray[2]);
                        }

                        if(isset($visitorArray[4])){
                            $response['visitor2_name'] = $visitorService->getVisitorNameByCnp($visitorArray[4]);
                            $response['visitor2_cnp'] = $visitorArray[4];
                            $response['visitor2_email'] = $visitorService->getEmailByCnp($visitorArray[4]);
                            $response['visitor2_phone'] = $visitorService->getPhoneNumberByCnp($visitorArray[4]);
                            $response['visitor2_photo'] = 'http://localhost/DeAD/api/uploads/visitors/' . $this->findPhoto($visitorArray[4]);
                        }

                        return $response;
                    }, $requests);

                    if(!$requestsArray){
                        $response = $this->notFoundResponse();
                        return $response;
                    }

                    $response['status_code_header'] = 'HTTP/1.1 200 OK';
                    $response['content_type_header'] = 'Content-Type: application/json';
                    $response['body'] = json_encode([
                        'requests' => $requestsArray
                    ]);

                    header($response['status_code_header']);
                    header($response['content_type_header']);
                    if ($response['body']) {
                        echo $response['body'];
                    }
                    break;

                default:
                    return $this->notFoundResponse();
            }
        }
        else{
            if($this->request_method ==='POST'){
                require_once "../app/services/RequestService.php";
                require_once "../app/services/UserService.php";
                require_once "../app/models/RequestM.php";
                require_once "../app/models/Visitor.php";
                require_once "../app/services/InmateService.php";
                require_once "../app/services/RequestService.php";
                require_once "../app/services/VisitorService.php";

                //$data = json_decode(file_get_contents("php://input"), true);
                $requestService = new RequestService();
                $userService = new UserService();
                $request = new RequestM();
                $inmateService = new InmateService();

                $request->setVisitorType($_POST['visitor_type']);
                $request->setVisitType($_POST['visit_type']);
                $request->setDateOfVisit($_POST['date_of_visit']);

                $inmateCnp = $_POST['inmate_cnp'];
                $inmate_id = $inmateService->getInmateIdByCNP($inmateCnp);
                $request->setIdInmate($inmate_id);
                $request->setVisitorName($_POST['visitor_name']);
                $request->setStatus('pending');
                $request->setRequestCreated(date('Y-m-d H:i:s'));
                $request->setPrisonId($inmateService->getInmatePrisonId($inmate_id));

                $visitor = new Visitor();
                $visitor1 = new Visitor();
                $visitor2 = new Visitor();

                $visitor->setVisitorName($_POST['visitor_name']);
                $visitor->setCnp($_POST['cnp']);
                $visitor->setEmail($_POST['email']);
                $visitor->setPhoneNumber($_POST['phone_number']);

                $visitorsNr= $_POST['visitors_nr'];
                if($visitorsNr>3){
                    header('HTTP/1.0 400 Bad Request');
                    echo 'Too many visitors';
                    exit;
                }

                if(isset($_POST['visitor1_name']) && $_POST['visitor1_name'] !== ""){
                    $visitor1->setVisitorName($_POST['visitor1_name']);
                    $visitor1->setCnp($_POST['cnp1']);
                    $visitor1->setEmail($_POST['email1']);
                    $visitor1->setPhoneNumber($_POST['phone_number1']);
                }

                if(isset($_POST['visitor2_name']) && $_POST['visitor2_name'] !== ""){
                    $visitor2->setVisitorName($_POST['visitor2_name']);
                    $visitor2->setCnp($_POST['cnp2']);
                    $visitor2->setEmail($_POST['email2']);
                    $visitor2->setPhoneNumber($_POST['phone_number2']);
                }

                if ($requestService->addRequest($request)) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Failed to create request']);
                }

                $visitorName = $visitor->getVisitorName();
                $request_id = $requestService->getRequestIdByVisitorName($visitorName);
                $visitor->setIdRequest($request_id);
                $visitor1->setIdRequest($request_id);
                $visitor2->setIdRequest($request_id);

                include_once "PhotoController.php";
                $photoController = new PhotoController();

                $visitorService = new VisitorService();
                $visitorService->addVisitor($visitor);
                $photoController->processRequest($visitor->getCnp(), 'visitor');

                if ($visitor1->getVisitorName() != "") {
                    $visitorService->addVisitor($visitor1);
                    $photoController->processRequest($visitor1->getCnp(), 'visitor', 1);
                } else if ($visitor2->getVisitorName() != "") {
                    $visitorService->addVisitor($visitor2);
                    $photoController->processRequest($visitor2->getCnp(), 'visitor', 2);
                }



                $response['status_code_header'] = 'HTTP/1.1 200 OK';
                $response['content_type_header'] = 'Content-Type: application/json';
                $response['body'] = json_encode([
                    'message' => 'Request created'
                ]);

                header($response['status_code_header']);
                header($response['content_type_header']);
                if ($response['body']) {
                    echo $response['body'];
                }
            }
            else{
                header('HTTP/1.0 400 Bad Request');
            }
        }

    }

    private function notFoundResponse() {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['content_type_header'] = 'Content-Type: application/json';
        $response['body'] = json_encode([
            'message' => 'Not Found'
        ]);
        return $response;
    }
    public function findPhoto($pkey){
        echo $pkey . " ";
        $fileName = 'uploads/visitors/' . $pkey;
        if(file_exists($fileName . '.png'))
            return $pkey . '.png';
        else if(file_exists($fileName . '.webp'))
            return $pkey . '.webp';
        else if(file_exists($fileName . '.jpg'))
            return $pkey . '.jpg';
        else if(file_exists($fileName . '.jpeg'))
            return $pkey . '.jpeg';
        else if(file_exists($fileName . '.gif'))
            return $pkey . '.gif';
        else
            return null;
    }

}