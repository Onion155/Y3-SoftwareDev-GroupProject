<dialog class="dialog" id="edit-dialog">
			<div class="edit-container form-wrapper">
				<h2>Edit Record</h2>
				<form
					method="POST"
					action="requestHandler.php?action=editPatientRecord"
				>
        <div class="form">
					<label for="creatinine">Serum Creatinine (micromol/l)</label>
					<input type="hidden" id="record-id" name="record-id" />
					<input type="text" id="creatinine" name="creatinine" required />
					<label for="blood-pressure">Blood Pressure (mmHg)</label>
					<input
						type="text"
						id="blood-pressure"
						name="blood-pressure"
						required
					/>
        </div>
					<button type="submit" class="green-button">Edit</button>
          <button type="reset" class="red-button" onclick="showEditDialog(false)">Cancel</button>

				</form>
			</div>
		</dialog>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script>
const editDialog = document.getElementById("edit-dialog");
const showEditDialog = (show) => show ? editDialog.showModal() : (editDialog.close(), $(".error-message").text(message));

    function postAddDetails() {
        event.preventDefault();

        const recordData = {
            recordId: $("#record-id").val(),
            creatinine: $("#creatinine").val(),
            bloodPressure: $("#blood-pressure").val(),
        };
        $.post("requestHandler.php", {
            action: "editRecord",
            recordData: JSON.stringify(recordData)
        }, function (message) {
            if (message == "success") window.location.href = "dashboard.php";
            else $(".error-message").text(message);
        });
    }
</script>