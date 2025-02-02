<?php
require_once "./model/user.php";

session_start();
    switch ($_SESSION["user"]->role) {
        case "doctor": require_once "./view/doctor_view.html";
            break;
        case "patient": require_once "./view/patient_view.html";
            break;
        case "expert patient": //NOT DONE
            break;
            default: header("Location: login.php");
        }
?>