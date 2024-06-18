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

                    $requestService = new RequestService();

                    $requests=$requestService->getAllRequestsByPrisonId($this->username);
                    if(!$requests){

                        header('HTTP/1.0 400 Bad Request');
                        echo 'No request found';
                        exit;
                    }
                    $requestsArray = array_map(function($request) use ($requestService) {

                        return [
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
                            'inmate_cnp' => $request->getInmateCnp()
                        ];
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

                    $userService = new UserService();
                    $requestService = new RequestService();

                    $requests=$requestService->getAllRequestsByVisitorCnp($userService->getCNPByUsername($this->username));
                    if(!$requests){

                        header('HTTP/1.0 400 Bad Request');
                        echo 'No request found';
                        exit;
                    }
                    $requestsArray = array_map(function($request) use ($userService) {

                        return [
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
                            'inmate_cnp' => $request->getInmateCnp()
                        ];
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

                $data = json_decode(file_get_contents("php://input"), true);
                $requestService = new RequestService();
                $userService = new UserService();
                $request = new RequestM();
                $inmateService = new InmateService();

                $request->setVisitorType($data['visitor_type']);
                $request->setVisitType($data['visit_type']);
                $request->setDateOfVisit($data['date_of_visit']);

                $inmateCnp = $data['inmate_cnp'];
                $inmate_id = $inmateService->getInmateIdByCNP($inmateCnp);
                $request->setIdInmate($inmate_id);
                $request->setVisitorName($data['visitor_name']);
                $request->setStatus('pending');
                $request->setRequestCreated(date('Y-m-d H:i:s'));
                $request->setPrisonId($inmateService->getInmatePrisonId($inmate_id));

                $visitor = new Visitor();
                $visitor1 = new Visitor();
                $visitor2 = new Visitor();

                $visitor->setVisitorName($data['visitor_name']);
                $visitor->setCnp($data['cnp']);
                $visitor->setEmail($data['email']);
                $visitor->setPhoneNumber($data['phone_number']);

                $visitorsNr= $data['visitors_nr'];
                if($visitorsNr>3){
                    header('HTTP/1.0 400 Bad Request');
                    echo 'Too many visitors';
                    exit;
                }

                if(isset($data['visitor1_name']) && $data['visitor1_name'] !== ""){
                    $visitor1->setVisitorName($data['visitor1_name']);
                    $visitor1->setCnp($data['cnp1']);
                    $visitor1->setEmail($data['email1']);
                    $visitor1->setPhoneNumber($data['phone_number1']);
                }

                if(isset($data['visitor2_name']) && $data['visitor2_name'] !== ""){
                    $visitor2->setVisitorName($data['visitor2_name']);
                    $visitor2->setCnp($data['cnp2']);
                    $visitor2->setEmail($data['email2']);
                    $visitor2->setPhoneNumber($data['phone_number2']);
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

                $visitorService = new VisitorService();
                $visitorService->addVisitor($visitor);
                if ($visitor1->getVisitorName() != "") {
                    $visitorService->addVisitor($visitor1);
                } else if ($visitor2->getVisitorName() != "") {
                    $visitorService->addVisitor($visitor2);
                    $visitorService->addVisitor($visitor2);
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


}