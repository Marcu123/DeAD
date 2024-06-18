<?php

class UserBanController
{
    private $db;
    private $requestMethod;
    private $uri;

    public function __construct($db, $requestMethod, $uri)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->uri = $uri;
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'DELETE':
                require_once "../app/services/UserService.php";
                $userService = new UserService();

                if(!$userService->getUserByUsername($this->uri[4])){
                    $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
                    $response['content_type_header'] = 'Content-Type: application/json';
                    $response['body'] = json_encode(['error' => 'User not found']);
                    break;
                }

                $userService->delete($this->uri[4]);
                $response['status_code_header'] = 'HTTP/1.1 200 OK';
                $response['content_type_header'] = 'Content-Type: application/json';
                $response['body'] = json_encode([
                    'message' => 'User deleted'
                ]);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }

        header($response['status_code_header']);
        header($response['content_type_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function notFoundResponse() {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['content_type_header'] = 'Content-Type: application/json';
        $response['body'] = json_encode([
            'message' => 'Invalid request method'
        ]);
        return $response;
    }

}