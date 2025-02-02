<?php

//This application is temporarily using SQLite for testing purposes.
//It is a self-contained database with PHP by default and does not replace a server database.
//The website my-kidney-buddy.co.uk will contain a secure server-based database.
 

//Connect to the database file
  $pdo = new PDO('sqlite:./model/data/medicalRoles.db');

//Find and fetch the user by the user username or email
  function fetchUser($userName) {
  global $pdo;
  $statement = $pdo->prepare('SELECT * FROM user WHERE userName = ?');
  $statement->execute([$userName]);
  $result = $statement->fetchALL(PDO::FETCH_CLASS, 'User');
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
  function fetchPatientRecords($patientID) {
    global $pdo;
    $statement = $pdo->prepare('SELECT * FROM patientRecord WHERE patientID = ?');
    $statement->execute([$patientID]);
    $result = $statement->fetchALL(PDO::FETCH_CLASS, 'PatientRecord');
    return $result;
  }

  //Currently only inserts eGFR
  //The database supports priority, note, blood pressure
  //The database stores the latest current data every time patient data is inserted
  function insertPatientRecord($patientID, $eGFR) {
    global $pdo;
    $statement = $pdo->prepare('INSERT INTO patientRecord (patientID, eGFR) VALUES (?, ?, ?)');
    $statement->execute([$patientID, $eGFR]);
  }
?>