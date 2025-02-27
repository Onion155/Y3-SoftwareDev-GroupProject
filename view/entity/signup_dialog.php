<dialog class="dialog" id="signup-dialog">
			<div class="signup-container form-wrapper">
				<h2>Create an Account</h2>
				<form class="signup-form form" method="POST">
					<label for="signup-email">Email</label>
					<input name="email" id="signup-email" type="text" placeholder="Enter your email assigned to your doctor" required />
					<label for="signup-password">Password</label>
					<input name="password" id="signup-password" type="text" placeholder="Create a password" required />
					<label for="confirm-password">Confirm Password</label>
					<input
						name="confirmPassword"
						id="confirm-password"
						type="text"
						placeholder="Repeat created password"
						required
					/>
					<p class="error-message"></p>
					<button>Sign up</button>
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
    const signupWrapper = document.querySelector(".signup-container");
    const showSignupDialog = (show) => show ? signupDialog.showModal() : signupDialog.close();
    signupDialog.addEventListener("click", (e) => !signupWrapper.contains(e.target) && signupDialog.close());

	function postSignupDetails() {
	event.preventDefault();
$.post("requestHandler.php", {
	action: "signup",
	email: $("#signup-email").val(),
	password: $("#signup-password").val()
	confirmPassword: $("#confirm-password").val()
}, function (message) {
	if(message == "success") window.location.href = "dashboard.php";
	else $(".error-message").text(message);
});
}
</script>
</div>