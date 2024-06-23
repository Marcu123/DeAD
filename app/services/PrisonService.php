<?php

class PrisonService{
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }
    public function getIdByName($name){
        try{
            $stmt = $this->db->prepare("SELECT id FROM prison WHERE name = :name");
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!$row)
                return null;
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
        }
        return $row['id'];
    }
    public function getPrisonById($id){
        try{
            $stmt = $this->db->prepare("SELECT * FROM prison WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
        }
        return new Prison($row['name'], $row['inmate_number'], $row['employee_number']);
    }

    public function getNrOfInmatesById($username){
        try{
            $aService = new AdminService();
            $prisonName = $aService->getPrisonByUsername($username);
            $stmt = $this->db->prepare("SELECT inmate_number FROM prison WHERE name = :name");
            $stmt->bindParam(':name', $prisonName, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
        }
        return $row['inmate_number'];
    }
    public function getPrisonIdByRequestId($id){
        try{
            $stmt = $this->db->prepare("SELECT id_prison FROM request WHERE id = :id");
            $stmt->bindParam(':name', $id, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
        }
        return $row['id_prison'];
    }
}