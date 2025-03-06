<dialog class="dialog" id="add-dialog">
<div class="add-container form-wrapper">
				<h2>Add Record</h2>
				<form
					method="POST"
					action="requestHandler.php?action=addPatientRecord"
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
					<button type="submit" class="green-button">Add</button>
          <button type="reset" class="red-button" onclick="showAddDialog(false)">Cancel</button>
				</form>
			</div>
</dialog>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const addDialog = document.getElementById("add-dialog");
const showAddDialog = (show) => show ? addDialog.showModal() : addDialog.close();
</script>