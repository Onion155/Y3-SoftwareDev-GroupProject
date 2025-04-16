<?php
class Patient {
    private $id;
    private $firstName;
    private $lastName;
    private $DoB;
    private $sex;
    private $isBlack;
    private $notes;
    private $NHSNumber;
    private $accountId;
    private $doctorId;

    public function toArray() {
      return get_object_vars($this);
    }

    function __get($name) {
        return $this->$name;
      }
    
    function __set($name,$value) {
      $this->$name = $value;
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
      
      return 186 * pow($a,-1.154) * pow($b,-0.203) * $y * $z;
    }

    public function getAge() {
      $dob = new DateTime($this->DoB);
      $now = new DateTime();
      $agediff = $now->diff($dob);
      $yeard = $agediff->y; //Difference in year
      $monthd = $agediff->m; //Difference in month
      $dayd = $agediff->d; //Difference in day

      if ($monthd < 0 || ($monthd == 0 && $dayd < 0)) {
        $age = $yeard - 1;
      } else {
        $age = $yeard; 
      }
      return $age;
    }
}
?>