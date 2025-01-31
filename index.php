<?php //index.php is the main website entry point and controller
session_start();
require_once "./model/user.php";
require_once "./model/dataAccess-db.php";

$status = false;

//Checks if user is logged in
if(!isset($_SESSION["user"])) {
    require_once "./view/login_view.html";
    exit();
}
elseif($_SESSION["user"]->role == "doctor") {
exit();
}
elseif($_SESSION["role"]->role == "patient") {
exit();
}
elseif($_SESSION["role"]->role == "expert patient") {
exit();
}
else {
    throw new Exception("User role doesn't exist");
exit();
}

?>
