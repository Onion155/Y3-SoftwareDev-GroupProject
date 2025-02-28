<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Expert Patient Dashboard</title>
  <link rel="stylesheet" href="./style/record_styles.css">
</head>

<body>
  <header>
<a href="./index.php">
    <img id="logo" src="other/logo.png" alt="My Kidney Buddy mascot logo">
</a>
    <h1>eGFR Calculator</h1>
    <p id="welcome"><?= "Welcome $patient->firstName $patient->lastName" ?></p>
    <form method="POST" action="./requestHandler.php?action=signout">
      <button type="submit">Sign Out</button>
    </form>
  </header>
  <div class="box-container">
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
    egfrReadings = <?php echo json_encode($egfrReadings) ?>;
    bpReadings = <?php echo json_encode($bpReadings) ?>;
    dateLabels = <?php echo json_encode($dateLabels) ?>;
    document.getElementById("egfr-chart");
</script>
<script src ="script/charts.js"></script>
</body>
</html>