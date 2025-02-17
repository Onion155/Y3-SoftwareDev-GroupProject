<?php
class PatientRecord {
    private $id;
    private $dateCreated;
    private $eGFR;
    private $bloodPressure;
    private $priority;
    private $patientId;

    function __get($name) {
        return $this->$name;
      }
    
      function __set($name,$value) {
        $this->$name = $value;
      }

      function getEGFRValuePair() {
        $egfr = $this->eGFR;  
        if ($egfr >= 90) return ["1" => "Normal kidney function"];
        else if ($egfr >= 60) return ["2" => "Mildly reduced kidney function"];
        else if ($egfr >= 45) return ["3A" => "Moderately reduced kidney function"];
        else if ($egfr >= 30) return ["3B" => "Moderately reduced kidney function"];
        else if ($egfr >=  15) return ["4" => "Serverely reduced kidney function"];
        else return ["5" => "Very severe, or end stage kidney failure"];
      }
}
?>