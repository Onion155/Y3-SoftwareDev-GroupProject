<?php
class User {
    private $userName;
    private $userPassword;
    private $userEmail;

    function __get($name) {
        return $this->$name;
      }
    
      function __set($name,$value) {
        $this->$name = $value;
      }
    
}
?>