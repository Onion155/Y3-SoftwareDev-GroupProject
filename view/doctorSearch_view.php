<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>eGFR Calculator- Doctor</title>
  <link rel="stylesheet" href="./style/record_styles.css">
  <link rel="stylesheet" href="./style/form_styles.css">
</head>

<body>
  <header>
<a href="./index.php">
    <img id="logo" src="other/logo.png" alt="My Kidney Buddy mascot logo">
</a>
    <h1>eGFR Calculator</h1>
    <select id="patient-dropdown" name="patients" required>
    <?php foreach($patients as $p): ?>
    <option value=<?= $p->id ?></option>Patient ID: <?= $p->id ?> | NHS: <?= $p->NHSNumber ?></option>
    <?php endforeach ?>
    </select>
    <p id="welcome"><?= "Welcome $doctor->firstName $doctor->lastName" ?></p>
    <form method="POST" action="./requestHandler.php?action=signout">
      <button type="submit">Sign Out</button>
    </form>
  </header>
  <button onclick="showPatientDialog(true)">Add Patient</button>
  <?php require_once "entity/patient_dialog.php" ?>
    </body>
    </html>