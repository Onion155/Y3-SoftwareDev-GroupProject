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

//If doctor creates a record
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST["creatinine"]) && isset($_POST["blood-pressure"]))
    {
        $creatinine = $_POST["creatinine"];
        $bloodPressure = $_POST["blood-pressure"];
        $message = verifyRecords($patient, $creatinine, $bloodPressure);
    }  else{
        $message = "Please enter both creatinine and blood pressure";
    }
}

function verifyRecords($patient, $creatinine, $bloodPressure) {
    if (!filter_var($creatinine, FILTER_SANITIZE_NUMBER_FLOAT)) {
        return "Invalid creatinine";
    }
    else if ($creatinine < 0) {
        return "Creatinine can't be negative";
    }

    if(!filter_var($bloodPressure, FILTER_SANITIZE_NUMBER_FLOAT)) {
        return "Invalid blood pressure";
    }
    else if ($bloodPressure < 0) {
        return "Blood pressure can't be negative";
    }
    $eGFR = $patient->calculateEGFR($creatinine);
    insertPatientRecord($patient->id, $eGFR, $bloodPressure, "medium");
    header("Location: dashboard.php");
    exit();
}

require_once "view/doctor_view.php";
?>