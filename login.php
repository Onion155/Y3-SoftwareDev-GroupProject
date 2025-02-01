<?php
require_once "./model/user.php";
require_once "./model/dataAccess-db.php";

//checks if request has come through
if(isset($_REQUEST["username"]) && isset($_REQUEST["password"])) {

    $username = $_REQUEST["username"];
    $password = $_REQUEST["password"];
    
    $user = fetchUser($username);
    
    if ($user === null) {
        require_once "./view/login_view.html";
    }
    else {
        $role = $user->role;
        $_SESSION["user"] = $user;
        $_SESSION["role"] = $role;
    }
}
?>