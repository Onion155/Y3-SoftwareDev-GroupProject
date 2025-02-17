<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>eGFR Calculator- Doctor</title>
  <link rel="stylesheet" href="./style/styles.css">
</head>

<body>
  <header>
    <img id="logo" src="other/logo.png" alt="My Kidney Buddy mascot logo">
    <h1>eGFR Calculator</h1>
    <select id="patient-dropdown" name="patients" required></select>
    <p id="welcome"></p>
    <form method="POST" action="./login.php">
      <button name="signout" type="submit">Sign Out</button>
    </form>
  </header>
  <div class="doctor-container">
    <div id="box-left">
      <canvas id="egfr-chart" width="400" height="200"></canvas>
      <textarea maxlength="600"
        placeholder="Type down your notes here... (max 600 characters)"><?= $patient->notes ?></textarea>
    </div>
    <div id="box-right">
      <div id="table-container">
        <table class="table-content">
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
                <td><?= $eGFRValue[$i] ?></td>
              </tr>
            <?php endfor ?>
          </tbody>
        </table>
      </div>
      <div id="form-container">
        <form id="egfr-form" method = "POST">
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
          <?php if (isset($message)): ?>
            <p id="error-message"><?= $message ?></p>
          <?php endif ?>
          <button type="submit">Create record</button>
        </form>
      </div>
      <div id="result"></div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    ctx = document.getElementById("egfr-chart").getContext("2d");
    egfrChart = new Chart(ctx, {
      type: "line",
      data: {
        labels: <?php echo json_encode($readingLabels); ?>,
        datasets: [
          {
            label: "eGFR over Time",
            borderColor: "rgba(75, 192, 192, 1)",
            fill: false,
            tension: 0.1,
            data: <?php echo json_encode($previousReadings); ?>,
          },
        ],
      },
      options: {
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: false,
            title: {
              display: true,
              text: "eGFR (mL/min/1.73m²)",
            },
          },
        },
      },
    });

  </script>
</body>

</html>