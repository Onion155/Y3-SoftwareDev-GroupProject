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
$patients = fetchPatients($doctor->id);
require_once "view/doctorSearch_view.php";
?>x