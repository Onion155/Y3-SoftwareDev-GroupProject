<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Search patients</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./style/search_styles.css">
  <link rel="stylesheet" href="./style/form_styles.css">
</head>

<body>
  <header>
    <a href="./index.php">
      <img id="logo" src="other/logo.png" alt="My Kidney Buddy mascot logo">
    </a>
    <div class="header-container">
      <div class="header-content">
        <h2>My Kidney Buddy</h2>
        <h4 id="welcome"><?= "Welcome $doctor->firstName $doctor->lastName" ?></h4>
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

    <form method="GET">
      <div class="search">
        <img src="other/search-icon.png" alt="search">
        <input class="search-input" name="search" type="search" placeholder="Search Patient">
        <input type="hidden" id="filter" name="filter">
        <div class="action-dropdown" id="filter-dropdown">
            <button id="filter-button"></button>
            <div class="content">
              <a href="#" onclick="applyFilter('firstName')">First Name</a>
              <a href="#" onclick="applyFilter('lastName')">Last Name</a>
              <a href="#" onclick="applyFilter('nhs')">NHS Number</a>
            </div>
          </div>
      </div>
    </form>
    <input type="hidden" id="patient-id" name="patient-id">
    <?php if (!empty($patients)): ?>
        <div id="table-container">
          <table class="table-content">
            <thead>
              <tr>
                <th><input id="select_all_ids" type="checkbox"></th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>NHS Number</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            <form id="egfr-form" method="POST" action="requestHandler.php?action=deletePatients">
                <?php
                require_once "entity/delete_dialog.php";
                for ($i = 0; $i < count($patients); $i++):
                  ?>
                  <tr class="record-row">
                
                    <td><input class="checkbox_ids" name="checkbox[]" type="checkbox" value="<?= $patients[$i]->id ?>"></td>
                    <td><?= $patients[$i]->firstName ?></td>
                    <td><?= $patients[$i]->lastName ?></td>
                    <td><?= $patients[$i]->NHSNumber ?></td>
                    <td>
                      <a href="#" onclick="goToRecords(<?= $patients[$i]->id ?>)">
                        <img id="calculator-icon" src="other/calculator-icon.png" alt="My Kidney Buddy mascot logo">
                      </a>
                    </td>
                  </tr>
                <?php endfor ?>
              </form>
            </tbody>
          </table>
        </div>
      
    <?php elseif ($isSearch): ?>
        <p> No patients were found.</p>
      <?php else: ?>
        <p> Search for your assigned patient(s) to begin.</p>
    <?php endif ?>
            <div class="action-dropdown" id="patient-dropdown">
            <button>Actions</button>
            <div class="content">
              <a href="#" onclick="showAddDialog(true)">Add patient</a>
              <a href="#" onclick="showCSVDialog(true)">Add patients <span style="font-size: 10px;">(.csv)</span></a>
              <a id="edit" href="#" onclick="showEditDialog(true)">Edit selected</a>
              <a id="delete" href="#" onclick="showDeleteDialog(true)">Delete selected</a>
            </div>
          </div>
          </div>
  <?php require_once "entity/addPatientCSV_dialog.php" ?>
  <?php require_once "entity/editPatient_dialog.php" ?>
  <?php require_once "entity/addPatient_dialog.php" ?>
  <script>

  $(document).ready(function() {
    <?php if(isset($_SESSION["patient-filter"])): ?>
    applyFilter("<?= $_SESSION["patient-filter"] ?>");
    <?php else: ?>
    applyFilter("firstName");
    <?php endif ?>
  });

    function goToRecords(patientId) {
      event.preventDefault();
        $.post("requestHandler.php", {
            action: "setPatientSession",
            patientId: patientId
        }, function(message) {
          if (message == "success") window.location.href = "dashboard.php";
        });
    }

    function applyFilter(name) {
      if (name == "nhs") {
        $("#filter-button").text("Filter: NHS Number");
        $("#filter").val("nhs");
      } else if (name == "firstName") {
        $("#filter-button").text("Filter: First Name");
        $("#filter").val("firstName");
      } else if (name == "lastName") {
        $("#filter-button").text("Filter: Last Name");
        $("#filter").val("lastName");
      }
    }


    $(".checkbox_ids").on('change', function() {
    var num = $(".checkbox_ids:checked").length
    if(num > 0) {
      $("#delete").addClass("enabled")
    } else {
      $("#delete").removeClass("enabled")
    }
    
    if(num == 1) {
      $("#edit").addClass("enabled")
      $("#patient-id").val($(this).val());
    } else {
      $("#edit").removeClass("enabled")
    }
  });

  $("#select_all_ids").on('change', function() {
    $(".checkbox_ids").prop('checked', $(this).prop('checked')).trigger('change')
  });

  $(".record-row").on('click', function(e) {
    if (!$(e.target).is("input.checkbox_ids")) {
    $(".record-row").not(this).removeClass("active")
    $(this).toggleClass("active")
    var isActive = $(this).hasClass("active")
    $("#select_all_ids").prop('checked', false).trigger('change')
    $(this).find("input.checkbox_ids").prop('checked', isActive).trigger('change')
    }
  });

  </script>
</body>
</html>