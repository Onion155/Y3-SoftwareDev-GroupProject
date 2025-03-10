<?php
    function renderButton($text) {
        echo "<button>$text</button>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Kidney Buddy</title>
    <link rel="stylesheet" href="../style\home_styles.css">
</head>
<body>
    <header>
        <div>
            <?php renderButton("Contact Us"); ?>
            <?php renderButton("FAQ"); ?>
        </div>
        <?php renderButton("Login"); ?>
    </header>
    <div class="logo"></div>
    <h1>Welcome to <span class="red">My Kidney</span> <span class="blue">Buddy</span></h1>
    <p>Your dedicated online resource for kidney health</p>
    <p>My Kidney Buddy is a secure, web-based platform tailored to help you monitor and understand your kidney health with ease...</p>
    <h2>What We Do Best</h2>
    <p>Our platform simplifies complex medical information, providing personalised insights...</p>
    <div class="banners">
        <div class="banner">
            <h3>Access Anywhere</h3>
            <div class="image-placeholder"></div>
            <p>Text about accessibility.</p>
        </div>
        <div class="banner">
            <h3>Understanding Yourself</h3>
            <div class="image-placeholder"></div>
            <p>Text about understanding CKD.</p>
        </div>
        <div class="banner">
            <h3>Adaptive Resources</h3>
            <div class="image-placeholder"></div>
            <p>Text about adaptive resources.</p>
        </div>
    </div>
    <h2>What Our Users Say</h2>
    <div class="reviews">
        <div class="review">Review 1</div>
        <div class="review">Review 2</div>
        <div class="review">Review 3</div>
    </div>
    <h2>Frequently Asked Questions</h2>
    <div class="faq">
        <?php 
            function renderFAQ($question) {
                echo "<button>$question</button>";
            }
            renderFAQ("Question 1");
            renderFAQ("Question 2");
            renderFAQ("Question 3");
        ?>
    </div>
</body>
</html>
