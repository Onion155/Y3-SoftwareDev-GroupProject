<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Expert Patient Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./style/record_styles.css">
  <link rel="stylesheet" href="./style/form_styles.css">
</head>
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
  <div class="box-bottom" id="expert-patient-box">
    <div id="box-left">
      <div id="info-container">
        <h4>Current Kidney Health</h4>
        <p><?= $egfrDescription ?: "You have no results to show" ?></p>
      </div>
      <div id="form-container">
        <h4>Add eGFR Record</h4>
        <form method="POST" action="requestHandler.php?action=addPatientRecord">
          <div class="form">
            <label for="add-creatinine">Serum Creatinine (micromol/l)</label>
            <input type="hidden" id="record-id" />
            <input type="text" id="add-creatinine" />
            <label for="add-blood-pressure">Blood Pressure (mmHg)</label>
            <input type="text" id="add-blood-pressure" />
          </div>
          <p class="error-message"></p>
          <button onclick="postAddDetails()" class="green-button">Calculate</button>
        </form>
      </div>
    </div>
    <div id="box-right">
      <h4>Patient Records</h4>
      <form method="POST" action="requestHandler.php?action=deletePatientRecords">
        <div id="table-container">
          <table class="table-content">
            <thead>
              <tr>
                <th><input id="select_all_ids" type="checkbox"></th>
                <th>Date Created (yyyy-mm-dd)</th>
                <th>Blood Pressure (mmHg)</th>
                <th>eGFR (ml/min/1.73m<sup>2</sup>)</th>
                <th>eGFR Value</th>
              </tr>
            </thead>
            <tbody>
              <form id="egfr-form" method="POST" action="requestHandler.php?action=deletePatientRecords">
                <?php
                require_once "entity/delete_dialog.php";
                for ($i = 0; $i < count($patientRecords); $i++):
                  ?>
                  <tr class="record-row">
                    <td><input class="checkbox_ids" name="checkbox[]" type="checkbox"
                        value="<?= $patientRecords[$i]->id ?>"></td>
                    <td><?= $patientRecords[$i]->dateCreated ?></td>
                    <td><?= $patientRecords[$i]->bloodPressure == "" ? "N/A" : round($patientRecords[$i]->bloodPressure, 2) ?></td>
                    <td><?= round($patientRecords[$i]->eGFR, 2) ?></td>
                    <td><?= $egfrValue[$i] ?></td>
                  </tr>
                <?php endfor ?>
              </form>
            </tbody>
          </table>
      </form>
    </div>
    <div class="action-dropdown">
      <button>Actions</button>
      <div class="content">
        <a href="#" onclick="showCSVDialog(true)">Add records <span style="font-size: 10px;">(.csv)</span></a>
        <a id="edit" href="#" onclick="showEditDialog(true)">Edit record</a>
        <a id="delete" href="#" onclick="showDeleteDialog(true)">Delete selected</a>
      </div>
    </div>
  </div>
</div>
<?php if (sizeof($egfrReadings) > 2): ?>
  <div id="chart-container">
    <h4>eGFR History Chart</h4>
    <canvas id="egfr-chart"></canvas>
  </div>
    <div id="filter-container">
    <label for="egfr-date-filter">Filter by Date:</label>
    <select id="egfr-date-filter">
      <option value="all">All Data</option>
      <option value="last6months">Last 6 Months</option>
      <option value="last1year">Last 1 Year</option>
    </select>
  </div>
<?php endif ?>
<?php if (sizeof($bpReadings) > 2): ?>
  <div id="chart-container">
    <h4>Blood Pressure History Chart</h4>
    <canvas id="bp-chart"></canvas>
  </div>
      <div id="filter-container">
      <label for="bp-date-filter">Filter by Date:</label>
      <select id="bp-date-filter">
        <option value="all">All Data</option>
        <option value="last6months">Last 6 Months</option>
        <option value="last1year">Last 1 Year</option>
      </select>
    </div>
<?php endif ?>
<span id="bottom-text">
  <p>© 2025 My Kidney Buddy. All rights reserved.</p>
</span>
</div>
<?php require_once "entity/addRecordCSV_dialog.php" ?>
<?php require_once "entity/editRecord_dialog.php" ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

function postAddDetails() {
        event.preventDefault();
        const recordData = {
            creatinine: $("#add-creatinine").val(),
            bloodPressure: $("#add-blood-pressure").val(),
        };
        $.post("requestHandler.php", {
            action: "addRecord",
            recordData: JSON.stringify(recordData)
        }, function (message) {
            if (message == "success") window.location.href = "dashboard.php";
            else $(".error-message").text(message);
        });
    }

  $(".checkbox_ids").on('change', function () {
    var num = $(".checkbox_ids:checked").length
    if (num > 0) {
      $("#delete").addClass("enabled")
    } else {
      $("#delete").removeClass("enabled")
    }

    if (num == 1) {
      $("#edit").addClass("enabled")
      $("#record-id").val($(this).val());
    } else {
      $("#edit").removeClass("enabled")
    }
  });

  $("#select_all_ids").on('change', function () {
    $(".checkbox_ids").prop('checked', $(this).prop('checked')).trigger('change')
  });

  $(".record-row").on('click', function (e) {
    if (!$(e.target).is("input.checkbox_ids")) {
      $(".record-row").not(this).removeClass("active")
      $(this).toggleClass("active")
      var isActive = $(this).hasClass("active")
      $("#select_all_ids").prop('checked', false).trigger('change')
      $(this).find("input.checkbox_ids").prop('checked', isActive).trigger('change')
    }
  });

</script>
<script>
    const egfrReadings = <?php echo json_encode($egfrReadings) ?>;
    const bpReadings = <?php echo json_encode($bpReadings) ?>;
    const egfrDateLabels = <?php echo json_encode($egfrDateLabels) ?>;
    const bpDateLabels = <?php echo json_encode($bpDateLabels) ?>;

    const egfrHistory = egfrDateLabels.map((date, i) => ({
        date: date,
        egfr: egfrReadings[i]
    }));
    const bpHistory = bpDateLabels.map((date, i) => ({
        date: date,
        egfr: bpReadings[i]
    }));
</script>
<script src="script/charts.js"></script>
<script src="script/notes.js"></script>
</body>

</html>