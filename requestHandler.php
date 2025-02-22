<?php
require_once "model/account.php";
require_once "model/patient.php";
require_once "model/patientRecord.php";
require_once "model/api/dataAccess-db.php";

session_start();

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case "signout":
            session_unset();
            header("Location: index.php");
            break;
        case "getPatients":
            $doctorID = $_SESSION['account']->id;
            echo json_encode(fetchPatients($doctorID));
            break;

            case "setNotes":
                $newNotes = $_GET['notes'];
                if (!filter_var($newNotes, FILTER_SANITIZE_STRING)) {
                    echo "Invalid notes";
                } else {
                    setNotes($_SESSION['patient-id'], $newNotes);
                    echo "Notes saved";
                }
            break;

        case "getPatientRecords":
            $patientID = $_SESSION['patientid'];
            if($_SESSION['account']->role === "doctor") {
            $doctorID = $_SESSION['user']->id;
            echo json_encode(fetchPatientRecords($patientID, $doctorID));
            } else {
                echo "UNSUPPORTED function: getPatientRecords() - User is not a doctor";
            }
            break;

        case "getUsername":
            echo $_SESSION['account']->email;
        break;
        default: throw new Exception("GET action name couldn't be found");
    }
}

if (isset($_POST['patientid'])) {
    $_SESSION['patientid'] = $_POST['patientid'];
}

if (isset($_POST['egfr'])) {
    $eGFR = $_POST['egfr'];
    $patientID = $_SESSION['patientid'];
    insertPatientRecord($patientID, $eGFR);
}

?>