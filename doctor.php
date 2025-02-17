<?php
require_once "model/patient.php";
require_once "model/patientRecord.php";
require_once "model/api/dataAccess-db.php";

$patient = fetchPatients(1)[0];
$patientRecords = fetchPatientRecords(1);
$previousReadings = [];
$readingLabels = [];
$eGFRValue = [];

for ($i=0; $i<count($patientRecords); $i++) {
    $previousReadings[$i] = $patientRecords[$i]->eGFR;
    $readingLabels[$i] = $patientRecords[$i]->dateCreated;
    $eGFRValue[$i] = array_keys($patientRecords[$i]->getEGFRValuePair())[0];
}
require_once "view/doctor_view.php";
?>