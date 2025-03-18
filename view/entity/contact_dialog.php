<dialog class="dialog" id="contact-dialog">
	<div class="contact-container form-wrapper">
		<a href="#" onclick="showContactDialog(false)">
			<img id="x-icon" src="other/x-icon.png" alt="exit logo">
		</a>
		<h3>Contact Us</h3>
		<div class="form">
			<p>
				<p><strong>Email:</strong> support@mykidneybuddy.com</p>
				<p><strong>Phone:</strong> +44 123 456 7890</p>
				<p><strong>Address:</strong> 123 Kidney St, Health City, UK</p>
			</p>
		</div>
	</div>
</dialog>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
	const contactDialog = document.getElementById("contact-dialog");
	const showContactDialog = (show) => show ? contactDialog.showModal() : contactDialog.close();
</script>