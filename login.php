<?php
require_once "./model/user.php";
require_once "./model/api/dataAccess-db.php";
require_once "./view/login_view.html";
session_start();

if(isset($_REQUEST["signout"])) {
    session_unset();
    header("Location: login");
    }    

    //If the user goes to the login url while signed in
    if(isset($_SESSION["user"])) {
        header("Location: index.php");
    }

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
    header("Location: index.php");
}
?>