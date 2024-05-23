<?php

class VisitInfoService
{
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }
    public function getVisitInfoByRequestID($requestID){
        $stmt = $this->db->prepare("SELECT * FROM visit_info
         WHERE id_request = :id_request");

        $stmt->bindParam(':id_request', $requestID);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row){
            $visitInfo = new Visitinfo($row['id'], $row['id_request'],
                null, $row['objects_traded'],
                $row['conversation_resume'], $row['health_status'],
                $row['mood'], []);

            $iService = new InmateService();
            $visitInfo->setInmate($iService->getInmateById($row['id_inmate']));

            $stmt = $this->db->prepare("SELECT * FROM witnesses WHERE id_visit = :id_visit");
            $stmt->bindParam(':id_visit', $row['id']);
            $stmt->execute();

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                if(isset($row['id_visitor']) && strlen($row['id_visitor']) > 0){
                    $stmt = $this->db->prepare("SELECT * FROM visitor WHERE id = :id");
                    $stmt->bindParam(':id', $row['id_visitor']);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    if($row){
                        $visitor = new Visitor();
                        $visitor->setVisitorName($row['visitor_name']);
                        $visitor->setEmail($row['email']);
                        $visitor->setCnp($row['cnp']);
                        $visitor->setPhoneNumber($row['phone_number']);

                        $witness = new Witness();
                        $witness->setType('visitor');
                        $witness->setVisitor($visitor);

                        $visitInfo->addWitness($witness);
                        var_dump($witness);
                        echo "<br>";
                    }
                } else if(isset($row['id_employee']) && strlen($row['id_employee']) > 0){
                    $stmt = $this->db->prepare("SELECT * FROM employee WHERE id = :id");
                    $stmt->bindParam(':id', $row['id_employee']);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    if($row){
                        $employee = new Employee();
                        $employee->setName($row['name']);
                        $employee->setCnp($row['cnp']);

                        $witness = new Witness();
                        $witness->setType('employee');
                        $witness->setEmployee($employee);

                        $visitInfo->addWitness($witness);
                        var_dump($witness);
                        echo "<br>";
                    }
                }
            }

            return $visitInfo;

        } else return null;
    }
    public function create(Visitinfo $visitInfo){
        try{
            $requestID = $visitInfo->getRequestId();

            $iService = new InmateService();
            $inmateID  = $iService->getInmateIdByCNP($visitInfo->getInmateCNP());

            $objectsTraded      = $visitInfo->getObjectsTraded();
            $conversationResume = $visitInfo->getConversationResume();
            $healthStatus       = $visitInfo->getHealthStatus();
            $mood               = $visitInfo->getMood();

            $stmt = $this->db->prepare('INSERT INTO visit_info(id_request, id_inmate, objects_traded, conversation_resume, health_status, mood) VALUES(:id_request, :id_inmate, :objects_traded, :conversation_resume, :health_status, :mood)');
            $stmt->bindParam(':id_request', $requestID, PDO::PARAM_INT);

            $stmt->bindParam(':id_inmate', $inmateID, PDO::PARAM_INT);

            $stmt->bindParam(':objects_traded', $objectsTraded, PDO::PARAM_STR);
            $stmt->bindParam(':conversation_resume', $conversationResume, PDO::PARAM_STR);
            $stmt->bindParam(':health_status', $healthStatus, PDO::PARAM_STR);
            $stmt->bindParam(':mood', $mood, PDO::PARAM_STR);

            $stmt->execute();
            //change this to use request id for speed --nooo
            $stmt = $this->db->prepare('SELECT id FROM visit_info WHERE id_request = :id_request');
            $stmt->bindParam(':id_request', $requestID, PDO::PARAM_INT);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $visitID = intval($row['id']);

            foreach($visitInfo->getWitnesses() as $witness){
                $stmt = $this->db->prepare('SELECT bindWitness(:visit_id, :witness_cnp)');
                $stmt->bindParam(':visit_id', $visitID, PDO::PARAM_INT);
                $stmt->bindParam(':witness_cnp', $witness, PDO::PARAM_STR);

                $stmt->execute();
            }
        } catch (PDOException $e) {
            trigger_error('Error in ' . __METHOD__ . ': ' . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function delete($requestID){
        try{
            $stmt = $this->db->prepare('DELETE FROM visit_info WHERE id_request = :id_request');
            $stmt->bindParam(':id_request', $requestID, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            trigger_error('Error in ' . __METHOD__ . ': ' . $e->getMessage(), E_USER_ERROR);
        }
    }
    public function updateByCriteria($requestID, $criteria){
        $query = "UPDATE visit_info SET ";
        $first = true;


        foreach ($criteria as $key => $value) {
            if(strcmp($key, 'witness') != 0){
                if (!$first) {
                    $query .= ' , ';
                }
                $query .= $key . ' = :' . $key;

                $first = false;
            }
        }

        $query .= ' WHERE id_request = :id_request';
        try{
            $stmt = $this->db->prepare($query);

            foreach ($criteria as $key => $value)
                if(strcmp($key, 'witness') != 0) {
                    $stmt->bindValue(':' . $key, strval($value), PDO::PARAM_STR);
                }

            $stmt->bindValue(':id_request', intval($requestID), PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
        }

        if(isset($criteria['witness'])){
            $stmt = $this->db->prepare('SELECT id FROM visit_info WHERE id_request = :id_request');
            $stmt->bindParam(':id_request', $requestID, PDO::PARAM_INT);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $visitID = intval($row['id']);

            $stmt = $this->db->prepare('DELETE FROM witnesses WHERE id_visit = :id_visit');
            $stmt->bindParam(':id_visit', $visitID, PDO::PARAM_INT);

            $stmt->execute();

            $witnessCNP = explode(', ', $criteria['witness']);

            foreach($witnessCNP as $cnp){
                $stmt = $this->db->prepare('SELECT bindWitness(:visit_id, :witness_cnp)');
                $stmt->bindParam(':visit_id', $visitID, PDO::PARAM_INT);
                $stmt->bindParam(':witness_cnp', $cnp, PDO::PARAM_STR);

                $stmt->execute();
            }
        }
    }
}