<?php
require_once "model/user.php";
require_once "model/patient.php";
require_once "model/patientRecord.php";
require_once "model/api/dataAccess-db.php";

session_start();

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case "getPatients":
            $doctorID = $_SESSION['user']->id;
            $_SESSION['patient'] = fetchPatients($doctorID)[0];
            echo json_encode($_SESSION['patient']);
            break;

        case "getPatientRecords":
            $id = $_SESSION['patient']->id;
            echo json_encode(fetchPatientRecords($id));
            break;

        case "getUsername":
            echo $_SESSION['user']->userName;
        break;

        default: throw new Exception("GET action name couldn't be found");
    }
}

if (isset($_POST['egfr'])) {
    $eGFR = $_POST['egfr'];
    $patientID = $_SESSION['patient']->id;
    insertPatientRecord($patientID, $eGFR);
}

?>