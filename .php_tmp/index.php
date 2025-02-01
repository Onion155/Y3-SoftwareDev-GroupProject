<?php //index.php is the main website entry point and controller
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once "./model/user.php";
require_once "./model/dataAccess-db.php";
require_once "login.php";

//Checks if user clicked sign out
if(isset($_REQUEST["signout"])) {
session_unset();
}

//Checks if user is logged in
if(isset($_SESSION["user"]) && isset($_SESSION["role"]))  {
    
    $role = $_SESSION["user"]->role;
    switch ($role) {
        case "doctor":
            require_once "./view/doctor_view.html";
            break;
        case "patient":
            require_once "./view/patient_view.html";
            break;
        case "expert patient":
            //NOT DONE
            break;
            default:
               throw new Exception("User role doesn't exist");
    }
    exit();

} else {
    
    require_once "./view/login_view.html";
    exit();
}
?>
