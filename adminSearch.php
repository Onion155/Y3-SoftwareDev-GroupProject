<?php
require_once "model/admin.php";
require_once "model/doctor.php";
require_once "model/account.php";
require_once "model/api/dataAccess-db.php";
session_abort();
session_start();

if (!isset($_SESSION["account"])) {
    header("Location: index.php");
}
$admin = fetchAdmin($account->id);
$_SESSION["admin"] = $admin;

$doctors = array();
$isSearch = isset($_GET["search"]) && isset($_GET["filter"]);
if ($isSearch) {
    $search = htmlspecialchars($_GET["search"]);
    $filter = htmlspecialchars($_GET["filter"]);
    $_SESSION["doctor-filter"] = $filter;

    if (!empty($search) && $filter == "firstName") {
        $doctors = fetchdoctorsByFirstName($admin->id, $search);
    } else if (!empty($search) && $filter == "lastName") {
        $doctors = fetchdoctorsByLastName($admin->id, $search);
    }  else if (!empty($search) && $filter == "gmc") {
        $doctors = fetchdoctorsByGMC($admin->id, $search);
    } else {
        $doctors = fetchdoctors($admin->id);
    }
}

require_once "view/adminSearch_view.php";
?>