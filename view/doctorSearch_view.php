<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Search patients</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./style/record_styles.css">
  <link rel="stylesheet" href="./style/form_styles.css">
</head>

<body>
  <header>
    <a href="./index.php">
      <img id="logo" src="other/logo.png" alt="My Kidney Buddy mascot logo">
    </a>
    <div class="header-container">
      <div class="header-content">
        <h1>My Kidney Buddy</h1>
        <h2 id="welcome"><?= "Welcome $doctor->firstName $doctor->lastName" ?></h2>
      </div>
      <div class="navigation-menu">
        <a href="./index.php">
          <h2>Home</h2>
        </a>
        <form method="POST" action="./requestHandler.php?action=signout">
          <button class="signout-button" type="submit">
            <h2>Sign out</h2>
          </button>
        </form>
      </div>
    </div>
  </header>
  <div class="box-container">
    <?php if (true): ?>
      <form>
        <div class="search">
          <img src="other/search-icon.png" alt="search">
          <input class="search-input" type="search" placeholder="Search">
        </div>
      </form>
    <?php endif ?>

    <div class="box-bottom">
      <div id="table-container">
        <table class="table-content">
          <thead>
            <tr>
              <th><input id="select_all_ids" type="checkbox" }"></th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>NHS Number</th>
            </tr>
          </thead>
          <tbody>
            <form method="POST" action="./requestHandler.php?action=deletePatients">
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
      </div>
    </div>
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
  </div>
  <?php require_once "entity/editPatient_dialog.php" ?>
  <?php require_once "entity/addPatient_dialog.php" ?>
  <script>
    function submitForm() {
      $("#form").submit();
    }
    $(".checkbox_ids").on('change', function () {
      var num = $(".checkbox_ids:checked").length
      if (num > 0) {
        $("#delete").addClass("enabled")
      } else {
        $("#delete").removeClass("enabled")
      }

      if (num == 1) {
        $("#header").addClass("enabled")
        $("#edit").addClass("enabled")
        $(".patient-id").val($(this).val());
      } else {
        $("#header").removeClass("enabled")
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
</body>

</html>