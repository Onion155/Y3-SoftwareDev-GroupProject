<dialog class="dialog" id="add-dialog">
    <div class="add-container form-wrapper">
        <a href="#" onclick="showAddDialog(false)">
			<img id="x-icon" src="other/x-icon.png" alt="exit logo">
		</a>
        <h3>Create Doctor</h3>
        <form class="add-form form" method="POST">
            <div class="form-row">
                <div class="form-container">
                    <label for="first-name">First Name</label>
                    <input name="firstName" id="first-name" type="text" placeholder="First Name" />
                </div>
                <div class="form-container">
                    <label for="last-name">Last Name</label>
                    <input name="lastName" id="last-name" type="text" placeholder="Last Name" />
                </div>
            </div>
            <label for="email">Email</label>
            <input name="email" id="email" type="text" placeholder="Email" />
            <label for="gmc">GMC Number</label>
            <input name="gmc" id="gmc" type="text" placeholder="GMC Number" />
            <p class="error-message"></p>
            <button onclick="postAddDetails()">Add Doctor</button>
    </div>
    </form>
    </div>
</dialog>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const addDialog = document.getElementById("add-dialog");
    const showAddDialog = (show) => show ? addDialog.showModal() : (addDialog.close(), $(".error-message").text());
    function postAddDetails() {
        event.preventDefault();

        const doctorData = {
            firstName: $("#first-name").val(),
            lastName: $("#last-name").val(),
            email: $("#email").val(),
            gmc: $("#gmc").val(),
        };
        $.post("requestHandler.php", {
            action: "addDoctor",
            doctorData: JSON.stringify(doctorData)
        }, function (message) {
            if (message == "success") window.location.href = "dashboard.php";
            else $(".error-message").text(message);
        });
    }
</script>