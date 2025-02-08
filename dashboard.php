<?php
require_once "./model/account.php";

session_start();
    switch ($_SESSION["account"]->role) {
        case "doctor": require_once "./view/doctor_view.html";
            break;
        case "patient": require_once "./view/patient_view.html";
            break;
        case "expert patient": //NOT DONE
            break;

            default: session_unset();
            header("Location: index.php");
        }
?>