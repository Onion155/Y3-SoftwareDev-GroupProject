<dialog class="login-dialog" id="dialog">
    <div class="login-container wrapper">
    <h2>Login</h2>
    <form class="login-form" method="POST">
        <input name="email" value="drmarco@gmail.com" type="text" placeholder="Enter your email" required="">
        <input name="password" value="123" type="password" placeholder="Enter your password" required="">
        <text id="error-message"><?= $errorMessage ?></text>
        <button type="submit">Login</button>
    </form>
    </div>
</dialog>

<script src="script/dialogPopup.js"></script></div>