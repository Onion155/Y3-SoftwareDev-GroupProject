<?php
require_once "model/account.php";
require_once "model/patient.php";
require_once "model/doctor.php";
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
            $email = htmlspecialchars($_POST["email"]);
            $password = $_POST["password"];
            validateLogin($email, $password);
        break;
    case "signup":
        $email = htmlspecialchars($_POST["email"]);
        $password = $_POST["password"];
        $confirmPassword = $_POST["confirmPassword"];
        validateSignup($email, $password, $confirmPassword);
        break;
    case "signout":
        session_unset();
        header("Location: index.php");
        break;
    case "setPatientSession":
        $id = $_POST["patient-id"];
        $_SESSION["patient"] = fetchPatient($id);
        header("Location: doctorPatient.php");
        break;
    case "unsetPatientSession":
        unset($_SESSION["patient"]); 
        header("Location: dashboard.php");
        break;
    case "addPatient":
        $data = json_decode($_POST["patientData"]);
        validatePatient($data);
        break;
    case "getPatients":
        $doctorID = $_SESSION['account']->id;
        echo json_encode(fetchPatients($doctorID));
        break;
    
    case "deletePatients":
        if (isset($_POST["checkbox"])) {
            $ids = $_POST["checkbox"];
            foreach ($ids as $id) {
                deletePatient($id);
            }
            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION["error-message"] = "No patients were selected";
            header("Location: dashboard.php");
        }
        break;

    case "addPatientRecord":
            $creatinine = $_POST["creatinine"];
            $bloodPressure = $_POST["blood-pressure"];
            $patient = $_SESSION["patient"];
            $message = validateRecord($creatinine, $bloodPressure);
            if ($message == "success") {
                $eGFR = $patient->calculateEGFR($creatinine);
                insertPatientRecord($patient->id, $eGFR, $bloodPressure);
            } else {
                $_SESSION["error-message"] = $message;  
            }
            header("Location: doctorPatient.php");
        break;

        case "editPatientRecord":
            $creatinine = $_POST["creatinine"];
            $bloodPressure = $_POST["blood-pressure"];
            $recordId = $_POST["record-id"];
            $patient = $_SESSION["patient"];
            $message = validateRecord($creatinine, $bloodPressure);
            if ($message == "success") {
                $eGFR = $patient->calculateEGFR($creatinine);
                updatePatientRecord($recordId, $eGFR, $bloodPressure);
            } else {
                $_SESSION["error-message"] = $message;  
            }
            header("Location: doctorPatient.php");
        break;

    case "deletePatientRecords":
        if (isset($_POST["checkbox"])) {
            $ids = $_POST["checkbox"];
            foreach ($ids as $id) {
                deletePatientRecord($id);
            }
            header("Location: doctorPatient.php");
            exit();
        } else {
            $_SESSION["error-message"] = "No patient records were selected";
            header("Location: doctorPatient.php");
        }
        break;
        
    case "setNotes":
        $newNotes = $_GET["notes"];
        $id = $_SESSION["patient"]->id;
        if (!filter_var($newNotes, FILTER_SANITIZE_STRING)) {
            echo "Invalid notes";
        } else {
            setNotes($id, $newNotes);
            $_SESSION["patient"] = fetchPatient($id);
            echo "Notes saved";
        }
        break;

    case "getPatientRecords":
        $patientID = $_SESSION["patient"]->id;
        if ($_SESSION["account"]->role === "doctor") {
            $doctorID = $_SESSION["user"]->id;
            echo json_encode(fetchPatientRecords($patientID));
        } else {
            echo "UNSUPPORTED function: getPatientRecords() - User is not a doctor";
        }
        break;
    default:
        throw new Exception("GET action name couldn't be found: $action");
}

function validatePatient($data) {
    foreach ($data as $key => $value) {
        if (empty($value)) {
            echo "All fields are required";
            exit();
        }
    }

    $firstName = filter_var($data->firstName, FILTER_SANITIZE_STRING);
    $lastName =filter_var($data->lastName, FILTER_SANITIZE_STRING);
    $nhsNum = $data->nhs;
    $dob = $data->dob;
    $ethnicity = $data->ethnicity;
    $sex = $data->sex;
    $email = $data->email;
    $role =$data->role;

    if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        echo "Email is invalid";
        exit();
    } else if (!filter_var($nhsNum, FILTER_VALIDATE_INT) || strlen($nhsNum) != 10) {
        echo "NHS number is invalid";
        exit();
    } else if (!empty(fetchPatientWithNHS($nhsNum))) {
        echo "NHS number is already taken";
        exit();
    } else if  (!validateDate($dob, "Y-m-d")) {
        echo "Invalid date format";
        exit();
    } else {
        $patient = new Patient();
        $patient->DoB = $dob;
        $age = $patient->getAge();

        $account = fetchAccount($email);
    }

    if ($age < 18) {
        echo "Patient is too young (pediatric version coming soon)";
        exit();
    } else if (!($sex == "male" || $sex == "female")) {
        echo "Sex is invalid";
        exit();
    } else if (!($ethnicity == "black" || $ethnicity == "other")) {
        echo "Ethnicity is invalid";
        exit();
    } else if (!($role == "patient" || $role == "expert patient")) {
        echo $role;
            echo "Role is invalid";
            exit();
    } else if (!empty($account) || isset($account->passwordHash)) {
        echo "Email already taken";
        exit();
    } else {
        insertAccount($email, null, $role);
        $accountId = fetchAccount($email)->id;
        $doctorId = $_SESSION["doctor"]->id;
        insertPatient($accountId, $doctorId, $firstName, $lastName, $dob, $nhsNum, $ethnicity, $sex);
        echo "success";    
    }

}

function validateDate($dateString, $format) {
	$date = DateTime::createFromFormat($format, $dateString); 
	return $date && $date->format($format) === $dateString; 
} 

function validateRecord($creatinine, $bloodPressure)
{
    if (empty( $creatinine ) || empty( $bloodPressure )) {
        return "Please enter both creatinine and blood pressure";
    } else if (!filter_var($creatinine, FILTER_VALIDATE_FLOAT) && !filter_var($bloodPressure, FILTER_VALIDATE_FLOAT)) {
        return "Invalid creatinine and blood pressure";
    } else if ($creatinine < 0 && $bloodPressure < 0) {
        return "Creatinine and blood pressure can't be negative";
    } else if (!filter_var($creatinine, FILTER_VALIDATE_FLOAT)) {
        return "Invalid creatinine";
    } else if ($creatinine < 0) {
        return "Creatinine can't be negative";
    } else if (!filter_var($bloodPressure, FILTER_VALIDATE_FLOAT)) {
        return "Invalid blood pressure";
    } else if ($bloodPressure < 0) {
        return "Blood pressure can't be negative";
    } else {
        return "success";
    }
}
function validateLogin($email, $password) {

    if (empty($email) || empty($password)) {
        echo "Please fill in the fields";
        exit();
    } else if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        echo "Email is invalid";
        exit();
    } else {
        $account = fetchAccount($email);
    }
    if (empty($account) || is_null($account->passwordHash)) {
        echo "Account doesn't exist";
        exit();
    } else if (isAccountLocked($account)) {
        echo "This account has been temporarily locked";
        exit();
    } else if (!password_verify($password, $account->passwordHash)) {
        echo "Password is incorrect";
        updateLoginAttempts($email, $account->loginAttempts + 1);
        exit();
    } else {
        updateLoginAttempts($email, 0);
        $_SESSION["account"] = $account;
        echo "success";
    }
}

function validateSignup($email, $password, $confirmPassword) {

    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    if (empty($email) || empty($password) || empty($confirmPassword)) {
        echo "Please fill in the fields";
        exit();
    } else if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        echo "Email is invalid";
        exit();
    } else {
        $account = fetchAccount($email);
    }

    if (empty($account)) {
        echo "This email has not been assigned";
        exit();
    } else if (!is_null($account->passwordHash)) {
        echo "Email is already signed up";
        exit();
    } else if ($password !== $confirmPassword) {
        echo "Passwords do not match";
        exit();
    }
    else if (strlen($password) > 64) {
        echo "Password is too long";
        exit();
    } else if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 12) {
        echo "Password should be at least 12 characters, contain at least one upper case letter, one number, and one special character";
        exit();
    } else {
        updatePassword($email, password_hash($password, PASSWORD_DEFAULT));
        $account = fetchAccount($email);
        $_SESSION["account"] = $account;
        echo "success";
    }
}

function isAccountLocked($account) {
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
        updateLoginTime($email, $formattedCurrentDateTime);
    }
    //Checks if lock time is not enabled and its time to reset login attempts
    if(is_null($account->lastLockTime) && $hoursPastLogin >= $loginHour) {
        updateLoginTime($email, $formattedCurrentDateTime);
        updateLoginAttempts($email, 0); //Reset login attempts
    }
    //Checks if exceeded lock time limit
    if ($hoursPastLock >= $lockHour) {
        updateLockTime($email, null); //Disables lock time
        updateLoginAttempts($email, 0); //Reset login attempts
        return false;
    }
    //Enables lock time 
    //Checks if it exceeded loginAttemptsAllowed
    if ($loginAttempts >= $loginAttemptsAllowed) {
        updateLockTime($email, $formattedCurrentDateTime); //Enables lock time
        return true;
    }

    if($hoursPastLock == null) {
        return false;
    }
}