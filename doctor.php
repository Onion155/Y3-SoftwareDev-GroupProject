<?php
require_once "model/doctor.php";
require_once "model/account.php";
require_once "model/patient.php";
require_once "model/patientRecord.php";
require_once "model/api/dataAccess-db.php";
session_abort();
session_start();

$doctor = fetchDoctor($account->id);
$_SESSION["doctor"] = $doctor;

if (isset($_SESSION["patient"])) {
    $patient = $_SESSION["patient"];
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
    unset($_SESSION["error-message"]);
    } else {
    $errorMessage = null;
    }
    require_once "view/doctorPatient_view.php";

} else {
    $patients = fetchPatients($doctor->id);
    require_once "view/doctorSearch_view.php";
}
?>