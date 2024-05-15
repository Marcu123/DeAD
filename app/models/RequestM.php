<?php

class RequestM
{
    private $id;
    private $visitorType;
    private $visitType;
    private $dateOfVisit;
    private $status;
    private $idInmate;
    private $requestCreated;
    private $statusChanged;
    private $visitorName;

    private $inmateName;
    private $inmateCnp;
    private $prison_id;

    public function __construct(){
        $this->id = "";
        $this->visitorType = "";
        $this->visitType = "";
        $this->dateOfVisit = "";
        $this->status = "";
        $this->idInmate = "";
        $this->requestCreated = "";
        $this->statusChanged = "";
        $this->visitorName = "";
        $this->inmateName = "";
        $this->inmateCnp = "";
        $this->prison_id = "";
    }

    /**
     * @return string
     */
    public function getPrisonId()
    {
        return $this->prison_id;
    }

    /**
     * @param string $prison_id
     */
    public function setPrisonId($prison_id)
    {
        $this->prison_id = $prison_id;
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

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getInmateName()
    {
        return $this->inmateName;
    }

    /**
     * @param string $inmateName
     */
    public function setInmateName($inmateName)
    {
        $this->inmateName = $inmateName;
    }

    /**
     * @return string
     */
    public function getInmateCnp()
    {
        return $this->inmateCnp;
    }

    /**
     * @param string $inmateCnp
     */
    public function setInmateCnp($inmateCnp)
    {
        $this->inmateCnp = $inmateCnp;
    }








}