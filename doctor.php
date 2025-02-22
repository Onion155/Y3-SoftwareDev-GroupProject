<?php
require_once "model/doctor.php";
require_once "model/account.php";
require_once "model/patient.php";
require_once "model/patientRecord.php";
require_once "model/api/dataAccess-db.php";
session_abort();
session_start();

$account = $_SESSION["account"];
$doctor = fetchDoctor($account->id);
$patients = fetchPatients($doctor->id);
$patient = fetchPatients(1)[0];
$_SESSION["patient"] = $patient;
$patientRecords = fetchPatientRecords($patient->id);
$previousReadings = [];
$readingLabels = [];
$egfrValue = [];

$isChartEmpty = false;
if(!empty($patientRecords)) {
for ($i=0; $i<count($patientRecords); $i++) {
    $egfrReadings[$i] = $patientRecords[$i]->eGFR;
    $bpReadings[$i] = $patientRecords[$i]->bloodPressure;
    $dateLabels[$i] = $patientRecords[$i]->dateCreated;
    $egfrValue[$i] = array_keys($patientRecords[$i]->getEGFRValuePair())[0];
}
} else {
    $isChartEmpty = true;
}

if(isset($_SESSION["error-message"])) {
$errorMessage = $_SESSION["error-message"];
} else {
$errorMessage = null;
}
unset($_SESSION["error-message"]);
require_once "view/doctor_view.php";
?>