<?php
require_once "./model/account.php";

session_start();
$account = $_SESSION["account"];
    switch ($account->role) {
        case "doctor":
            require_once "doctorSearch.php";
            break;
        case "patient": require_once "patient.php";
            break;
        case "expert patient": require_once "expPatient.php";
            break;

            default: session_unset();
            header("Location: index.php");
        }
?>