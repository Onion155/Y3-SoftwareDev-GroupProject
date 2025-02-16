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
    
}
?>