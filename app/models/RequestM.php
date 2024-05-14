<?php

class RequestM
{
    private $visitorType;
    private $visitType;
    private $dateOfVisit;
    private $status;
    private $idInmate;
    private $requestCreated;
    private $statusChanged;
    private $visitorName;

    public function __construct(){
        $this->visitorType = "";
        $this->visitType = "";
        $this->dateOfVisit = "";
        $this->status = "";
        $this->idInmate = "";
        $this->requestCreated = "";
        $this->statusChanged = "";
        $this->visitorName = "";
    }

    /**
     * @return string
     */
    public function getVisitorType()
    {
        return $this->visitorType;
    }

    /**
     * @param string $visitorType
     */
    public function setVisitorType($visitorType)
    {
        $this->visitorType = $visitorType;
    }

    /**
     * @return string
     */
    public function getVisitType()
    {
        return $this->visitType;
    }

    /**
     * @param string $visitType
     */
    public function setVisitType($visitType)
    {
        $this->visitType = $visitType;
    }

    /**
     * @return string
     */
    public function getDateOfVisit()
    {
        return $this->dateOfVisit;
    }

    /**
     * @param string $dateOfVisit
     */
    public function setDateOfVisit($dateOfVisit)
    {
        $this->dateOfVisit = $dateOfVisit;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getIdInmate()
    {
        return $this->idInmate;
    }

    /**
     * @param string $idInmate
     */
    public function setIdInmate($idInmate)
    {
        $this->idInmate = $idInmate;
    }

    /**
     * @return string
     */
    public function getRequestCreated()
    {
        return $this->requestCreated;
    }

    /**
     * @param string $requestCreated
     */
    public function setRequestCreated($requestCreated)
    {
        $this->requestCreated = $requestCreated;
    }

    /**
     * @return string
     */
    public function getStatusChanged()
    {
        return $this->statusChanged;
    }

    /**
     * @param string $statusChanged
     */
    public function setStatusChanged($statusChanged)
    {
        $this->statusChanged = $statusChanged;
    }

    /**
     * @return string
     */
    public function getVisitorName()
    {
        return $this->visitorName;
    }

    /**
     * @param string $visitorName
     */
    public function setVisitorName($visitorName)
    {
        $this->visitorName = $visitorName;
    }




}