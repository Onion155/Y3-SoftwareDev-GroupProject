<?php
require_once "./model/account.php";

session_start();
//Session timer that logs out the user after 30 minutes
if (isset($_SESSION["session-time"]) && (time() - $_SESSION["session-time"] > 1800)) {
    session_unset();
    session_destroy();
    echo "<script>       
            alert('Your 30 minute session has expired');
            window.location.href = 'index.php';
          </script>";
    exit();
}

$account = $_SESSION["account"];
    switch ($account->role) {
        case "admin":
            require_once "adminSearch.php";
            break;
        case "doctor":
            require_once "doctorSearch.php";
            break;
        case "patient": require_once "patient.php";
            break;
        case "expert patient": require_once "expPatient.php";
            break;

            default:
            session_unset();
            session_destroy();
            header("Location: index.php");
        }
?>