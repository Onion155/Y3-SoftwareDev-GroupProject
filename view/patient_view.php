<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Patient Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./style/record_styles.css">
</head>

<body>
  <header>
    <a href="./index.php">
      <img id="logo" src="other/logo.png" alt="My Kidney Buddy mascot logo">
    </a>
    <div class="header-container">
      <div class="header-content">
        <h2>My Kidney Buddy</h2>
        <h4 id="welcome"><?= "Welcome $patient->firstName $patient->lastName" ?></h4>
      </div>
      <div class="navigation-menu">
        <a href="./index.php">
          <h4>Home</h4>
        </a>
        <form method="POST" action="./requestHandler.php?action=signout">
          <button class="signout-button" type="submit">
            <h4>Sign out</h4>
          </button>
        </form>
      </div>
    </div>
  </header>
  <div class="box-container">
    <?php if (count($patientRecords) > 0): ?>
    <h2>Your Current Kidney Health</h2>
    <div class="results-container">
      <h4><?= $egfrDescription ?>
        <h4>
    </div>
    <h2>Record History</h2>
    <div id="table-container">
      <table id="patient-table" class="table-content">
        <thead>
          <tr>
            <th>Date Created (yyyy-mm-dd)</th>
            <th>Blood Pressure (mmHg)</th>
            <th>eGFR (ml/min/1.73m<sup>2</sup>)</th>
            <th>eGFR Value</th>
          </tr>
        </thead>
        <tbody>
          <?php for ($i = 0; $i < count($patientRecords); $i++): ?>
            <tr>
              <td><?= $patientRecords[$i]->dateCreated ?></td>
              <td><?= $patientRecords[$i]->bloodPressure ?></td>
              <td><?= $patientRecords[$i]->eGFR ?></td>
              <td><?= $egfrValue[$i] ?></td>
            </tr>
          <?php endfor ?>
        </tbody>
      </table>
      </form>
    </div>
    <?php else: ?>
      <p> You currently have no kidney health results. </p>
    <?php endif ?>
    <?php if (sizeof($egfrReadings) > 2): ?>
      <div id="chart-container">
        <h4>eGFR History Chart</h4>
        <canvas id="egfr-chart"></canvas>
      </div>
    <?php endif ?>
    <?php if (sizeof($bpReadings) > 2): ?>
      <div id="chart-container">
        <h4>Blood Pressure History Chart</h4>
        <canvas id="bp-chart"></canvas>
      </div>
    <?php endif ?>
    <span id="bottom-text">
      <p>© 2025 My Kidney Buddy. All rights reserved.</p>
    </span>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    egfrReadings = <?php echo json_encode($egfrReadings) ?>;
    bpReadings = <?php echo json_encode($bpReadings) ?>;
    dateLabels = <?php echo json_encode($dateLabels) ?>;
    document.getElementById("egfr-chart");
  </script>
  <script src="script/charts.js"></script>
</body>

</html>