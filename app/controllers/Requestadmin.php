<?php

class Requestadmin extends Controller
{
    public function index()
    {
        session_start();
        if (!isset($_SESSION['username_adm'])) {
            header('Location: adminlog');
        }
        $this->view('requestadmin');
    }

    public function getRequests(){
        session_start();
        require_once '../app/services/RequestService.php';
        $requestService = new RequestService();
        $requests = $requestService->getAllRequestsByPrisonId($_SESSION['username_adm']);

        $requestsArray = array_map(function($request) use ($requestService){

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
                    $email = $requestService->getEmailByRequestId($id);
                    $inmateName = $requestService->getInmateNameByRequestId($id);
                    $to = $email;
                    $subject = 'Request status updated';
                    $message = 'Your request for ' . $inmateName . ' has been ' . $status . ' by the admin. You can visit him/her on ' . $requestService->getDateOfVisitByRequestId($id);
                    $headers = array(
                        'From' => 'marcugames03@gmail.com',
                        'Reply-To' => 'marcugames03@gmail.com',
                    );

                    mail($to, $subject, $message, $headers);
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