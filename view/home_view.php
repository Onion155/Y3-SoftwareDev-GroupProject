<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Kidney Buddy</title>
    <link rel="stylesheet" href="./style/home_styles.css">
    <link rel="stylesheet" href="./style/form_styles.css">
</head>
<body>
    <div class="header">
        <img src="other\logo.png" alt="Logo" class="logo">
        <h1>My Kidney Buddy</h1>
<?php if(!isset($_SESSION["account"])): ?>
        <button onclick="showLoginDialog(true)" class="login-btn">Log in</button>
<?php require_once "entity/signup_dialog.php" ?>
<?php require_once "entity/login_dialog.php" ?>
<?php else: ?>
    <a href="dashboard.php" class="login-btn">Go to dashboard</a>

<?php endif; ?>
    </div>

    <div class="content">
        <div class="text-box">
            <h3> Information about the website</h3>
               <p> Welcome to SDP – Your dedicated online resource for kidney health.
                 Our website offers comprehensive information, support, and community for kidney patients.
                  From understanding your condition to managing your treatment, SDP is here to guide you every step of the way.
                   Join us to connect with experts, access valuable resources, and find the support you need for a healthier life.</p>

                   <h3>Common Symptoms</h3>
                   <p>1. Fatigue: Feeling unusually tired or weak.</p>
                   <p>2. Swelling: Particularly in the ankles, feet, or hands due to fluid retention.</p>
                   <p>3. Changes in urination: This can include urinating more or less frequently than usual, or changes in the color and appearance of urine.</p>
                   <p>4. Nausea and vomiting: Feeling sick to your stomach or actually vomiting.</p>
                   <p>5. Shortness of breath: Difficulty breathing, which can be caused by fluid buildup in the lungs.</p>
                   <p>6. Confusion: Difficulty concentrating or experiencing brain fog.</p>

                   <h3>How to contact your local GP</h3>
                   <p>To contact your local GP, you can usually use an online form on our website or visit in person</p>
                    
        </div>
        <div class="image-container">
            <img src="other\DrugsImage1.PNG" alt="Kidney Image 1">
            <img src="other\kidneyImage1.PNG" alt="Kidney Image 2">
        </div>
    </div>

</body>
</html>
