<?php

class Request extends Controller
{
    public function index()
    {
        session_start();
        $this->view('request');
        unset($_SESSION['error']);
        unset($_SESSION['good']);
    }

    public function form()
    {
        session_start();
        require_once '../app/models/Visitor.php';
        require_once '../app/models/RequestM.php';
        require_once '../app/services/RequestService.php';
        $requestService = new RequestService();

        $visitor = new Visitor();
        $visitor0 = new Visitor();
        $visitor1 = new Visitor();

        $request = new RequestM();

        $visitor_name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $request->setVisitorName($visitor_name);
        $request->setVisitorType(filter_input(INPUT_POST, 'visitType', FILTER_SANITIZE_SPECIAL_CHARS));
        $request->setVisitType(filter_input(INPUT_POST, 'visit-type', FILTER_SANITIZE_SPECIAL_CHARS));
        $request->setDateOfVisit(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS));
        $request->setStatus('pending');
        $request->setRequestCreated(date('Y-m-d H:i:s'));

        require_once '../app/services/InmateService.php';
        $inmateService = new InmateService();

        $cnp = filter_input(INPUT_POST, 'prisoner-cnp', FILTER_SANITIZE_SPECIAL_CHARS);
        $result = $requestService->cnpValidation($cnp);
        if ($result == false) {
            $_SESSION['error'] = "Invalid CNP format for inmate!";
            header('Location: /Request');
            return;
        }

        $inmate_id = $inmateService->getInmateIdByCNP($cnp);
        if ($inmate_id == false) {
            $_SESSION['error'] = "Inmate not found!";
            header('Location: /Request');
            return;
        }

        $request->setIdInmate($inmate_id);
        $request->setPrisonId($inmateService->getInmatePrisonId($inmate_id));

        $cnp = filter_input(INPUT_POST, 'cnp', FILTER_SANITIZE_SPECIAL_CHARS);
        $result = $requestService->cnpValidation($cnp);
        if ($result == false) {
            $_SESSION['error'] = "Invalid CNP format for visitor!";
            header('Location: /Request');
            return;
        }
        $visitor->setVisitorName(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS));
        $visitor->setCnp(filter_input(INPUT_POST, 'cnp', FILTER_SANITIZE_SPECIAL_CHARS));
        $visitor->setEmail(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS));
        $visitor->setPhoneNumber(filter_input(INPUT_POST, 'phone-number', FILTER_SANITIZE_SPECIAL_CHARS));
        $clicks = intval(filter_input(INPUT_POST, 'clicks', FILTER_SANITIZE_SPECIAL_CHARS));

        if (isset($_POST['name_extra0']) && $_POST['name_extra0'] != "") {
            $visitor0->setVisitorName(filter_input(INPUT_POST, 'name_extra0', FILTER_SANITIZE_SPECIAL_CHARS));
            $cnp = filter_input(INPUT_POST, 'cnp_extra0', FILTER_SANITIZE_SPECIAL_CHARS);
            $result = $requestService->cnpValidation($cnp);
            if ($result == false) {
                $_SESSION['error'] = "Invalid CNP format for extra-visitor!";
                header('Location: /Request');
                return;
            }
            $visitor0->setCnp(filter_input(INPUT_POST, 'cnp_extra0', FILTER_SANITIZE_SPECIAL_CHARS));
            $visitor0->setEmail(filter_input(INPUT_POST, 'email_extra0', FILTER_SANITIZE_SPECIAL_CHARS));
            $visitor0->setPhoneNumber(filter_input(INPUT_POST, 'phone-number_extra0', FILTER_SANITIZE_SPECIAL_CHARS));
        }

        if (isset($_POST['name_extra1']) && $_POST['name_extra1'] != "") {
            $visitor1->setVisitorName(filter_input(INPUT_POST, 'name_extra1', FILTER_SANITIZE_SPECIAL_CHARS));
            $cnp = filter_input(INPUT_POST, 'cnp_extra1', FILTER_SANITIZE_SPECIAL_CHARS);
            $result = $requestService->cnpValidation($cnp);
            if ($result == false) {
                $_SESSION['error'] = "Invalid CNP format for extra-visitor!";
                header('Location: /Request');
                return;
            }
            $visitor1->setCnp(filter_input(INPUT_POST, 'cnp_extra1', FILTER_SANITIZE_SPECIAL_CHARS));
            $visitor1->setEmail(filter_input(INPUT_POST, 'email_extra1', FILTER_SANITIZE_SPECIAL_CHARS));
            $visitor1->setPhoneNumber(filter_input(INPUT_POST, 'phone-number_extra1', FILTER_SANITIZE_SPECIAL_CHARS));
        }



        $requestService->addRequest($request);

        $visitorName = $visitor->getVisitorName();
        $request_id = $requestService->getRequestIdByVisitorName($visitorName);
        $visitor->setIdRequest($request_id);
        $visitor0->setIdRequest($request_id);
        $visitor1->setIdRequest($request_id);

        include_once "../api/PhotoController.php";
        $photoController = new PhotoController();

        require_once '../app/services/VisitorService.php';
        $visitorService = new VisitorService();
        $visitorService->addVisitor($visitor);
        $photoController->processRequestFront($visitor->getCnp(), 'visitor');
        if ($visitor0->getVisitorName() != "") {
            $visitorService->addVisitor($visitor0);
            $photoController->processRequestFront($visitor0->getCnp(), 'visitor', 0);

        } else if ($visitor1->getVisitorName() != "") {
            $visitorService->addVisitor($visitor0);
            $visitorService->addVisitor($visitor1);
            $photoController->processRequestFront($visitor0->getCnp(), 'visitor', 1);
            $photoController->processRequestFront($visitor1->getCnp(), 'visitor', 1);

        }

        $_SESSION['good'] = "Request submitted successfully!";
        header('Location: /Request');

    }






}