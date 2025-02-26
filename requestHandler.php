<?php
require_once "model/account.php";
require_once "model/patient.php";
require_once "model/patientRecord.php";
require_once "model/api/dataAccess-db.php";

session_start();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else if (isset($_POST['action'])) {
    $action = $_POST['action'];
} else {
    throw new Exception("GET action name couldn't be found");
}

switch ($action) {
    case "login":
        if (isset($_POST["email"]) && isset($_POST["password"])) {
            $email = htmlspecialchars($_POST["email"]);
            $password = $_POST["password"];
            echo validateLogin($email, $password);
        } else {
            echo "Please enter both email and password";
        }
        break;

    case "signout":
        session_unset();
        header("Location: index.php");
        break;

    case "getPatients":
        $doctorID = $_SESSION['account']->id;
        echo json_encode(fetchPatients($doctorID));
        break;

    case "addPatientRecord":
        if (isset($_POST["creatinine"]) && isset($_POST["blood-pressure"])) {
            $creatinine = $_POST["creatinine"];
            $bloodPressure = $_POST["blood-pressure"];
            $patient = $_SESSION["patient"];
            $_SESSION["error-message"] = verifyRecords($patient, $creatinine, $bloodPressure);
            header("Location: dashboard.php");
        } else {
            $_SESSION["error-message"] = "Please enter both creatinine and blood pressure";
            header("Location: dashboard.php");
        }
        break;

    case "deletePatientRecords":
        if (isset($_POST["checkbox"])) {
            $ids = $_POST["checkbox"];
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
        if ($_SESSION["account"]->role === "doctor") {
            $doctorID = $_SESSION["user"]->id;
            echo json_encode(fetchPatientRecords($patientID, $doctorID));
        } else {
            echo "UNSUPPORTED function: getPatientRecords() - User is not a doctor";
        }
        break;

    case "getUsername":
        echo $_SESSION["account"]->email;
        break;
    default:
        throw new Exception("GET action name couldn't be found");
}

if (isset($_POST['patientid'])) {
    $_SESSION['patientid'] = $_POST['patientid'];
}

if (isset($_POST['egfr'])) {
    $eGFR = $_POST['egfr'];
    $patientID = $_SESSION['patientid'];
    insertPatientRecord($patientID, $eGFR);
}

function verifyRecords($patient, $creatinine, $bloodPressure)
{
    if (!filter_var($creatinine, FILTER_VALIDATE_FLOAT) && !filter_var($bloodPressure, FILTER_VALIDATE_FLOAT)) {
        return "Invalid creatinine and blood pressure";
    } else if ($creatinine < 0 && $bloodPressure < 0) {
        return "Creatinine and blood pressure can't be negative";
    } else if (!filter_var($creatinine, FILTER_VALIDATE_FLOAT)) {
        return "Invalid creatinine";
    } else if ($creatinine < 0) {
        return "Creatinine can't be negative";
    }

    if (!filter_var($bloodPressure, FILTER_VALIDATE_FLOAT)) {
        return "Invalid blood pressure";
    } else if ($bloodPressure < 0) {
        return "Blood pressure can't be negative";
    }
    $eGFR = $patient->calculateEGFR($creatinine);
    insertPatientRecord($patient->id, $eGFR, $bloodPressure, "medium");
    header("Location: dashboard.php");
    exit();
}
function validateLogin($email, $password) {

    //Checks if email format is valid
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        return "Invalid email address";
    }

    //Checks if email exists in the database
    $account = fetchAccount($email);
    if (is_null($account)) {
    return "Email address doesn't exist";
    }

    //Checks login attempts and last time account was locked
    if(checkLoginAttempts($account) === false) {
        return "Your account has been locked for 24 hours";
    }

    $account = fetchAccount($email); //Updates account to fetch latest login attempts
    //Checks if password is matching
    $passwordHash = $account->passwordHash;
    $loginAttempts = $account->loginAttempts;
    if(!password_verify($password, $passwordHash)) {
        setLoginAttempts($email, $loginAttempts + 1);
        $account = fetchAccount($email); //Refetches account
        return "Incorrect passsword";
    }

    //Once all if statements have been passed
    setLoginAttempts($email, 0);
    $_SESSION["account"] = $account;
    echo "success";
}


function checkLoginAttempts($account) {
    $email = $account->email;
    $lastLoginTime = new DateTime($account->lastLoginTime);
    $lastLockTime = new DateTime($account->lastLockTime);
    $loginAttempts = $account->loginAttempts;

    $loginHour = 5; //User login attempts reset every $loginhour
    $lockHour = 24; //User is locked for 24 hours
    $loginAttemptsAllowed = 15; //How many attempts the user has before being locked out
    $currentDateTime = new DateTime();
    $formattedCurrentDateTime = $currentDateTime->format('Y-m-d H:i:s');
   
    
    $hoursPastLogin = -($lastLoginTime->getTimestamp() - $currentDateTime->getTimestamp()) / 3600;
    $hoursPastLock = -($lastLockTime->getTimestamp() - $currentDateTime->getTimestamp()) / 3600;

    //sets lastLoginTime to current DateTime if user never logged in before
    if(is_null($account->lastLoginTime)) { 
        setLoginTime($email, $formattedCurrentDateTime);
    }

    //Checks if lock time is not enabled and its time to reset login attempts
    if(is_null($account->lastLockTime) && $hoursPastLogin >= $loginHour) {
        setLoginTime($email, $formattedCurrentDateTime);
        setLoginAttempts($email, 0); //Reset login attempts
    }

    //Checks if exceeded lock time limit
    if ($hoursPastLock >= $lockHour) {
        setLockTime($email, null); //Disables lock time
        setLoginAttempts($email, 0); //Reset login attempts
        return true;
        
    }
    
    //Enables lock time 
    //Checks if it exceeded loginAttemptsAllowed
    if ($loginAttempts >= $loginAttemptsAllowed) {
        setLockTime($email, $formattedCurrentDateTime); //Enables lock time
        return false;
    }
  


    if($hoursPastLock == null) {
        return true;
    } else {
        return false;
    }
}
?>