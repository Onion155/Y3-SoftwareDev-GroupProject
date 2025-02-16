<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>eGFR Calculator- Doctor</title>
    <link rel="stylesheet" href="./style/styles.css">
</head>
<body>
    <header>
        <img id="logo" src="other/logo.png" alt ="MyKidneyBuddy mascot logo">
        <h1>eGFR Calculator</h1>
    <select id="patient-dropdown" name="patients" required></select>
    <p id="welcome"></p>
    <form method="POST" action="./login.php">
        <button name="signout" type="submit">Sign Out</button>
    </form>
    </header>
            <div class="doctor-container">
            <div id="box-left"></div>
            <div id="box-right"></div>
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
    <canvas id="egfr-chart" width="400" height="200"></canvas>
    <script src= "https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script></body>
</html>
