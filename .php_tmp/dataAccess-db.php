<?php

//This application is temporarily using SQLite for testing purposes.
//It is a self-contained database with PHP by default and does not replace a server database.
//The website my-kidney-buddy.co.uk will contain a secure server-based database.
 

//Connect to the database file
  $dbPath = "model\data\medicalRoles.db";
  $pdo = new PDO("sqlite:$dbPath");

//Find and fetch the user by the user username or email
  function fetchAccount($email) {
  global $pdo;
  $statement = $pdo->prepare('SELECT * FROM account WHERE email = ?');
  $statement->execute([$email]);
  $result = $statement->fetchALL(PDO::FETCH_CLASS, 'Account');
  if (count($result) == 0) {
    return null;
  } else {
    return $result[0];
  }
  }

  function fetchPatients($doctorID) {
    global $pdo;
    $statement = $pdo->prepare('SELECT * FROM patient WHERE doctorID =  ?');
    $statement->execute([$doctorID]);
    $result = $statement->fetchALL(PDO::FETCH_CLASS, 'Patient');
    return $result;
  }

  //Fetches all patient records of a patient
  function fetchPatientRecords($patientID, $doctorID) {
    global $pdo;
    $statement = $pdo->prepare('SELECT pr.* FROM patientRecord pr
                                       JOIN patient p on pr.patientID = p.id
                                       WHERE pr.patientID = ? and p.doctorID = ?');
    $statement->execute([$patientID, $doctorID]);
    $result = $statement->fetchALL(PDO::FETCH_CLASS, 'PatientRecord');
    return $result;
  }

  //Currently only inserts eGFR
  //The database supports priority, note, blood pressure
  //The database stores the latest current data every time patient data is inserted
  function insertPatientRecord($patientID, $eGFR) {
    global $pdo;
    $statement = $pdo->prepare('INSERT INTO patientRecord (patientID, eGFR) VALUES (?, ?)');
    $statement->execute([$patientID, $eGFR]);
  }

  //Login attempts, time user is locked out, and last time user logged in
  function setLoginAttempts($email, $loginAttempts) {
    global $pdo;
    $statement = $pdo->prepare('UPDATE account SET loginAttempts = ? WHERE (email = ?)');
    $statement->execute([$loginAttempts, $email]);
  }

  function setLoginTime($email, $loginTime) {
    global $pdo;
    $statement = $pdo->prepare('UPDATE account SET lastLoginTime = ? WHERE (email = ?)');
    $statement->execute([$loginTime, $email]);
  }

  function setLockTime($email, $lockTime) {
    global $pdo;
    $statement = $pdo->prepare('UPDATE account SET lastLockTime = ? WHERE (email = ?)');
    $statement->execute([$lockTime, $email]);
  }
?>