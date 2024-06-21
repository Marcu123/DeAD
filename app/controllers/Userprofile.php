<?php

class Userprofile extends Controller
{
    public function index()
    {
        session_start();
        if (!isset($_SESSION['username'])) {
            header('Location: userlog');
        }

        $profilePhoto = $this->findUserPhoto($_SESSION["cnp"]);
        $_SESSION['profilePhoto'] = $profilePhoto;
        $this->view('userprofile', ['profilePhoto' => $profilePhoto]);
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: ../userlog');
    }

    private function findUserPhoto($cnp)
    {
        $fileName = '../api/uploads/users/' . $cnp;
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
            return 'src/assets/user.png';
        }
    }
}
