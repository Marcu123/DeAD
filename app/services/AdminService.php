<?php

require_once '../app/models/Admin.php';
require_once '../app/db/Database.php';
class AdminService
{
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAdminByUsername($username)
    {
        try{
            $stmt = $this->db->prepare("SELECT * FROM admins WHERE username = :username");
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
            $stmt = $this->db->prepare("SELECT admin_key FROM admins WHERE username = :username");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!$row)
                return false;

            return $row['admin_key'];
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
            return false;
        }
    }
}