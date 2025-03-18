<?php
require_once "model/account.php";
require_once "model/patient.php";
require_once "model/patientRecord.php";
require_once "model/api/dataAccess-db.php";
session_abort();
session_start();

$account = $_SESSION["account"];
$patient = fetchPatientWithAccountId($account->id);
$_SESSION["patient"] = $patient;
$patientRecords = fetchPatientRecords($patient->id);
$egfrReadings = array();
$bpReadings = array();
$bpDateLabels = array();
$i = 0;
for ($i ; $i < count($patientRecords); $i++) {
    array_push($egfrReadings, $patientRecords[$i]->eGFR);
    if ($patientRecords[$i]->bloodPressure != null) {
        array_push($bpReadings, $patientRecords[$i]->bloodPressure);
        array_push($bpDateLabels, $patientRecords[$i]->dateCreated);
    }
    $egfrDateLabels[$i] = $patientRecords[$i]->dateCreated;
    $egfrValue[$i] = array_keys($patientRecords[$i]->getEGFRValuePair())[0];
}
if (count($patientRecords) > 1) {
$egfrDescription = current($patientRecords[$i-1]->getEGFRValuePair());
}

require_once "view/expPatient_view.php";
?>