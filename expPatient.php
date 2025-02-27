<?php
require_once "model/account.php";
require_once "model/patient.php";
require_once "model/patientRecord.php";
require_once "model/api/dataAccess-db.php";
session_abort();
session_start();

$account = $_SESSION["account"];
$patient = fetchPatient($account->id);
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
require_once "view/expPatient_view.php";
?>