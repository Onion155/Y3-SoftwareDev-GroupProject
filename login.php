<?php
require_once "./model/user.php";
require_once "./model/data/dataAccess-db.php";

//checks if request has come through
if (isset($_REQUEST["username"]) && isset($_REQUEST["password"])) {

    $username = $_REQUEST["username"];
    $password = $_REQUEST["password"];

    $user = fetchUser($username);
    if (is_null($user)) {
        echo "Username doesnt exist";
    } else {

        if ($password == $user->userPassword) {
            $_SESSION["user"] = $user;
        } else {
            echo "Wrong password";
        }
        
    }

}
?>