<?php //index.php is the main website entry point and controller
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "./model/user.php";
session_start();

//Go to dashboard if logged in, else go to login page
if(isset($_SESSION["user"])) {
    header("Location: dashboard.php");
}
else {
    header("Location: login.php");
}
?>
