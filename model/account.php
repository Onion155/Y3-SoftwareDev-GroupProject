<?php
class Account {
    private $id;
    private $passwordHash;
    private $email;
    private $loginAttempts;
    private $lastLockTime;
    private $lastLoginTime;
    private $role;

    function __get($name) {
        return $this->$name;
      }
    
      function __set($name,$value) {
        $this->$name = $value;
      }
    
}
?>