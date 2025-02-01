<?php
class User {
    private $id;
    private $userName;
    private $userPassword;
    private $userEmail;
    private $role;

    function __get($name) {
        return $this->$name;
      }
    
      function __set($name,$value) {
        $this->$name = $value;
      }
    
}
?>