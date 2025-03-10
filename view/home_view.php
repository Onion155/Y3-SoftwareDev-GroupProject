<?php 
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="../style/home_styles.css">
    <link rel="stylesheet" href="../style/form_styles.css">
</head>
    <?php require_once "entity/signup_dialog.php" ?>
    <?php require_once "entity/login_dialog.php" ?>
    <body>
        <div id="top-body">
            <header>
                    <nav>
                        <div class="nav-left">
                            <a href="#contact"><h4>Contact Us</h4></a>  
                            <a href="#faq"><h4>FAQ</h4></a>  
                        </div>
                        <div class="nav-right">
                            <?php if(!isset($_SESSION["account"])): ?>
                                <a href='#' onclick="showLoginDialog(true)" class="btn"><h4>Login</h4></a>
                            <?php else: ?>
                                <a href='dashboard.php' class="btn"><h4>To Dashboard</h4></a>
                            <?php endif ?>
                        </div>
                    </nav>
                
                <div class="header-container">
                <div class="logo">
                    <img src = "../other/logo.png" alt = "Logo">
                </div>

                <h1><span class="black">Welcome to My</span> <span class="red">Kidney</span> <span class="blue">Buddy</span><span class="small-blue">©</span></h1>
                <h4 data-aos="fade-left"><span class="accent">Your dedicated online resource for kidney health</span></h4>
                </div>
            </header>
            <div class= "HealthAnywhere">
                <h2>Your <span class="red">health</span><br>Anywhere <span class="blue"><br>Anytime</span></h2>
                <p>My Kidney Buddy is a secure, web-based platform tailored to help you monitor and understand your kidney health with ease.
                Whether you're at home, at work, or on the go, you can conveniently access tools to track your Chronic Kidney Disease (CKD) journey.</p>
            </div>
        </div>
        <div id="middle-body">

            <div class= "whatwedoBest" data-aos="fade-up">
                <h2>What We Do <span class="blue"><u>Best</u></span></h2>
                <p>Our platform simplifies complex medical information, providing personalised insights and clear explanations to empower you to take control of your health.
                    With My Kidney Buddy, you can view your eGFR, understand your CKD stage, and access helpful resources— all in one easy-to-use platform.</p>
                    <br>
                <p>We are here to support you every step of the way, making your health journey more manageable and less overwhelming.</p>
            </div>
            
            <div class="banners" data-aos="fade-in">
                <div class="banner">
                    <h3>Access<br>Anywhere</h3>
                    <img src="../other/internet_icon.png" alt="Access Anywhere">
                    <div class="p-wrapper">
                    <p>Log in securely from any device to track your eGFR and view easy to-read graphs and summaries</p>
                    </div>
                </div>
                <div class="banner">
                    <h3>Understand<br>Yourself</h3>
                    <img src="../other/identify_icon.png" alt="Understanding Yourself">
                    <div class="p-wrapper">
                        <p>Visualise your kidney health trends and gain insights into your CKD results with simple explanations.</p>
                </div>
                </div>
                <div class="banner">
                    <h3>Adaptive Resources</h3>
                    <img src="../other/resources_icon.png" alt="Adaptive Resources">
                    <div class="p-wrapper">
                        <p>Create, edit, or delete eGFR records, and upload CSV data to visualise them through charts.</p>
                    </div>
                </div>
            </div>
        </div>
        <div id="bottom-body">
        
            <div class="reviews" data-aos="fade-up">
                <h2>What Our Users Say</h2>
                <div class="review">
                <p>"My Kidney Buddy has been a game-changer for me. I love how easy it is to track my
                kidney health and understand what my results mean. Highly recommend!"</p>
                <h4>- Sarah T., CKD Patient</span></h4>
            </div>
                <div class="review">
                    <p>"I love the free control I have to record my eGFR. It is very responsive and tracks my eGFR history in very helpful graphs!”</p>
                    <h4>- Bob S., CKD Expert Patient</h4>
                </div>
                <div class="review">
                    <p>"It has never been easier to do sessions with my patients. They are able to see a detailed analysis of their records in real-time!"</p>
                    <h4>- Marco B., Clinician</span></h4>
                </div>
            </div>

            <div class="faq-wrapper" data-aos="fade-up">
                <h1>Frequently Asked Questions</h1>
                <div id="faq" class="faq">
                    <?php 
                        renderFAQ("What are the early signs of kidney disease?", "answer");
                        renderFAQ("What is eGFR, and why is it important?", "answer");
                        renderFAQ("What foods should i avoid if i have kidney problems?", "answer");
                        renderFAQ("What are the common causes for kidney disease?", "answer");
                        renderFAQ("How can I sign up for My Kidney Buddy?", "answer");
                        renderFAQ("How can this service be used to calculate my eGFR?", "answer");
                    ?>
                </div>
            </div>
            <footer class="copyright">
                <p>© My Kidney Buddy. All rights reserved.</p>
            </footer>
        </div>
        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script>
            AOS.init({
                offset: 200,
                duration: 600
            });
        </script>
    </body>
</html>
