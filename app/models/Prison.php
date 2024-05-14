<?php

class Prison{
    private $name;
    private $inmate_number;
    private $employee_number;

    public function __construct($name, $inmate_number, $employee_number){
        $this->name = $name;
        $this->inmate_number = $inmate_number;
        $this->employee_number = $employee_number;
    }
    public function getName(){
        return $this->name;
    }
}