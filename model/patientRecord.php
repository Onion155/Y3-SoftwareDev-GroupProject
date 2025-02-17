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

      function getEGFRDescription() {
        $egfr = $this->eGFR;
        if ($egfr >= 90) "Normal kidney function";
        else if ($egfr >= 60) return "Mildly reduced kidney function";
        else if ($egfr >= 30) return "Moderately reduced kidney function";
        else if ($egfr >=  15) return "Serverely reduced kidney function";
        else return "Very severe, or end stage kidney failure";
      }
}
?>