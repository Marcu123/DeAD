<?php

class Requestadmin extends Controller
{
    public function index()
    {
        $this->view('requestadmin');
    }

    public function getRequests(){
        session_start();
        require_once '../app/services/RequestService.php';
        $requestService = new RequestService();
        $requests = $requestService->getAllRequestsByPrisonId($_SESSION['username']);

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

    public function updateRequestStatus()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $input = json_decode(file_get_contents('php://input'), true);

            if (isset($input['id']) && isset($input['status'])) {

                $id = $input['id'];
                $status = $input['status'];

                require_once '../app/services/RequestService.php';
                $requestService = new RequestService();

                if ($requestService->updateStatus($id, $status)) {
                    file_put_contents('nume_fisier.txt', $input['id'] . $input['status'], FILE_APPEND);
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Failed to update request status']);
                }


            } else {
                echo json_encode(['success' => false, 'error' => 'Invalid request method']);
            }
        }

    }
}