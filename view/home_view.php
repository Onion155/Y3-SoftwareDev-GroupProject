<?php 
function renderFAQ($question, $answer) {
    echo "<details><summary>$question</summary><p id='separator'></p>$answer</details>";
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
    <?php require_once "entity/contact_dialog.php" ?>
    <?php require_once "entity/signup_dialog.php" ?>
    <?php require_once "entity/login_dialog.php" ?>
    <body>
        <div id="top-body">
            <header>
                    <nav>
                        <div class="nav-left">
                            <a href="#" onclick="showContactDialog(true)"><h4>Contact Us</h4></a>  
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
                <h2>Your <span class="red">health</span><br>Anywhere,<span class="blue"><br>Anytime</span></h2>
                <p>My Kidney Buddy is a secure, web-based platform tailored to help you monitor and understand your kidney health with ease.
                Whether you're at home, at work, or on the go, you can conveniently access tools to track your Chronic Kidney Disease (CKD) journey.</p>
            </div>
        </div>
        <div id="middle-body">

            <div class= "whatwedoBest" data-aos="fade-up">
                <h2>What we do <span class="blue">Best</span></h2>
                <ul>
                    <li>Our platform simplifies complex medical information, providing personalised insights and clear explanations to empower you to take control of your health.</li>
                    <li>With My Kidney Buddy, you can view your eGFR, understand your CKD stage, and access helpful resources— all in one easy-to-use platform.</li>
                    <li>We are here to support you every step of the way, making your health journey more manageable and less overwhelming.</li>
                </ul>
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
                    <h3>Adaptive<br>Resources</h3>
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

            <div id="faq" class="faq" data-aos="fade-up">
                <h1>Frequently Asked Questions</h1>
                <?php 
                    renderFAQ("What are the early signs of kidney disease?","
                    <p>Early signs include:</p>
                    <ul>
                        <li>Changes in urination (frequency, foamy, or blood in urine).</li>
                        <li>Swelling in the legs, ankles, or face.</li>
                        <li>Fatigue and difficulty concentrating.</li>
                        <li>Persistent itching and dry skin. </li>
                        <li>High blood pressure and/or shortness of breath.</li>
                    </ul>
                    ");
                    renderFAQ("What is eGFR, and why is it important?", "
                    <ul>
                        <li>eGFR (estimated Glomerular Filtration Rate) measures kidney function.</li>
                        <li>It estimates how well your kidneys filter waste from the blood.</li>
                        <li>A lower eGFR means reduced kidney function.</li>
                        <li>It helps diagnose and monitor kidney disease.</li>
                        <li>Doctors use it to guide treatment and lifestyle changes.</li>
                    </ul>
                    ");
                    renderFAQ("What foods should i avoid if i have kidney problems?", "
                    <ul>
                        <li>Limit high-sodium foods like processed meats and salty snacks.</li>
                        <li>Avoid high-potassium foods like bananas, potatoes, and oranges.</li>
                        <li>Reduce phosphorus-rich foods like dairy and nuts.</li>
                        <li>Limit protein intake if advised by a doctor.</li>
                        <li>Stay away from sugary drinks and alcohol.</li>
                    </ul>
                    ");
                    renderFAQ("What are the common causes for kidney disease?", "
                    <ul>
                        <li>Diabetes and high blood pressure.</li>
                        <li>Kidney infections or blockages.</li>
                        <li>Long-term use of certain medications.</li>
                        <li>Autoimmune diseases like lupus.</li>
                        <li>Genetic conditions or family history.</li>
                    </ul>

                    ");
                    renderFAQ("How can I sign up for My Kidney Buddy?", "
                    <ul>
                        <li>You must be registered with a GP.</li>
                        <li>Your doctor creates your account and sets an initial password.</li>
                        <li>The doctor decides if you are a regular or expert patient.</li>
                        <li>You receive login details and change your password.</li>
                        <li>Access your profile based on your assigned patient type.</li>
                    </ul>
                    ");
                    renderFAQ("How can this service be used to calculate my eGFR?", "
                    <ul>
                        <li>Regular patients can view their eGFR results and history.</li>
                        <li>Expert patients can enter their details to calculate eGFR.</li>
                        <li>The system uses medical formulas to process the input.</li>
                        <li>Results are displayed instantly with relevant insights.</li>
                        <li>This helps track kidney health over time.</li>
                    </ul>
                    ");
                ?>
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
