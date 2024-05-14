<?php

class Visitor
{
    private $visitor_name;
    private $cnp;
    private $photo;
    private $email;
    private $phone_number;
    private $id_request;

    public function __construct(){
        $this->visitor_name = "";
        $this->cnp = "";
        $this->photo = "";
        $this->email = "";
        $this->phone_number = "";
        $this->id_request = 0;
    }

    /**
     * @return string
     */
    public function getVisitorName()
    {
        return $this->visitor_name;
    }

    /**
     * @param string $visitor_name
     */
    public function setVisitorName($visitor_name)
    {
        $this->visitor_name = $visitor_name;
    }

    /**
     * @return string
     */
    public function getCnp()
    {
        return $this->cnp;
    }

    /**
     * @param string $cnp
     */
    public function setCnp($cnp)
    {
        $this->cnp = $cnp;
    }

    /**
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    /**
     * @param string $phone_number
     */
    public function setPhoneNumber($phone_number)
    {
        $this->phone_number = $phone_number;
    }

    /**
     * @return int
     */
    public function getIdRequest()
    {
        return $this->id_request;
    }

    /**
     * @param int $id_request
     */
    public function setIdRequest($id_request)
    {
        $this->id_request = $id_request;
    }



}