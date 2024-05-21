<?php

class VisitInfo{
    private $id;
    private $requestId;
    private $inmateCNP;

    private $objects_traded;
    private $conversation_resume;
    private $health_status;
    private $mood;

    private $witnesses = [];

    /**
     * @param $id
     * @param $requestId
     * @param $inmateCNP
     * @param array $objects_traded
     * @param $conversation_resume
     * @param $health_status
     * @param $mood
     * @param array $witnesses
     */
    public function __construct($id, $requestId, $inmateCNP, array $objects_traded, $conversation_resume, $health_status, $mood, array $witnesses)
    {
        $this->id = $id;
        $this->requestId = $requestId;
        $this->inmateCNP = $inmateCNP;
        $this->objects_traded = $objects_traded;
        $this->conversation_resume = $conversation_resume;
        $this->health_status = $health_status;
        $this->mood = $mood;
        $this->witnesses = $witnesses;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getRequestId()
    {
        return $this->requestId;
    }

    /**
     * @param mixed $requestId
     */
    public function setRequestId($requestId)
    {
        $this->requestId = $requestId;
    }

    /**
     * @return mixed
     */
    public function getInmateCNP()
    {
        return $this->inmateCNP;
    }

    /**
     * @param mixed $inmateCNP
     */
    public function setInmateCNP($inmateCNP)
    {
        $this->inmateCNP = $inmateCNP;
    }

    /**
     * @return array
     */
    public function getObjectsTraded()
    {
        return $this->objects_traded;
    }

    /**
     * @param array $objects_traded
     */
    public function setObjectsTraded($objects_traded)
    {
        $this->objects_traded = $objects_traded;
    }

    /**
     * @return mixed
     */
    public function getConversationResume()
    {
        return $this->conversation_resume;
    }

    /**
     * @param mixed $conversation_resume
     */
    public function setConversationResume($conversation_resume)
    {
        $this->conversation_resume = $conversation_resume;
    }

    /**
     * @return mixed
     */
    public function getHealthStatus()
    {
        return $this->health_status;
    }

    /**
     * @param mixed $health_status
     */
    public function setHealthStatus($health_status)
    {
        $this->health_status = $health_status;
    }

    /**
     * @return mixed
     */
    public function getMood()
    {
        return $this->mood;
    }

    /**
     * @param mixed $mood
     */
    public function setMood($mood)
    {
        $this->mood = $mood;
    }

    /**
     * @return array
     */
    public function getWitnesses()
    {
        return $this->witnesses;
    }

    /**
     * @param array $witnesses
     */
    public function setWitnesses($witnesses)
    {
        $this->witnesses = $witnesses;
    }

}