<?php
require_once "./model/user.php";
require_once "./model/patient.php";
require_once "./model/data/dataAccess-db.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    $user = $_SESSION['user'];
    if ($user->role == "doctor") {
        $doctorID = $user->id;
        $patient = fetchPatients($doctorID)[0];
        //Temporarily gets record from the first patient
        //It stores patient in a session to grab patient records from
        $_SESSION['patient'] = $patient;
        echo json_encode($patient);
    }
}

if (isset($_POST['egfr'])) {
    $eGFR = $_POST['egfr'];
    $patientID = $_SESSION['patient']->id;
    insertPatientRecord($patientID,$eGFR);
}
?>