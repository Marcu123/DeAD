<?php

class Inmate {
    private $id;
    public $photo;
    public $firstName;
    public $lastName;
    public $cnp;
    public $age;
    public $gender;
    public $idPrison;
    public $dateOfIncarceration;
    public $endOfIncarceration;
    public $crime;

    public function __construct($id,$photo, $firstName, $lastName, $cnp, $age, $gender, $idPrison, $dateOfIncarceration, $endOfIncarceration, $crime) {
        $this->id = $id;
        $this->photo = $photo;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->cnp = $cnp;
        $this->age = $age;
        $this->gender = $gender;
        $this->idPrison = $idPrison;
        $this->dateOfIncarceration = $dateOfIncarceration;
        $this->endOfIncarceration = $endOfIncarceration;
        $this->crime = $crime;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getCnp()
    {
        return $this->cnp;
    }

    public function setCnp($cnp)
    {
        $this->cnp = $cnp;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function setAge($age)
    {
        $this->age = $age;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    public function getIdPrison()
    {
        return $this->idPrison;
    }

    public function setIdPrison($idPrison)
    {
        $this->idPrison = $idPrison;
    }

    public function getDateOfIncarceration()
    {
        return $this->dateOfIncarceration;
    }

    public function setDateOfIncarceration($dateOfIncarceration)
    {
        $this->dateOfIncarceration = $dateOfIncarceration;
    }

    public function getEndOfIncarceration()
    {
        return $this->endOfIncarceration;
    }

    public function setEndOfIncarceration($endOfIncarceration)
    {
        $this->endOfIncarceration = $endOfIncarceration;
    }

    public function getCrime()
    {
        return $this->crime;
    }

    public function setCrime($crime)
    {
        $this->crime = $crime;
    }
}
