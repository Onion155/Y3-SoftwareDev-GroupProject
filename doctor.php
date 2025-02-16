<?php
require_once "model/patient.php";
require_once "model/patientRecord.php";
require_once "model/api/dataAccess-db.php";

$patientRecords = fetchPatientRecords(1);
$previousReadings = [];
$readingLabels = [];

for ($i = 0; $i < count($patientRecords); $i++) {
    $previousReadings[$i] = $patientRecords[$i]->eGFR;
    $readingLabels[$i] = $patientRecords[$i]->dateCreated;
}

require_once "view/doctor_view.php";
?>