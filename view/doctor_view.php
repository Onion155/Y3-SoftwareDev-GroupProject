<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>eGFR Calculator- Doctor</title>
  <link rel="stylesheet" href="./style/doctor_view.css">
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
  <div class="box-container">
    <div id="box-top">
      <p>Patient name: <?= "$patient->firstName $patient->lastName" ?> | NHS number: <?= $patient->NHSNumber?></p>
      <p>Age: <?= $patient->getAge() ?> | Sex: <?= $patient->sex ?> | Ethnicity: <?= ($patient->isBlack == 1) ? "black" : "not black" ?></p>
    </div>
    <div class="box-bottom">
      <div id="box-left">
      <div id="chart-container">
        <?php if(!$isChartEmpty): ?>
        <canvas id="egfr-chart"></canvas>
        <canvas id="bp-chart"></canvas>
        <?php else: ?>
        <text>There is no data to load the graphs</text>
        <?php endif ?>
        </div>
        <div id="notes-container">
        <textarea id="doctor-notes" maxlength="600"
          placeholder="Type down your notes here... (max 600 characters)"><?= $patient->notes ?></textarea>
          <?php if($patient->notes !== ''): ?>
          <text id="notes-save-status">Notes loaded</text>
          <?php else: ?>
            <text id="notes-save-status">There aren't any notes to load</text>
          <?php endif ?>
          </div>
      </div>
      <div id="box-right">
      <form method="POST" action="requestHandler.php?action=deletePatientRecords">
        <div id="action-container">
          <p>Patient Records</p>
          <text id="error-message"><?= $errorMessage ?></text>
      <button id="delete-button" type="submit">Delete selected</button>
        </div>
        <div id="table-container">
          <table class="table-content">
            <thead>
              <tr>
                <th>Date Created (yyyy-mm-dd)</th>
                <th>Blood Pressure (mmHg)</th>
                <th>eGFR (ml/min/1.73m<sup>2</sup>)</th>
                <th>eGFR Value</th>
                <th><input id="select_all_ids" type="checkbox"}"></th>
              </tr>
            </thead>
            <tbody>
              <?php for ($i = 0; $i < count($patientRecords); $i++): ?>
                <tr>
                  <td><?= $patientRecords[$i]->dateCreated ?></td>
                  <td><?= $patientRecords[$i]->bloodPressure ?></td>
                  <td><?= $patientRecords[$i]->eGFR ?></td>
                  <td><?= $egfrValue[$i] ?></td>
                  <td><input class="checkbox_ids" name="checkbox[]" type="checkbox" value="<?= $patientRecords[$i]->id ?>"></td>
                </tr>
              <?php endfor ?>
            </tbody>
          </table>
          </form>
        </div>
        <div id="form-container">
          <form id="egfr-form" method="POST" action="requestHandler.php?action=addPatientRecord">
            <div id="input-container">
              <label for="creatinine">Serum Creatinine</label>
              <div id="input-content">
                <input type="text" id="creatinine" name="creatinine" required>
                <text>micromol/l</text>
              </div>
            </div>
            <div id="input-container">
              <label for="blood-pressure">Blood Pressure</label>
              <div id="input-content">
                <input type="text" id="blood-pressure" name="blood-pressure" required>
                <text>mmHg</text>
              </div>
            </div>
            <button type="submit">Create record</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>

  $("#select_all_ids").on('change', function() {
    $(".checkbox_ids").prop('checked', $(this).prop('checked'))
  });
    </script>
  <script>
    egfrReadings = <?php echo json_encode($egfrReadings) ?>;
    bpReadings = <?php echo json_encode($bpReadings) ?>;
    dateLabels = <?php echo json_encode($dateLabels) ?>;
    document.getElementById("egfr-chart").innerText("hi");
</script>
<script src ="script/charts.js"></script>
<script src ="script/notes.js"></script>
</body>
</html>