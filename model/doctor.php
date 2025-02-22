<?php
class Doctor {
    private $id;
    private $firstName;
    private $lastName;
    private $doctorGMC;
    private $accountId;

    function __get($name) {
        return $this->$name;
      }
    
      function __set($name,$value) {
        $this->$name = $value;
      }
}
?>