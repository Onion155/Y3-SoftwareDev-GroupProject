<dialog class="dialog" id="signup-dialog">
			<div class="signup-container wrapper">
				<h2>Sign Up</h2>
				<form class="signup-form form" method="POST">
					<div class="form-row">
						<div class="form-container">
							<label for="firstName">First Name</label>
							<input
								name="firstName"
								type="text"
								placeholder="First Name"
								required
							/>
						</div>
						<div class="form-container">
							<label for="lastName">Last Name</label>
							<input
								name="lastName"
								type="text"
								placeholder="Last Name"
								required
							/>
						</div>
					</div>
					<label for="email">Email</label>
					<input name="email" type="text" placeholder="Email" required />
					<label for="password">Password</label>
					<input name="password" type="text" placeholder="Password" required />
					<label for="confirmPassword">Confirm Password</label>
					<input
						name="confirmPassword"
						type="text"
						placeholder="Confirm Password"
						required
					/>
					<label for="dob">Date of Birth</label>
					<input name="dob" type="date" placeholder="Date of Birth" required />
					<div class="form-row">
						<div class="form-container">
							<label for="sex">Sex</label>
							<select id="sex" name="sex" class="dropdown" required>
								<option value="male">Male</option>
								<option value="female">Female</option>
							</select>
						</div>
						<div class="form-container">
							<label for="ethnicity">Ethnicity</label>
							<select id="ethnicity" name="ethnicity" class="dropdown" required>
								<option value="black">Black</option>
								<option value="other">Other</option>
							</select>
						</div>
					</div>
					<text id="error-message"><?= $errorMessage ?></text>
					<button type="submit">Sign up</button>
					<div class="link">
						Already have an account?
						<a
							href="#"
							onclick="showLoginDialog(false); showSignupDialog(true);"
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
</script>
</div>