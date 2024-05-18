<?php

class Statistics extends Controller
{
    public function index()
    {
        $this->view('statistics');
    }

    public function generate()
    {
        session_start();
        require_once '../app/services/StatisticsService.php';
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $criteria = $_POST['criteria'];
            $format = $_POST['format'];
            $statisticsService = new StatisticsService();

            require_once '../app/services/AdminService.php';
            $adminService = new AdminService();
            $prisonID = $adminService->getPrisonIdByUsername($_SESSION['username']);

            if($format == 'html')
            {
                $statisticsService->generateHTML($criteria, $prisonID);

            }
            else if($format == 'json')
            {
                $statisticsService->generateJSON($criteria,$prisonID);
            }
            else if($format == 'csv')
            {
                $statisticsService->generateCSV($criteria,$prisonID);
            }

        }

    }



}