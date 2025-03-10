<dialog class="dialog" id="edit-dialog">
			<div class="edit-container form-wrapper">
				<h3>Edit Record</h3>
				<form method="POST">
					<div class="form">
						<label for="add-creatinine">Serum Creatinine (micromol/l)</label>
						<input type="hidden" id="record-id"/>
						<input type="text" id="edit-creatinine"/>
						<label for="add-blood-pressure">Blood Pressure (mmHg)</label>
						<input type="text" id="edit-blood-pressure"/>
					</div>
					<p class="error-message"></p>
					<button onclick="postEditDetails()" class="green-button">Edit</button>
					<button type="reset" class="red-button" onclick="showEditDialog(false)">Cancel</button>
				</form>
			</div>
		</dialog>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script>
			const editDialog = document.getElementById("edit-dialog");
			const showEditDialog = (show) => show ? editDialog.showModal() : (editDialog.close(), $(".error-message").text(message));

			function postEditDetails() {
				event.preventDefault();

			const recordData = {
				creatinine: $("#edit-creatinine").val(),
				bloodPressure: $("#edit-blood-pressure").val(),
				recordId: $("#record-id").val()
			};
			$.post("requestHandler.php", {
				action: "editRecord",
				recordData: JSON.stringify(recordData)
			}, function (message) {
				if (message == "success") window.location.href = "doctorPatient.php";
				else $(".error-message").text(message);
			});
			}
		</script>