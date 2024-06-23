<?php

class Inmateprofile extends Controller
{
    public function index()
    {
        session_start();
        $criteria = [];

        foreach ($_GET as $key => $value) {
            if (strlen($value) != 0) {
                if (strcmp($key, 'url') != 0) {
                    $criteria[$key] = $value;
                }
            }
        }

        if (count($criteria) != 0) {
            $this->model('inmate');
            $this->model('prison');
            $iService = new InmateService();

            $inmates = $iService->getInmatesByCriteria($criteria);

            foreach ($inmates as $inmate) {
                $inmate->photo = $this->findInmatePhoto($inmate->getCnp());
            }

            $this->view('inmateprofile', $inmates);
        }
        else $this->view('inmateprofile');
    }

    private function findInmatePhoto($cnp)
    {
        $fileName = '../api/uploads/inmates/' . $cnp;
        if (file_exists($fileName . '.png')) {
            return $fileName . '.png';
        } else if (file_exists($fileName . '.webp')) {
            return $fileName . '.webp';
        } else if (file_exists($fileName . '.jpg')) {
            return $fileName . '.jpg';
        } else if (file_exists($fileName . '.jpeg')) {
            return $fileName . '.jpeg';
        } else if (file_exists($fileName . '.gif')) {
            return $fileName . '.gif';
        } else {
            return 'src/assets/prisoner.png'; // Default inmate image
        }
    }
}
