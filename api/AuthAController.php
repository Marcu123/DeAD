<?php


use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthAController
{
    private $db;
    private $requestMethod;
    private $secret_Key  = '%aaSWvtJ98os_b<IQ_c$j<_A%bo_[xgct+j$d6LJ}^<pYhf+53k^-R;Xs<l%5dF';
    private $domainName = "https://127.0.0.1";

    public function __construct($db, $requestMethod)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
    }

    public function processRequest() {
        switch ($this->requestMethod) {
            case 'POST':
                $response = $this->createJWT();
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

    private function unprocessableEntityResponse() {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['content_type_header'] = 'Content-Type: application/json';
        $response['body'] = json_encode([
            'message' => 'Invalid input'
        ]);
        return $response;
    }


    private function createJWT() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['username'])) {
            return $this->unprocessableEntityResponse();
        }

        $secret_Key = $this->secret_Key;
        $date = new DateTimeImmutable();
        $expire_at = $date->modify('+6 minutes')->getTimestamp();
        $domainName = $this->domainName;

        require_once "../app/services/AdminService.php";

        $adminService = new AdminService();
        $admin = $adminService->getAdminByUsername($data['username']);
        if(!$admin){
            return $this->unprocessableEntityResponse();
        }
        $password = $adminService->getPasswordByUsername($data['username']);

        if (!password_verify($data['password'], $password)){
            return $this->unprocessableEntityResponse();
        }
        $username = $data['username'];




        $request_data = [
            'iat' => $date->getTimestamp(), // Issued at: time when the token was generated
            'iss' => $domainName,           // Issuer
            'nbf' => $date->getTimestamp(), // Not before
            'exp' => $expire_at,            // Expire
            'username' => $username,        // User name
            'type' => 'admin'                // Type of user
        ];

        $jwt = JWT::encode($request_data, $secret_Key, 'HS512');

        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['content_type_header'] = 'Content-Type: application/json';
        $response['body'] = json_encode([
            'jwt' => $jwt
        ]);

        return $response;
    }


    private function checkJWTExistance() {
        if (!preg_match('/Bearer\s(\S+)/', $this->getAuthorizationHeader(), $matches)) {
            header('HTTP/1.0 400 Bad Request');
            echo 'Token not found in request';
            exit;
        }
        return $matches[1];
    }

    private function getAuthorizationHeader() {
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }

    public function validateJWT($jwt) {
        $secret_Key = $this->secret_Key;

        try {
            $token = JWT::decode($jwt, new Key($secret_Key, 'HS512'));
        } catch (Exception $e) {
            header('HTTP/1.1 401 Unauthorized');
            exit;
        }

        $now = new DateTimeImmutable();
        $domainName = $this->domainName;

        if ($token->iss !== $domainName ||
            $token->nbf > $now->getTimestamp() ||
            $token->exp < $now->getTimestamp()) {
            header('HTTP/1.1 401 Unauthorized');
            exit;
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
