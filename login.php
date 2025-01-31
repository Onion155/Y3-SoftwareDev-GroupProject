<?php

print_r($_REQUEST);
/*
if($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["pwd"];
}

if(isset($_REQUEST["username"]) && isset($_REQUEST["password"])) {
    $username = $_REQUEST["username"];
    $password = $_REQUEST["password"];
    $user = fetchUser($username);

    if($password == $user->password) {
        $_SESSION["user"] = $user;
        exit();
    }
}
    */
?>