<?php
require_once "model/doctor.php";
require_once "model/patient.php";
require_once "model/patientRecord.php";
require_once "model/api/dataAccess-db.php";

$patient = $_SESSION["patient"];
    $doctor = $_SESSION["doctor"];
    $patientRecords = fetchPatientRecords($patient->id);
    $egfrReadings = array();
    $bpReadings = array();

    for ($i=0; $i<count($patientRecords); $i++) {
        array_push($egfrReadings, $patientRecords[$i]->eGFR);
        if ($patientRecords[$i]->bloodPressure != null) {
            array_push($bpReadings, $patientRecords[$i]->bloodPressure);
        }
        $dateLabels[$i] = $patientRecords[$i]->dateCreated;
        $egfrValue[$i] = array_keys($patientRecords[$i]->getEGFRValuePair())[0];
    }
    require_once "view/doctorPatient_view.php";
?>