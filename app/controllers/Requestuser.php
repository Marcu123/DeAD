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
        $requestService = new RequestService();
        $requests = $requestService->getAllRequestsByVisitorCnp($_SESSION['cnp']);

        $requestsArray = array_map(function($request) {

            return [
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
                'inmate_cnp' => $request->getInmateCnp()
            ];
        }, $requests);

        header('Content-Type: application/json');
        echo json_encode($requestsArray);
    }


}