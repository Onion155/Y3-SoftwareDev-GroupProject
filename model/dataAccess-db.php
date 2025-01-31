<?php

//This application is temporarily using SQLite for testing purposes.
//It is a self-contained database with PHP by default and does not replace a server database.
//The website my-kidney-buddy.co.uk will contain a secure server-based database.
 

//Connect to the database file
  $pdo = new PDO('sqlite:medicalRoles.db');

//Find and fetch the user by the user username or email
  function fetchUser($userName) {
  global $pdo;
  $statement = $pdo->prepare('SELECT * FROM user WHERE userName = ?');
  $statement->execute([$userName]);
  $result = $statement->fetchALL(PDO::FETCH_CLASS, 'User');
  return $result[0];
  }

?>