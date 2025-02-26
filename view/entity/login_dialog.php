<dialog class="dialog" id="login-dialog">
			<div class="login-container form-wrapper">
				<h2>Login</h2>
				<form class="login-form form" method="POST">
					<label for="login-email">Email</label>
					<input
						name="email"
						id="email"
						value="drmarco@gmail.com"
						type="text"
						placeholder="Enter your email"
						required
					/>
					<label for="login-password">Password</label>
					<input
						name="password"
						id="password"
						value="123"
						type="password"
						placeholder="Enter your password"
						required
					/>
					<p class="error-message"></p>
					<button onclick="postLoginDetails()">Log in</button>
					<div class="link">
						Added by the doctor? <a
							href="#"
							onclick="showLoginDialog(false); showSignupDialog(true);"
							>Link by creating an account</a>
					</div>
				</form>
			</div>
		</dialog>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const loginDialog = document.getElementById("login-dialog");
const loginWrapper = document.querySelector(".login-container");
const showLoginDialog = (show) => show ? loginDialog.showModal() : loginDialog.close();
loginDialog.addEventListener("click", (e) => !loginWrapper.contains(e.target) && loginDialog.close());

function postLoginDetails() {
	event.preventDefault();
$.post("requestHandler.php", {
	action: "login",
	email: $("#email").val(),
	password: $("#password").val()
}, function (message) {
	if(message == "success") window.location.href = "dashboard.php";
	else $(".error-message").text(message);
});
}
</script>
</div>