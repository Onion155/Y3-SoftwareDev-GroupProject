<?php
class Patient {
    private $id;
    private $DoB;
    private $sex;
    private $isBlack;
    private $NHSNumber;
    private $userId;
    private $doctorId;

    function __get($name) {
        return $this->$name;
      }
    
      function __set($name,$value) {
        $this->$name = $value;
      }

      private function getAge() {
        $dob = new DateTime($this->DoB);
        $now = new DateTime();
        $aged = $now->diff($dob);
        $yeard = $aged->y; //Difference in year
        $monthd = $aged->m; //Difference in month
        $dayd = $aged->d; //Difference in day
        if ($monthd < 0 || ($monthd === 0 && $dayd < 0)) {
          $age = $yeard - 1;
        } else {
          $age = $yeard; 
        }
        return $age;
      }
    
      function calculateEGFR($creatinine) {
        $a = $creatinine/88.4;
        $b = $this->getAge();

        if ($this->sex == "female") {
        $y = 0.742;
        } else $y = 1;

        if ($this->isBlack) {
          $z = 1.21;
        } else $z = 1;

        echo ("a: $a, b: $b, y: $y, z: $z");
        
        return 186 * pow($a,-1.154) * pow($b,-0.203) * $y * $z;
      }
}
?>