<?php

require_once '../app/models/Visitor.php';
require_once '../app/db/Database.php';
class VisitorService
{
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function addVisitor(Visitor $visitor){
        try{
            $visitorName = $visitor->getVisitorName();
            $cnp = $visitor->getCnp();
            $photo = $visitor->getPhoto();
            $email = $visitor->getEmail();
            $phoneNumber = $visitor->getPhoneNumber();
            $idRequest = $visitor->getIdRequest();
            $stmt = $this->db->prepare("INSERT INTO visitor (visitor_name, cnp, photo, email, phone_number, id_request) VALUES (:visitor_name, :cnp, :photo, :email, :phone_number, :id_request)");
            $stmt->bindParam(':visitor_name', $visitorName, PDO::PARAM_STR);
            $stmt->bindParam(':cnp', $cnp, PDO::PARAM_STR);
            $stmt->bindParam(':photo', $photo, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':phone_number', $phoneNumber, PDO::PARAM_STR);
            $stmt->bindParam(':id_request', $idRequest, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
        }
    }



}