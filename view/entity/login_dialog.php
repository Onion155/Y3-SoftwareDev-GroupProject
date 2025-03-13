<dialog class="dialog" id="login-dialog">
    <div class="login-container form-wrapper">
        <a href="#" onclick="showLoginDialog(false)">
            <img id="x-icon" src="other/x-icon.png" alt="My Kidney Buddy mascot logo">
        </a>
        <h3>Login Account</h3>
        <form class="login-form form" method="POST">
            <label for="login-email">Email</label>
            <input name="email" id="email" value="drmarco@gmail.com" type="text" placeholder="Enter your email" />
            <label for="login-password">Password</label>
            <div id="view-password-wrapper">
                <input name="password" id="password" value="123" type="password" placeholder="Enter your password" />
                <button id="toggle-password" onclick="togglePassword($(this))" type="button">
                    <img id="show-hide" src="other/hide.png">
                </button>
            </div>
            <p class="error-message" id="login-error-message"></p>
            <button onclick="postLoginDetails()">Log in</button>
            <div class="link">
                Added by the doctor? <a href="#" onclick="showLoginDialog(false); showSignupDialog(true);">Create an
                    account</a>
            </div>
        </form>
    </div>
</dialog>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const loginDialog = document.getElementById("login-dialog");
    const showLoginDialog = (show) => show ? loginDialog.showModal() : (loginDialog.close(), $(".error-message").text(""));

    function togglePassword(e) {
        const passwordField = $(e).closest("#view-password-wrapper").find("input");
        const showHideIcon = $(e).closest("#view-password-wrapper").find("#show-hide");
        passwordField.attr("type", (passwordField.attr("type") === "password") ? "text" : "password");
        showHideIcon.attr("src", (showHideIcon.attr("src") === "other/hide.png") ? "other/show.png" : "other/hide.png");
    }

    function postLoginDetails() {
        event.preventDefault();
        $.post("requestHandler.php", {
            action: "login",
            email: $("#email").val(),
            password: $("#password").val()
        }, function (message) {
            if (message == "success") window.location.href = "dashboard.php";
            else {
                if (message != "Please fill in the fields") {
                    $("#email").val("");
                    $("#password").val("");
                }
                $("#login-error-message").text(message);
            }
        });
    }
</script>
</div>