<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to your account</title>
    <link rel="stylesheet" href="./style/styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form class="login-form" method = "POST">
            <input name="email" value="drmarco@gmail.com" type="text" placeholder="Enter your email" required>
            <input name="password" value= "123" type="password" placeholder="Enter your password" required>
            <?php if (isset($message)): ?>
            <p id="error-message"><?=$message?></p>
        <?php endif ?>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>