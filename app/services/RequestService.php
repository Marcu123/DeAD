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
            $id_prison = $request->getPrisonId();
            $stmt = $this->db->prepare("INSERT INTO request (visitor_type, visit_type, date_of_visit, status, id_inmate,visitor_name, request_created, id_prison) VALUES (:visitor_type, :visit_type, :date_of_visit, :status, :id_inmate, :visitor_name,NOW(), :id_prison)");
            $stmt->bindParam(':visitor_type', $visitorType, PDO::PARAM_STR);
            $stmt->bindParam(':visit_type', $visitType, PDO::PARAM_STR);
            $stmt->bindParam(':date_of_visit', $dateOfVisit, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':visitor_name', $visitorName, PDO::PARAM_STR);
            $idInmate = intval($idInmate);
            $stmt->bindParam(':id_inmate', $idInmate, PDO::PARAM_INT);
            $stmt->bindParam(':id_prison',$id_prison , PDO::PARAM_INT);
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

    public function getAllRequestsByVisitorCnp($visitorCnp){
        try{
            $stmt = $this->db->prepare("SELECT * FROM visitor WHERE cnp = :cnp");
            $stmt->bindParam(':cnp', $visitorCnp, PDO::PARAM_STR);
            $stmt->execute();
            $visitor = $stmt->fetch(PDO::FETCH_ASSOC);
            $visitorName = $visitor['visitor_name'];


        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
            return false;
        }
        try{
            $stmt1 = $this->db->prepare("SELECT * FROM request WHERE visitor_name = :visitor_name");
            $stmt1->bindParam(':visitor_name', $visitorName, PDO::PARAM_STR);
            $stmt1->execute();
            $requests = array();
            while($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                $request = new RequestM();
                $request->setId($row['id']);
                $request->setVisitorType($row['visitor_type']);
                $request->setVisitType($row['visit_type']);
                $request->setDateOfVisit($row['date_of_visit']);
                $request->setStatus($row['status']);
                $request->setIdInmate($row['id_inmate']);
                $request->setVisitorName($row['visitor_name']);
                $request->setRequestCreated($row['request_created']);


                $stmt2 = $this->db->prepare("SELECT * FROM inmate WHERE id = :id");
                $stmt2->bindParam(':id', $row['id_inmate'], PDO::PARAM_INT);
                $stmt2->execute();

                $inmate = $stmt2->fetch(PDO::FETCH_ASSOC);
                $inmateName = $inmate['first_name'] . ' ' . $inmate['last_name'];
                $request->setInmateName($inmateName);
                $request->setInmateCnp($inmate['cnp']);


                $requests[] = $request;

            }

            return $requests;
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
            return false;
        }
    }

    public function getAllRequestsByPrisonId($username){
        try{
            $stmt = $this->db->prepare("SELECT id_prison FROM admins WHERE username = :username");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $prisonId = $row['id_prison'];

            $stmt1 = $this->db->prepare("SELECT * FROM request WHERE id_prison = :prison_id");
            $stmt1->bindParam(':prison_id', $prisonId, PDO::PARAM_INT);
            $stmt1->execute();
            $requests = array();
            while($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                $request = new RequestM();
                $request->setId($row['id']);
                $request->setVisitorType($row['visitor_type']);
                $request->setVisitType($row['visit_type']);
                $request->setDateOfVisit($row['date_of_visit']);
                $request->setStatus($row['status']);
                $request->setIdInmate($row['id_inmate']);
                $request->setVisitorName($row['visitor_name']);
                $request->setRequestCreated($row['request_created']);

                $stmt2 = $this->db->prepare("SELECT * FROM inmate WHERE id = :id");
                $stmt2->bindParam(':id', $row['id_inmate'], PDO::PARAM_INT);
                $stmt2->execute();

                $inmate = $stmt2->fetch(PDO::FETCH_ASSOC);
                $inmateName = $inmate['first_name'] . ' ' . $inmate['last_name'];
                $request->setInmateName($inmateName);
                $request->setInmateCnp($inmate['cnp']);

                $requests[] = $request;

            }
            return $requests;
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
            return false;
        }

    }

    public function updateStatus($id, $status){
        try{
            file_put_contents('nume_fisier.txt', $id . $status, FILE_APPEND);
            $stmt = $this->db->prepare("UPDATE request SET status = :status WHERE id = :id");
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
            return false;
        }
    }




}