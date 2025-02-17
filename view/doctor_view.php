<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>eGFR Calculator- Doctor</title>
    <link rel="stylesheet" href="./style/styles.css">
</head>
<body>
    <header>
        <img id="logo" src="other/logo.png" alt ="My Kidney Buddy mascot logo">
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
            </div>
            <div id="box-right">
              <table class="content-table">
                <thead>
                  <tr>
                    <th>Date Created</th>
                    <th>Blood Pressure</th>
                    <th>eGFR</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td></td>
                    <td><?=""?></td>
                  </tr>
                </tbody>
              </table>
            </div>
        </div>
        <!--
    <form id="egfr-form">
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required>

        <label for="sex">Sex:</label>
        <select id="sex" name="sex" required>
            <option value="">Select...</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>

        <label for="ethnicity">Ethnicity:</label>
        <select id="ethnicity" name="ethnicity" required>
            <option value="">Select...</option>
            <option value="black">Black</option>
            <option value="non-black">Non-Black</option>
        </select>

        <label for="creatinine">Serum Creatinine (micromol/l):</label>
        <input type="number" step="0.01" id="creatinine" name="creatinine" required>
        <br>
        <button type="submit">Calculate eGFR</button>
    </form>

    <div id="result"></div>
-->
    <script src= "https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    console.log(<?php $readingLabels; ?>)
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
      options: { scales: { y: {
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
