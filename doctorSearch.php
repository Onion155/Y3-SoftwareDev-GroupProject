<?php
require_once "model/doctor.php";
require_once "model/account.php";
require_once "model/patient.php";
require_once "model/patientRecord.php";
require_once "model/api/dataAccess-db.php";
session_abort();
session_start();

if (!isset($_SESSION["account"])) {
    header("Location: index.php");
}

$doctor = fetchDoctor($account->id);
$_SESSION["doctor"] = $doctor;
$patients = array();

if (isset($_GET["search"]) && isset($_GET["filter"])) {
    $search = htmlspecialchars($_GET["search"]);
    $filter = htmlspecialchars($_GET["filter"]);
    $_SESSION["patient-filter"] = $filter;

    if (!empty($search) && $filter == "firstName") {
        $patients = fetchPatientsByFirstName($doctor->id, $search);
    } else if (!empty($search) && $filter == "lastName") {
        $patients = fetchPatientsByLastName($doctor->id, $search);
    }  else if (!empty($search) && $filter == "nhs") {
        $patients = fetchPatientsByNHS($doctor->id, $search);
    } else {
        $patients = fetchPatients($doctor->id);
    }
}

require_once "view/doctorSearch_view.php";
?>