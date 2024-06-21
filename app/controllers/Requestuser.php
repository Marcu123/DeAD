<?php

class Requestuser extends Controller
{
    public function index()
    {
        session_start();
        if (!isset($_SESSION['username'])) {
            header('Location: userlog');
        }
        $this->view('requestuser');
    }

    public function getRequests()
    {
        session_start();
        require_once '../app/services/RequestService.php';
        require_once '../app/services/VisitorService.php';
        $requestService = new RequestService();
        $visitorService = new VisitorService();

        $requests = $requestService->getAllRequestsByVisitorCnp($_SESSION['cnp']);

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
                'cnp' => $_SESSION['cnp'],
                'email' => $_SESSION['email'],
                'phone_number' => $_SESSION['phone_number'],
                'inmate_name' => $request->getInmateName(),
                'inmate_cnp' => $request->getInmateCnp(),
                'photo' => 'http://localhost/DeAD/api/uploads/visitors/' . $this->findPhoto($_SESSION['cnp'])
            ];

            if (isset($visitorArray[2])) {
                $response['visitor1_name'] = $visitorService->getVisitorNameByCnp($visitorArray[2]);
                $response['visitor1_cnp'] = $visitorArray[2];
                $response['visitor1_email'] = $visitorService->getEmailByCnp($visitorArray[2]);
                $response['visitor1_phone'] = $visitorService->getPhoneNumberByCnp($visitorArray[2]);
                $response['visitor1_photo'] = 'http://localhost/DeAD/api/uploads/visitors/' . $this->findPhoto($visitorArray[2]);
            }

            if (isset($visitorArray[4])) {
                $response['visitor2_name'] = $visitorService->getVisitorNameByCnp($visitorArray[4]);
                $response['visitor2_cnp'] = $visitorArray[4];
                $response['visitor2_email'] = $visitorService->getEmailByCnp($visitorArray[4]);
                $response['visitor2_phone'] = $visitorService->getPhoneNumberByCnp($visitorArray[4]);
                $response['visitor2_photo'] = 'http://localhost/DeAD/api/uploads/visitors/' . $this->findPhoto($visitorArray[4]);
            }

            return $response;
        }, $requests);

        header('Content-Type: application/json');
        echo json_encode($requestsArray);
    }

    public function findPhoto($pkey)
    {
        $fileName = '../api/uploads/visitors/' . $pkey;
        if (file_exists($fileName . '.png'))
            return $pkey . '.png';
        else if (file_exists($fileName . '.webp'))
            return $pkey . '.webp';
        else if (file_exists($fileName . '.jpg'))
            return $pkey . '.jpg';
        else if (file_exists($fileName . '.jpeg'))
            return $pkey . '.jpeg';
        else if (file_exists($fileName . '.gif'))
            return $pkey . '.gif';
        else
            return null;
    }
}
