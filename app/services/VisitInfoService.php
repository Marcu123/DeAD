<?php

class VisitInfoService
{
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }
    public function create(VisitInfo $visitInfo){
        try{
            $stmt = $this->db->prepare('INSERT INTO visit_info(id_request, id_inmate, objects_traded, conversation_resume, health_status, mood) VALUES(:id_request, :id_inmate, :objects_traded, :conversation_resume, :health_status, :mood)');
            $stmt->bindParam(':id_request', $visitInfo->getRequestId(), PDO::PARAM_INT);

            $iService = new InmateService();
            $stmt->bindParam(':id_inmate', $iService->getInmateIdByCNP($visitInfo->getInmateCNP()), PDO::PARAM_INT);

            $stmt->bindParam(':objects_traded', $visitInfo->getObjectsTraded(), PDO::PARAM_STR);
            $stmt->bindParam(':conversation_resume', $visitInfo->getConversationResume(), PDO::PARAM_STR);
            $stmt->bindParam(':health_status', $visitInfo->getHealthStatus(), PDO::PARAM_STR);
            $stmt->bindParam(':mood', $visitInfo->getMood(), PDO::PARAM_STR);

            $stmt->execute();
        } catch (PDOException $e) {
            trigger_error('Error in ' . __METHOD__ . ': ' . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function delete($requestId){
        try{
            $stmt = $this->db->prepare('DELETE FROM visit_info WHERE id_request = :id_request');
            $stmt->bindParam(':id_request', $requestId, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            trigger_error('Error in ' . __METHOD__ . ': ' . $e->getMessage(), E_USER_ERROR);
        }
    }
}