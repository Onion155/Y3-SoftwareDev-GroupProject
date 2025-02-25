<dialog class="dialog" id="login-dialog">
			<div class="login-container wrapper">
				<h2>Login</h2>
				<form class="login-form form" method="POST">
					<label for="email">Email</label>
					<input
						name="email"
						value="drmarco@gmail.com"
						type="text"
						placeholder="Enter your email"
						required
					/>
					<label for="password">Password</label>
					<input
						name="password"
						value="123"
						type="password"
						placeholder="Enter your password"
						required
					/>
					<text id="error-message"><?= $errorMessage ?></text>
					<button type="submit">Login</button>
					<div class="link">
						Want to record your own eGFR data? <a
							href="#"
							onclick="showLoginDialog(false); showSignupDialog(true);"
							>Sign up now</a>
					</div>
				</form>
			</div>
		</dialog>
<script>
const loginDialog = document.getElementById("login-dialog");
const loginWrapper = document.querySelector(".login-container");
const showLoginDialog = (show) => show ? loginDialog.showModal() : loginDialog.close();
loginDialog.addEventListener("click", (e) => !loginWrapper.contains(e.target) && loginDialog.close());
</script>
</div>