<?php

require_once '../app/models/RequestM.php';
require_once '../app/db/Database.php';
class RequestService
{
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function addRequest(RequestM $request){
        try{
            $visitorType = $request->getVisitorType();
            $visitType = $request->getVisitType();
            $dateOfVisit = $request->getDateOfVisit();
            $status = $request->getStatus();
            $idInmate = $request->getIdInmate();
            $visitorName = $request->getVisitorName();
            $stmt = $this->db->prepare("INSERT INTO request (visitor_type, visit_type, date_of_visit, status, id_inmate,visitor_name, request_created) VALUES (:visitor_type, :visit_type, :date_of_visit, :status, :id_inmate, :visitor_name,NOW())");
            $stmt->bindParam(':visitor_type', $visitorType, PDO::PARAM_STR);
            $stmt->bindParam(':visit_type', $visitType, PDO::PARAM_STR);
            $stmt->bindParam(':date_of_visit', $dateOfVisit, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':visitor_name', $visitorName, PDO::PARAM_STR);
            $idInmate = intval($idInmate);
            $stmt->bindParam(':id_inmate', $idInmate, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
            return false;
        }
    }

    public function getRequestIdByVisitorName($visitorName){
        try{
            $stmt = $this->db->prepare("SELECT id FROM request WHERE visitor_name = :visitor_name ORDER BY id DESC LIMIT 1");
            $stmt->bindParam(':visitor_name', $visitorName, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['id'];
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
            return false;
        }
    }

    public function getAllRequestsByVisitorName($visitorName){
        try{
            $stmt = $this->db->prepare("SELECT * FROM request WHERE visitor_name = :visitor_name");
            $stmt->bindParam(':visitor_name', $visitorName, PDO::PARAM_STR);
            $stmt->execute();
            $requests = array();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $request = new RequestM();
                $request->setId($row['id']);
                $request->setVisitorType($row['visitor_type']);
                $request->setVisitType($row['visit_type']);
                $request->setDateOfVisit($row['date_of_visit']);
                $request->setStatus($row['status']);
                $request->setIdInmate($row['id_inmate']);
                $request->setVisitorName($row['visitor_name']);
                $request->setRequestCreated($row['request_created']);
                $requests[] = $request;
            }
            return $requests;
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
            return false;
        }
    }




}