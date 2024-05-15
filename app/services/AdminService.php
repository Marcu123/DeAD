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

    public function getPrisonByUsername($username){
        try{
            $stmt = $this->db->prepare("SELECT id_prison FROM admins WHERE username = :username");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $prison_id = $row['id_prison'];

            $stmt = $this->db->prepare("SELECT name FROM prison WHERE id = :prison_id");
            $stmt->bindParam(':prison_id', $prison_id, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return $row['name'];
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
            return false;
        }
    }

    public function getNewRequestsNr($username){
        try{
            $stmt = $this->db->prepare("SELECT id_prison FROM admins WHERE username = :username");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $prison_id = $row['id_prison'];


            $stmt1 = $this->db->prepare("SELECT COUNT(*) as count FROM request WHERE id_prison = :prison_id AND status = 'pending'");
            $stmt1->bindParam(':prison_id', $prison_id, PDO::PARAM_INT);
            $stmt1->execute();
            $row = $stmt1->fetch(PDO::FETCH_ASSOC);

            return $row['count'];
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
            return false;
        }
    }

}