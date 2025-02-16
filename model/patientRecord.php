<?php
class PatientRecord {
    private $id;
    private $dateCreated;
    private $eGFR;
    private $bloodPressure;
    private $priority;
    private $note;
    private $patientId;

    function __get($name) {
        return $this->$name;
      }
    
      function __set($name,$value) {
        $this->$name = $value;
      }
    
}
?>