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

    public function getRequests()
    {
        session_start();
        require_once '../app/services/RequestService.php';
        require_once '../app/services/VisitorService.php';

        $requestService = new RequestService();
        $visitorService = new VisitorService();
        $requests = $requestService->getAllRequestsByPrisonId($_SESSION['username_adm']);

        $requestsArray = array_map(function ($request) use ($requestService, $visitorService) {
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

    private function findPhoto($pkey)
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