<?php



require_once '../app/models/User.php';
require_once '../app/db/Database.php';

class UserService
{
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function registerUser(User $user){

        $username = $user->getUsername();
        $password = $user->getPassword();
        $email = $user->getEmail();
        $cnp = $user->getCnp();
        $phone = $user->getPhone();
        $photo = $user->getPhoto();

        try{
            $stmt = $this->db->prepare('INSERT INTO users (username, password, email, cnp, phone_number, photo, account_created, last_logged) values (:username, :password, :email, :cnp, :phone_number, :photo, now(), now())');
            $stmt->bindParam(':username',$username , PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':cnp', $cnp, PDO::PARAM_STR);
            $stmt->bindParam(':phone_number', $phone, PDO::PARAM_STR);
            $stmt->bindParam(':photo', $photo, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            trigger_error('Error in ' . __METHOD__ . ': ' . $e->getMessage(), E_USER_ERROR);
            return false;
        }

        return true;

    }

    public function getUserByUsername($username)
    {
        try{
            $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!$row)
                return false;

            return true;
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
            return false;
        }
    }

    public function getPasswordByUsername($username){
        try{
            $stmt = $this->db->prepare("SELECT password FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!$row)
                return false;

            return $row['password'];
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
            return false;
        }
    }

    public function getEmailByUsername($username){
        try{
            $stmt = $this->db->prepare("SELECT email FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!$row)
                return false;

            return $row['email'];
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
            return false;
        }
    }

    public function getCNPByUsername($username){
        try{
            $stmt = $this->db->prepare("SELECT cnp FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!$row)
                return false;

            return $row['cnp'];
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
            return false;
        }
    }

    public function getPhoneByUsername($username){
        try{
            $stmt = $this->db->prepare("SELECT phone_number FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!$row)
                return false;

            return $row['phone_number'];
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
            return false;
        }
    }

    public function setUsername($username, $oldUsername){
        try{
            $stmt = $this->db->prepare("UPDATE users SET username = :username WHERE username = :oldUsername");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':oldUsername', $oldUsername, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
            return false;
        }
    }

    public function setEmail($email, $oldUsername){
        try{
            $stmt = $this->db->prepare("UPDATE users SET email = :email WHERE username = :oldUsername");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':oldUsername', $oldUsername, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
            return false;
        }
    }

    public function setPhone($phone, $oldUsername){
        try{
            $stmt = $this->db->prepare("UPDATE users SET phone_number = :phone_number WHERE username = :oldUsername");
            $stmt->bindParam(':phone_number', $phone, PDO::PARAM_STR);
            $stmt->bindParam(':oldUsername', $oldUsername, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
            return false;
        }
    }

    public function setCNP($cnp, $oldUsername){
        try{
            $stmt = $this->db->prepare("UPDATE users SET cnp = :cnp WHERE username = :oldUsername");
            $stmt->bindParam(':cnp', $cnp, PDO::PARAM_STR);
            $stmt->bindParam(':oldUsername', $oldUsername, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
            return false;
        }
    }

    public function updatePassword($password,$username){
        try{
            $stmt = $this->db->prepare("UPDATE users SET password = :password WHERE username = :username");
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
            return false;
        }
    }
}