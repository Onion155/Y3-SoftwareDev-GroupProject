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
            case "addPatientRecord":
                if (isset($_POST["creatinine"]) && isset($_POST["blood-pressure"]))
                {
                    $creatinine = $_POST["creatinine"];
                    $bloodPressure = $_POST["blood-pressure"];
                    $patient = $_SESSION["patient"];
                    $_SESSION["error-message"] = verifyRecords($patient, $creatinine, $bloodPressure);
                    header("Location: dashboard.php");
                }  else{
                    $_SESSION["error-message"] = "Please enter both creatinine and blood pressure";
                    header("Location: dashboard.php");
                }
                break;
            case "deletePatientRecords":
                if (isset($_POST["checkbox"])) {
                    $ids =  $_POST["checkbox"];
                    foreach ($ids as $id) {
                    deletePatientRecord($id);
                    }
                    header("Location: dashboard.php");
                    exit();
                } else {
                    $_SESSION["error-message"] = "No patient records were selected";
                    header("Location: dashboard.php");
                }
                break;
            case "setNotes":
                $newNotes = $_GET["notes"];
                if (!filter_var($newNotes, FILTER_SANITIZE_STRING)) {
                    echo "Invalid notes";
                } else {
                    setNotes($_SESSION["patient"]->id, $newNotes);
                    echo "Notes saved";
                }
            break;

        case "getPatientRecords":
            $patientID = $_SESSION["patient"]->id;
            if($_SESSION["account"]->role === "doctor") {
            $doctorID = $_SESSION["user"]->id;
            echo json_encode(fetchPatientRecords($patientID, $doctorID));
            } else {
                echo "UNSUPPORTED function: getPatientRecords() - User is not a doctor";
            }
            break;

        case "getUsername":
            echo $_SESSION["account"]->email;
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
?>