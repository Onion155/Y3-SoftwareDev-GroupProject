<?php
session_start();

if (isset($_SESSION["error-message"])) {
    $errorMessage = $_SESSION["error-message"];
    unset($_SESSION["error-message"]);
} else {
    $errorMessage = null;
}
require_once "./view/home_view.php";
require_once "login.php";
//index.php is the main website entry point
?>