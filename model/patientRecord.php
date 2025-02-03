<?php
class PatientRecord {
    private $id;
    public $dateCreated;
    public $eGFR;
    public $bloodPressure;
    public $priority;
    public $note;
    private $patientID;

    function __get($name) {
        return $this->$name;
      }
    
      function __set($name,$value) {
        $this->$name = $value;
      }
    
}
?>