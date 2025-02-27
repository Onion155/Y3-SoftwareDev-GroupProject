<?php

//This application is temporarily using SQLite for testing purposes.
//It is a self-contained database with PHP by default and does not replace a server database.
//The website my-kidney-buddy.co.uk will contain a secure server-based database.


//Connect to the database file
$dbPath = "model\data\medicalRoles.db";
$pdo = new PDO("sqlite:$dbPath");

//Find and fetch the user by the user username or email
function fetchAccount($email)
{
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

function fetchDoctor($accountId)
{
  global $pdo;
  $statement = $pdo->prepare('SELECT * FROM doctor WHERE accountId = ?');
  $statement->execute([$accountId]);
  $result = $statement->fetchALL(PDO::FETCH_CLASS, 'Doctor');
  if (count($result) == 0) {
    return null;
  } else {
    return $result[0];
  }
}

function setNotes($patientId, $notes)
{
  global $pdo;
  $statement = $pdo->prepare('UPDATE patient SET notes = ? WHERE (id = ?)');
  $statement->execute([$notes, $patientId]);
}

function fetchPatients($doctorId)
{
  global $pdo;
  $statement = $pdo->prepare('SELECT * FROM patient WHERE doctorId =  ?');
  $statement->execute([$doctorId]);
  $result = $statement->fetchALL(PDO::FETCH_CLASS, 'Patient');
  return $result;
}

//Fetches all patient records of a patient
function fetchPatientRecords($patientId)
{
  global $pdo;
  $statement = $pdo->prepare('SELECT * FROM patientRecord WHERE patientId = ?');
  $statement->execute([$patientId]);
  $result = $statement->fetchALL(PDO::FETCH_CLASS, 'PatientRecord');
  return $result;
}

//Currently only inserts eGFR
//The database supports priority, note, blood pressure
//The database stores the latest current data every time patient data is inserted
function insertPatientRecord($patientId, $eGFR, $bloodPressure, $priority)
{
  global $pdo;
  $statement = $pdo->prepare('INSERT INTO patientRecord (patientId, eGFR, bloodPressure, priority) VALUES (?, ROUND(?,2), ?, ?)');
  $statement->execute([$patientId, $eGFR, $bloodPressure, $priority]);
}

function deletePatientRecord($id) {
  global $pdo;
  $statement = $pdo->prepare('DELETE FROM patientRecord WHERE (id = ?)');
  $statement->execute([$id]);
}

function updatePassword ($email, $password) {
  global $pdo;
  $statement = $pdo->prepare('UPDATE account SET password = ? WHERE (email = ?)');
  $statement->execute([$password, $email]);
}

//Login attempts, time user is locked out, and last time user logged in
function updateLoginAttempts($email, $loginAttempts)
{
  global $pdo;
  $statement = $pdo->prepare('UPDATE account SET loginAttempts = ? WHERE (email = ?)');
  $statement->execute([$loginAttempts, $email]);
}

function updateLoginTime($email, $loginTime)
{
  global $pdo;
  $statement = $pdo->prepare('UPDATE account SET lastLoginTime = ? WHERE (email = ?)');
  $statement->execute([$loginTime, $email]);
}

function updateLockTime($email, $lockTime)
{
  global $pdo;
  $statement = $pdo->prepare('UPDATE account SET lastLockTime = ? WHERE (email = ?)');
  $statement->execute([$lockTime, $email]);
}
?>