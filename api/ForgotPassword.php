<?php

class ForgotPassword
{
    private $db;
    private $requestMethod;

    public function __construct($db, $requestMethod)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'POST':
                $response = $this->forgotPassword();
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

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['content_type_header'] = 'Content-Type: application/json';
        $response['body'] = json_encode([
            'message' => 'Not Found'
        ]);
        return $response;
    }

    private function forgotPassword()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        require_once '../app/services/UserService.php';
        $userService = new UserService();

        if ($userService->existsEmail($input['email'])) {
            function generatePassword($length = 15)
            {
                $upperCase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $lowerCase = 'abcdefghijklmnopqrstuvwxyz';
                $numbers = '0123456789';
                $specialChars = '!@#$%';

                $allChars = $upperCase . $lowerCase . $numbers . $specialChars;
                $password = [];

                $password[] = $upperCase[rand(0, strlen($upperCase) - 1)];
                $password[] = $lowerCase[rand(0, strlen($lowerCase) - 1)];
                $password[] = $numbers[rand(0, strlen($numbers) - 1)];
                $password[] = $specialChars[rand(0, strlen($specialChars) - 1)];

                for ($i = 4; $i < $length; $i++) {
                    $password[] = $allChars[rand(0, strlen($allChars) - 1)];
                }

                shuffle($password);

                return implode('', $password);
            }

            $email = $input['email'];
            $newPassword = generatePassword();
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $userService->resetPassword($email, $hashedNewPassword);

            $to = $email;
            $subject = 'Your password has been reset';
            $message = 'Your new password is: ' . $newPassword . ' Please change it as soon as possible!';
            $headers = array(
                'From' => 'marcugames03@gmail.com',
                'Reply-To' => 'marcugames03@gmail.com',
            );

            mail($to, $subject, $message, $headers);
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['content_type_header'] = 'Content-Type: application/json';
            $response['body'] = json_encode([
                'message' => 'Email sent to ' . $input['email'] . ' with the new password!',
                'success' => true
            ]);
        } else {
            $response['status_code_header'] = 'HTTP/1.1 400 Bad Request';
            $response['content_type_header'] = 'Content-Type: application/json';
            $response['body'] = json_encode([
                'error' => 'Failed to find the email!',
                'success' => false
            ]);
        }
        return $response;
    }
}
