<?php

class User
{
    private $username;
    private $password;
    private $email;
    private $cnp;
    private $phone;
    private $photo;
    private $enabled;
    private $activationCode;

    public function __construct()
    {
        $this->username = null;
        $this->password = null;
        $this->email = null;
        $this->cnp = null;
        $this->phone = null;
        $this->photo = null;
        $this->enabled = false;
        $this->activationCode = null;
    }

    public function getEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return null
     */
    public function getActivationCode()
    {
        return $this->activationCode;
    }

    /**
     * @param null $activationCode
     */
    public function setActivationCode($activationCode)
    {
        $this->activationCode = $activationCode;
    }


    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getCnp()
    {
        return $this->cnp;
    }

    /**
     * @param mixed $cnp
     */
    public function setCnp($cnp)
    {
        $this->cnp = $cnp;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }


}