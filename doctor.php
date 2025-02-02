<?php
require_once "./model/patient.php";
require_once "./model/patientRecord.php";
require_once "./model/data/dataAccess-db.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_SESSION['patient']->id;
    $patientRecords = fetchPatientRecords($id);
    echo json_encode($patientRecords);
}
?>