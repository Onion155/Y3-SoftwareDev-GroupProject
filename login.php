<?php
require_once "./model/account.php";
require_once "./model/api/dataAccess-db.php";;

//Code starts here -----------------------------------------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $_SESSION["error-message"] = validateLogin($email, $password);
} else {
    $_SESSION["error-message"] = "Please enter both email and password";
}
}

//Functions -----------------------------------------------------------------------------------------------------------
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
    header("Location: dashboard.php");
    exit();
}


function checkLoginAttempts($account) {
    $email = $account->email;
    $lastLoginTime = new DateTime($account->lastLoginTime);
    $lastLockTime = new DateTime($account->lastLockTime);
    $loginAttempts = $account->loginAttempts;

    $loginHour = 1; //User login attempts reset every $loginhour
    $lockHour = 5; //User is locked for 24 hours
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