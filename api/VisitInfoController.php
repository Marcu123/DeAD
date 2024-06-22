<?php
include_once "../app/services/VisitInfoService.php";
include_once "../app/services/RequestService.php";
include_once "../app/services/UserService.php";
class VisitInfoController
{

    public function search($username)
    {
        $userService = new UserService();
        $cnp = $userService->getCNPByUsername($username);

        $requestService = new RequestService();
        $requestArray = $requestService->getAllRequestsByVisitorCnp($cnp);

        $visitInfoService = new VisitInfoService();
        $visitInfoArray = array();
        foreach($requestArray as $request){
            $visitInfoArray[] = $visitInfoService->getVisitInfoByRequestID($request->getId());
        }

        $visitInfoArray = array_map(function($visitInfo) use ($userService) {
            include_once "PhotoController.php";
            $photoController = new PhotoController();

            $response = [
                'id' => $visitInfo->getId(),
                'request_id' => $visitInfo->getRequestID(),
                'inmate_cnp' => $visitInfo->getInmateCnp(),
                'objects_traded' => $visitInfo->getObjectsTraded(),
                'conversation_resume' => $visitInfo->getConversationResume(),
                'health_status' => $visitInfo->getHealthStatus(),
                'mood' => $visitInfo->getMood(),
            ];

            $visitorArray = $visitInfo->getWitnesses();

            if (isset($visitorArray[0])) {
                $witness = $visitorArray[0];
                if (strcmp($witness->getType(), 'visitor') == 0) {
                    $visitor = $witness->getVisitor();
                    $response['visitor1_type']  = 'visitor';
                    $response['visitor1_name']  =  $visitor->getVisitorName();
                    $response['visitor1_cnp']   = $visitor->getCnp();
                    $response['visitor1_email'] = $visitor->getEmail();
                    $response['visitor1_phone'] = $visitor->getPhoneNumber();
                    $response['visitor1_photo'] = 'http://localhost/DeAD/api/uploads/visitors/' . $photoController->findPhoto($visitorArray[0], 'visitors');
                } else { //employee
                    $visitor = $witness->getEmployee();
                    $response['visitor1_type']  = 'employee';
                    $response['visitor1_name'] =  $visitor->getVisitorName();
                    $response['visitor1_cnp'] = $visitor->getCnp();
                }
            }

            if (isset($visitorArray[1])) {
                $witness = $visitorArray[1];
                if (strcmp($witness->getType(), 'visitor') == 0) {
                    $visitor = $witness->getVisitor();
                    $response['visitor2_type']  = 'visitor';
                    $response['visitor2_name'] =  $visitor->getVisitorName();
                    $response['visitor2_cnp'] = $visitor->getCnp();
                    $response['visitor2_email'] = $visitor->getEmail();
                    $response['visitor2_phone'] = $visitor->getPhoneNumber();
                    $response['visitor2_photo'] = 'http://localhost/DeAD/api/uploads/visitors/' . $photoController->findPhoto($visitorArray[1], 'visitors');
                } else { //employee
                    $visitor = $witness->getEmployee();
                    $response['visitor2_type']  = 'employee';
                    $response['visitor2_name'] =  $visitor->getVisitorName();
                    $response['visitor2_cnp'] = $visitor->getCnp();
                }
            }

            if (isset($visitorArray[2])) {
                $witness = $visitorArray[2];
                if (strcmp($witness->getType(), 'visitor') == 0) {
                    $visitor = $witness->getVisitor();
                    $response['visitor3_type']  = 'visitor';
                    $response['visitor3_name'] =  $visitor->getVisitorName();
                    $response['visitor3_cnp'] = $visitor->getCnp();
                    $response['visitor3_email'] = $visitor->getEmail();
                    $response['visitor3_phone'] = $visitor->getPhoneNumber();
                    $response['visitor3_photo'] = 'http://localhost/DeAD/api/uploads/visitors/' . $photoController->findPhoto($visitorArray[2], 'visitors');
                } else { //employee
                    $visitor = $witness->getEmployee();
                    $response['visitor3_type']  = 'employee';
                    $response['visitor3_name'] =  $visitor->getVisitorName();
                    $response['visitor3_cnp'] = $visitor->getCnp();
                }
            }

            return $response;
        }, $visitInfoArray);

        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['content_type_header'] = 'Content-Type: application/json';
        $response['body'] = json_encode([
            'visits' => $visitInfoArray
        ]);

        header($response['status_code_header']);
        header($response['content_type_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }
}