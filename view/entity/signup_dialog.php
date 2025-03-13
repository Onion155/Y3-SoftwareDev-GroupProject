<dialog class="dialog" id="signup-dialog">
	<div class="signup-container form-wrapper">
		<a href="#" onclick="showSignupDialog(false)">
			<img id="x-icon" src="other/x-icon.png" alt="My Kidney Buddy mascot logo">
		</a>
		<h3>Create Account</h3>
		<form class="signup-form form" method="POST">
			<label for="signup-email">Email</label>
			<input name="email" id="signup-email" type="text" placeholder="Enter your email assigned to your doctor" />
			<label for="signup-password">Password</label>
			<div id="view-password-wrapper">
				<input name="password" id="signup-password" type="password" placeholder="Create a password" />
				<button id="toggle-password" onclick="togglePassword($(this))" type="button">
					<img id="show-hide" src="other/hide.png">
				</button>
			</div>
			<div id="view-password-wrapper">
				<label for="confirm-password">Confirm Password</label>
				<input name="confirmPassword" id="confirm-password" type="password" placeholder="Repeat created password" />
				<button id="toggle-password" onclick="togglePassword($(this))" type="button">
					<img id="show-hide" src="other/hide.png">
				</button>
			</div>

			<p class="error-message" id="signup-error-message"></p>
			<button onclick="postSignupDetails()">Sign up</button>
			<div class="link">
				Already have an account?
				<a href="#" onclick="showLoginDialog(true); showSignupDialog(false);">Log in</a>
			</div>
		</form>
	</div>
</dialog>


<script>
	const signupDialog = document.getElementById("signup-dialog");
	const showSignupDialog = (show) => show ? signupDialog.showModal() : (signupDialog.close(), $(".error-message").text(""));

	function togglePassword(e) {
		const passwordField = $(e).closest("#view-password-wrapper").find("input");
		const showHideIcon = $(e).closest("#view-password-wrapper").find("show-hide");
		passwordField.attr("type", (passwordField.attr("type") === "password") ? "text" : "password");
		showHideIcon.attr("src", (showHideIcon.attr("src") === "other/hide.png") ? "other/show.png" : "other/hide.png");
	}

	function postSignupDetails() {
		event.preventDefault();
		$.post("requestHandler.php", {
			action: "signup",
			email: $("#signup-email").val(),
			password: $("#signup-password").val(),
			confirmPassword: $("#confirm-password").val()
		}, function (message) {
			if (message == "success") window.location.href = "dashboard.php";
			else $("#signup-error-message").text(message);
		});
	}
</script>
</div>