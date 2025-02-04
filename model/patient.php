<?php
class Patient {
    public $id;
    public $DoB;
    public $sex;
    public $isBlack;
    public $NHSNumber;
    private $userID;
    private $doctorID;

    function __get($name) {
        return $this->$name;
      }
    
      function __set($name,$value) {
        $this->$name = $value;
      }
    
}
?>