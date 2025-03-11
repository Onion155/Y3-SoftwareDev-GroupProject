<dialog class="dialog" id="add-dialog">
	<div class="add-container form-wrapper">
        <a href="#" onclick="showAddDialog(false)">
            <img id="x-icon" src="other/x-icon.png" alt="My Kidney Buddy mascot logo">
        </a>
		<h3>Add Record</h3>
		<form method="POST">
			<div class="form">
				<label for="add-creatinine">Serum Creatinine (micromol/l)</label>
				<input type="hidden" id="record-id"/>
				<input type="text" id="add-creatinine"/>
				<label for="add-blood-pressure">Blood Pressure (mmHg)</label>
				<input type="text" id="add-blood-pressure"/>
			</div>
			<p class="error-message"></p>
			<button onclick="postAddDetails()" class="green-button">Calculate</button>
			<button type="reset" class="red-button" onclick="showAddDialog(false)">Cancel</button>
		</form>
	</div>
</dialog>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const addDialog = document.getElementById("add-dialog");
    const showAddDialog = (show) => show ? addDialog.showModal() : (addDialog.close(), $(".error-message").text(""));

    function postAddDetails() {
        event.preventDefault();
        const recordData = {
            creatinine: $("#add-creatinine").val(),
            bloodPressure: $("#add-blood-pressure").val(),
        };
        $.post("requestHandler.php", {
            action: "addRecord",
            recordData: JSON.stringify(recordData)
        }, function (message) {
            if (message == "success") window.location.href = "dashboard.php";
            else $(".error-message").text(message);
        });
    }
</script>