<?php

class UserController
{
    private $db;
    private $request_method;

    public function __construct($db, $request_method)
    {
        $this->db = $db;
        $this->request_method = $request_method;
    }

    public function processRequest()
    {
        if ($this->request_method == 'POST') {
            $data = json_decode(file_get_contents("php://input"));
            $this->login($data);
        }
        else {
            $this->notFoundRequest();
        }
    }

    private function notFoundRequest()
    {
    }
}