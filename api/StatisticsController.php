<?php

class StatisticsController
{
    private $db;
    private $request_method;
    private $uri;
    private $username;

    public function __construct($db, $request_method, $username,$uri)
    {
        $this->db = $db;
        $this->request_method = $request_method;
        $this->username = $username;
        $this->uri = $uri;
    }

    public function processRequest()
    {
        $stat = [];
        switch ($this->request_method) {
            case 'GET':
                require_once "../app/services/StatisticsService.php";
                require_once "../app/services/AdminService.php";
                $statisticsService = new StatisticsService();
                $adminService = new AdminService();
                $prisonId = $adminService->getPrisonIdByUsername($this->username);
                switch($this->uri[4]){
                    case 'crime':
                        $stat = $statisticsService->getCrimeStatistics($prisonId);
                        break;
                    case 'age':
                        $stat = $statisticsService->getAgeStatistics($prisonId);
                        break;
                    case 'gender':
                        $stat = $statisticsService->getGenderStatistics($prisonId);
                        break;
                    default:
                        header('HTTP/1.0 400 Bad Request');
                        break;
                }
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        if($stat == null){
            $response = $this->notFoundResponse();
            return $response;
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['content_type_header'] = 'Content-Type: application/json';
        $response['body'] = json_encode([
            'statistic' => $stat
        ]);
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
            'message' => 'Not Found'
        ]);
        return $response;
    }
}