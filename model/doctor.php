<?php
class Doctor {
    private $id;
    private $firstName;
    private $lastName;
    private $GMCNumber;
    private $accountId;
    private $adminId;
    public function toArray() {
      return get_object_vars($this);
    }
    function __get($name) {
        return $this->$name;
      }
    
      function __set($name,$value) {
        $this->$name = $value;
      }
}
?>