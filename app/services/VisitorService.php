<?php

require_once '../app/models/Visitor.php';
require_once '../app/db/Database.php';
class VisitorService
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function addVisitor(Visitor $visitor)
    {
        try {
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

    public function findVisitorsCnpsByRequestId($idRequest)
    {
        try {
            $stmt = $this->db->prepare("SELECT cnp,id_request FROM visitor WHERE id_request = :id_request");
            $stmt->bindParam(':id_request', $idRequest, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $cnps = array();
            array_push($cnps, );
            foreach ($rows as $row) {
                array_push($cnps, $row['cnp'], $row['id_request']);
            }
            return $cnps;
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function getVisitorNameByCnp(mixed $int){
        try{
            $stmt = $this->db->prepare("SELECT visitor_name FROM visitor WHERE cnp = :cnp");
            $stmt->bindParam(':cnp', $int, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!$row)
                return null;
            return $row['visitor_name'];
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);

        }
    }

    public function getEmailByCnp(mixed $int)
    {
        try{
            $stmt = $this->db->prepare("SELECT email FROM visitor WHERE cnp = :cnp");
            $stmt->bindParam(':cnp', $int, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!$row)
                return null;
            return $row['email'];
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);

        }
    }

    public function getPhoneNumberByCnp(mixed $int)
    {
        try{
            $stmt = $this->db->prepare("SELECT phone_number FROM visitor WHERE cnp = :cnp");
            $stmt->bindParam(':cnp', $int, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!$row)
                return null;
            return $row['phone_number'];
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);

        }
    }


}