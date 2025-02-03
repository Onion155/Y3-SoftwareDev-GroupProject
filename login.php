<?php
ob_start();
require_once "./model/user.php";
require_once "./model/api/dataAccess-db.php";
require_once "./view/login_view.html";
session_start();

if(isset($_REQUEST["signout"])) {
    session_unset();
    header("Location: login.php");
    }    

    if(isset($_SESSION["user"])) { //If the user goes to the login url while signed in
        header("Location: index.php");
    }

if (isset($_REQUEST["username"]) && isset($_REQUEST["password"])) { //checks if request has come through

    $username = $_REQUEST["username"];
    $password = $_REQUEST["password"];

    $user = fetchUser($username);
    if (is_null($user)) {
        $message = "username doesnt exist";
    } else {

        if ($password == $user->userPassword) {
            $_SESSION["user"] = $user;
        } else {
            $message = "wrong password";
        }
    }
    header("Location: login.php?message=$message");
}
ob_end_flush();
?>