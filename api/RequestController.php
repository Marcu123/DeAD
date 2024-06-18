<?php

class RequestController
{
    private $db;
    private $request_method;

    private $type;
    private $username;

    public function __construct($db, $request_method, $type,$username)
    {
        $this->db = $db;
        $this->request_method = $request_method;
        $this->type = $type;
        $this->username = $username;
    }

    public function processRequest()
    {
        if($this->type==="admin"){
            echo "da";
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

                case 'POST':

                default:
                    return $this->notFoundResponse();
            }
        }
        else{
            $this->notFoundResponse();
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