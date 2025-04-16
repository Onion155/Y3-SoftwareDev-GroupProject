<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Search doctors</title>
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
        <h4 id="welcome"><?= "Welcome $admin->firstName $admin->lastName" ?></h4>
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
        <input class="search-input" name="search" type="search" placeholder="Search Doctor">
        <input type="hidden" id="filter" name="filter">
        <div class="action-dropdown" id="filter-dropdown">
            <button id="filter-button"></button>
            <div class="content">
              <a href="#" onclick="applyFilter('firstName')">First Name</a>
              <a href="#" onclick="applyFilter('lastName')">Last Name</a>
              <a href="#" onclick="applyFilter('gmc')">GMC Number</a>
            </div>
          </div>
      </div>
    </form>
    <input type="hidden" id="doctor-id" name="doctor-id">
    <?php if (!empty($doctors)): ?>
        <div id="table-container">
          <table class="table-content">
            <thead>
              <tr>
                <th><input id="select_all_ids" type="checkbox"></th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>GMC Number</th>
              </tr>
            </thead>
            <tbody>
            <form id="egfr-form" method="POST" action="requestHandler.php?action=deleteDoctors">
                <?php
                require_once "entity/delete_dialog.php";
                for ($i = 0; $i < count($doctors); $i++):
                  ?>
                  <tr class="record-row">
                
                    <td><input class="checkbox_ids" name="checkbox[]" type="checkbox" value="<?= $doctors[$i]->id ?>"></td>
                    <td><?= $doctors[$i]->firstName ?></td>
                    <td><?= $doctors[$i]->lastName ?></td>
                    <td><?= $doctors[$i]->GMCNumber ?></td>
                  </tr>
                <?php endfor ?>
              </form>
            </tbody>
          </table>
        </div>
      
    <?php elseif ($isSearch): ?>
        <p> No doctors were found.</p>
      <?php else: ?>
        <p> Search for your assigned doctor(s) to begin.</p>
    <?php endif ?>
            <div class="action-dropdown" id="doctor-dropdown">
            <button>Actions</button>
            <div class="content">
              <a href="#" onclick="showAddDialog(true)">Add doctor</a>
              <a id="edit" href="#" onclick="showEditDialog(true)">Edit selected</a>
              <a id="delete" href="#" onclick="showDeleteDialog(true)">Delete selected</a>
            </div>
          </div>
          </div>
  <?php require_once "entity/editDoctor_dialog.php" ?>
  <?php require_once "entity/addDoctor_dialog.php" ?>
  <script>

  $(document).ready(function() {
    <?php if(isset($_SESSION["doctor-filter"])): ?>
    applyFilter("<?= $_SESSION["doctor-filter"] ?>");
    <?php else: ?>
    applyFilter("firstName");
    <?php endif ?>
  });

    function applyFilter(name) {
      if (name == "gmc") {
        $("#filter-button").text("Filter: GMC Number");
        $("#filter").val("gmc");
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
      $("#doctor-id").val($(this).val());
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