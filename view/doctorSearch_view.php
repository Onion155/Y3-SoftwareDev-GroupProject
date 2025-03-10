<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Search patients</title>
  <link rel="stylesheet" href="./style/form_styles.css">
  <link rel="stylesheet" href="./style/record_styles.css">
</head>
<body>
  <header>
    <a href="./index.php">
      <img id="logo" src="other/logo.png" alt="My Kidney Buddy mascot logo">
    </a>
    <h1>eGFR Calculator</h1>
    <p id="welcome"><?= "Welcome $doctor->firstName $doctor->lastName" ?></p>
    <form method="POST" action="./requestHandler.php?action=signout">
      <button type="submit">Sign Out</button>
    </form>
  </header>
  <form id="form" method="POST" action="./requestHandler.php?action=setPatientSession">
  <input type="hidden" class="patient-id" name="patient-id">
  </form>
  <div class="dropdown" id="patient-dropdown">
    <button id="action-button">Actions</button>
    <div class="content">
    <a id="header" href="#" onclick="submitForm()">Go to patient records</a>
      <a href="#" onclick="showAddDialog(true)">Add patient</a>
      <a id="delete" href="#" onclick="showDeleteDialog(true)">Delete patient(s)</a>
    </div>
  </div>
  <div id="table-container">
    <table class="table-content">
      <thead>
        <tr>
        <th><input id="select_all_ids" type="checkbox"}"></th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>NHS Number</th>
        </tr>
      </thead>
      <tbody>
      <form id="form" method="POST" action="./requestHandler.php?action=deletePatients">
        <?php
        require_once "entity/delete_dialog.php";
        for ($i = 0; $i < count($patients); $i++):
        ?>
          <tr class="record-row">
            <td><input class="checkbox_ids" name="checkbox[]" type="checkbox" value="<?= $patients[$i]->id ?>"></td>
            <td><?= $patients[$i]->firstName ?></td>
            <td><?= $patients[$i]->lastName ?></td>
            <td><?= $patients[$i]->NHSNumber ?></td>
          </tr>
        <?php endfor ?>
        </form>
      </tbody>
    </table>
    <?php require_once "entity/editPatient_dialog.php" ?>
    <?php require_once "entity/addPatient_dialog.php" ?>
    <script>
      function submitForm() {
      $("#form").submit();
      }
      $(".checkbox_ids").on('change', function() {
    var num = $(".checkbox_ids:checked").length
    if(num > 0) {
      $("#delete").addClass("enabled")
    } else {
      $("#delete").removeClass("enabled")
    }
    
    if(num == 1) {
      $("#header").addClass("enabled")
      $("#edit").addClass("enabled")
      $(".patient-id").val($(this).val());
    } else {
      $("#header").removeClass("enabled")
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