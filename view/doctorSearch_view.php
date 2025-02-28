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
        <div id="table-container">
          <table class="table-content">
            <thead>
              <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>NHS Number</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php for ($i = 0; $i < count($patients); $i++): ?>
                <tr>
                  <td><?= $patients[$i]->firstName ?></td>
                  <td><?= $patients[$i]->lastName ?></td>
                  <td><?= $patients[$i]->NHSNumber ?></td>
                  <td>
                    <form method="POST" action="./requestHandler.php?action=setPatientSession">
                      <button type="submit">Calculate eGFR</button>
                      <input type="hidden" name="patientId" value="<?= $patients[$i]->id ?>">
                    </form>
                  </td>
                </tr>
              <?php endfor ?>
            </tbody>
          </table>
  <?php require_once "entity/patient_dialog.php" ?>
    </body>
    </html>