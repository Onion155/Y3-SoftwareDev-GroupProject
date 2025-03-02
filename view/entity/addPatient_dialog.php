<dialog class="dialog" id="add-dialog">
    <div class="add-container form-wrapper">
        <h2>Create Patient</h2>
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
            <label for="nhs">NHS Number</label>
            <input name="nhs" id="nhs" type="text" placeholder="NHS Number" />
            <label for="dob">Date of Birth</label>
            <input name="dob" id="dob" type="date" placeholder="Date of Birth" />
            <div class="form-row">
                <div class="form-container">
                    <label for="sex">Sex</label>
                    <select id="sex" id="sex" name="sex" class="dropdown">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="form-container">
                    <label for="ethnicity">Ethnicity</label>
                    <select id="ethnicity" name="ethnicity" class="dropdown">
                        <option value="black">Black</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>
            <span class="form-checkbox">
                <input name="expert" id="expert" type="checkbox">
                <label for="expert">The add can record, edit, and delete their eGFR records</label>
            </span>
            <p class="error-message"></p>
            <button onclick="postAddDetails()">Add Patient</button>
    </div>
    </form>
    </div>
</dialog>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const addDialog = document.getElementById("add-dialog");
    const addWrapper = document.querySelector(".add-container");
    const showAddDialog = (show) => show ? addDialog.showModal() : addDialog.close();
    addDialog.addEventListener("click", (e) => !addWrapper.contains(e.target) && addDialog.close());

    function postAddDetails() {
        event.preventDefault();

        const patientData = {
            firstName: $("#first-name").val(),
            lastName: $("#last-name").val(),
            email: $("#email").val(),
            dob: $("#dob").val(),
            nhs: $("#nhs").val(),
            ethnicity: $("#ethnicity").val(),
            sex: $("#sex").val(),
            role: $("#expert").is(":checked") ? "expert patient" : "patient"
        };
        $.post("requestHandler.php", {
            action: "addPatient",
            patientData: JSON.stringify(patientData)
        }, function (message) {
            if (message == "success") window.location.href = "dashboard.php";
            else $(".error-message").text(message);
        });
    }
</script>
</div>