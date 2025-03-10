<dialog class="dialog" id="signup-dialog">
			<div class="signup-container form-wrapper">
				<h3>Create Account</h3>
				<form class="signup-form form" method="POST">
					<label for="signup-email">Email</label>
					<input name="email" id="signup-email" type="text" placeholder="Enter your email assigned to your doctor"/>
					<label for="signup-password">Password</label>
					<input name="password" id="signup-password" type="text" placeholder="Create a password" />
					<label for="confirm-password">Confirm Password</label>
					<input
						name="confirmPassword"
						id="confirm-password"
						type="text"
						placeholder="Repeat created password"
					/>
					<p class="error-message" id="signup-error-message"></p>
					<button onclick="postSignupDetails()">Sign up</button>
					<div class="link">
						Already have an account?
						<a
							href="#"
							onclick="showLoginDialog(true); showSignupDialog(false);"
							>Log in</a
						>
					</div>
				</form>
			</div>
		</dialog>


<script>
    const signupDialog = document.getElementById("signup-dialog");
    const showSignupDialog = (show) => show ? signupDialog.showModal() : signupDialog.close();

function postSignupDetails() {
	event.preventDefault();
$.post("requestHandler.php", {
	action: "signup",
	email: $("#signup-email").val(),
	password: $("#signup-password").val(),
	confirmPassword: $("#confirm-password").val()
}, function (message) {
	if(message == "success") window.location.href = "dashboard.php";
	else $("#signup-error-message").text(message);
});
}
</script>
</div>