<?php 
function renderButton($text, $link = "#") {
    echo "<a href='$link' class='btn'>$text</a>";
}

function renderFAQ($question, $answer) {
    echo "<details><summary>$question</summary><p>$answer</p></details>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Kidney Buddy</title>
    <link rel="stylesheet" href="../style/home_styles.css">
</head>
<body>
    <header>
        <nav>
            <div>
                <?php renderButton("Contact Us", "contact.php"); ?>  
                <?php renderButton("FAQ", "faq.php"); ?> 
            </div>
            <?php renderButton("Login", "../login.php"); ?> 
        </nav>
    </header>
    
    <div class="logo">
        <img src = "../other/logo.png" alt = "Logo">
    </div>

    <h1>Welcome to My <span class="red">Kidney</span> <span class="blue">Buddy</span></h1>
    <p>Your dedicated online resource for kidney health</p>

    <div class= "HealthAnywhere">
        <h2>Your <span class="red">health</span> Anywhere <span class="blue">Anytime</span></h2>
        <p>My Kidney Buddy is a secure, web-based platform tailored to help you monitor and understand your kidney health with ease.
         Whether you're at home, at work, or on the go, you can conveniently access tools to track your Chronic Kidney Disease (CKD) journey.</p>
</div>

    <div class= "whatwedoBest">
        <h2>What We Do <span class="blue">Best</span></h2>
        <p>Our platform simplifies complex medical information, providing personalised insights and clear explanations to empower you to take control of your health.
             With My Kidney Buddy, you can view your eGFR, understand your CKD stage, and access helpful resources— all in one easy-to-use platform.</p>

        <p>We are here to support you every step of the way, making your health journey more manageable and less overwhelming.</p>
</div>

    <div class="banners">
        <div class="banner">
            <h3>Access Anywhere</h3>
            <img src="../other/accessAnywhereicon.jpg" alt="Access Anywhere">
            <p>Log in securely from any device to track your eGFR and view easy to-read graphs and summaries</p>
        </div>
        <div class="banner">
            <h3>Understanding Yourself</h3>
            <img src="../other/UnderstandingYourselficon.jpg" alt="Understanding Yourself">
            <p>Visualize your kidney health trends and gain insights into your CKD results with simple explanations.</p>
        </div>
        <div class="banner">
            <h3>Adaptive Resources</h3>
            <img src="../other/AdaptiveResourcesIcon.jpg" alt="Adaptive Resources">
            <p>Create, edit, or delete eGFR records, or upload CSV data and visualise them through graphs and health indicator.</p>
        </div>
    </div>
    
    <h2>What Our Users Say</h2>
    <div class="reviews">
        <div class="review">
        <p>"My Kidney Buddy has been a game-changer for me. I love how easy it is to track my
        kidney health and understand what my results mean. Highly recommend!"</p>
        <p><span class="blue">- Sarah T., CKD Patient</span></p>
    </div>
        <div class="review">
            <p>"I love the free control I have to record my eGFR. It is very responsive and tracks my eGFR history in very helpful graphs!”</p>
            <p><span class="blue">- Bob S., CKD Expert Patient</span></p>
        </div>
        <div class="review">
            <p>"It has never been easier to do sessions with my patients. They are able to see a detailed analysis of their records in real-time!"</p>
            <p><span class="blue">- Marco B., Clinician</span></p>
        </div>
    </div>
    
    <h2>Frequently Asked Questions</h2>
    <div class="faq">
        <?php 
            renderFAQ("What are the early signs of kidney disease?", "answer");
            renderFAQ("What is eGFR, and why is it important?", "answer");
            renderFAQ("What foods should i avoid if i have kidney problems?", "answer");
            renderFAQ("What are the common causes for kidney disease?", "answer");
            renderFAQ("How can I sign up for My Kidney Buddy?", "answer");
            renderFAQ("How can this service be used to calculate my eGFR?", "answer");
        ?>
    </div>
    <footer class="copyright">
    <p>© My Kidney Buddy. All rights reserved.</p>
</footer>
</body>



</html>
