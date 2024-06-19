<?php

class ActivateController
{

    public function activate(array $uri)
    {
        $activationCode = $uri[4];

        require_once '../app/services/UserService.php';
        $userService = new UserService();
        if ($userService->getUserByActivationCode($activationCode)) {
            $userService->activateUser($activationCode);

            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['content_type_header'] = 'Content-Type: application/json';
            $response['body'] = json_encode([
                'msg' => 'Account activated'
            ]);

            header($response['status_code_header']);
            header($response['content_type_header']);
            if ($response['body']) {
                echo $response['body'];
            }
        }else {
            header('HTTP/1.0 400 Bad Request');
            echo 'Invalid code';
        }
    }
}