<dialog class="dialog" id="edit-dialog">
    <div class="edit-container form-wrapper">
        <h3>Modify Patient</h3>
        <form class="edit-form form" method="POST">
            <div class="form-row">
              <input type="hidden" id="patient-id" name="patient-id">
                <div class="form-container">
                    <label for="first-name">First Name</label>
                    <input name="firstName" id="edit-first-name" type="text" placeholder="First Name" />
                </div>
                <div class="form-container">
                    <label for="last-name">Last Name</label>
                    <input name="lastName" id="edit-last-name" type="text" placeholder="Last Name" />
                </div>
            </div>
            <label for="email">Email</label>
            <input name="email" id="edit-email" type="text" placeholder="Email" />
            <label for="nhs">NHS Number</label>
            <input name="nhs" id="edit-nhs" type="text" placeholder="NHS Number" />
            <label for="dob">Date of Birth</label>
            <input name="dob" id="edit-dob" type="date" placeholder="Date of Birth" />
            <div class="form-row">
                <div class="form-container">
                    <label for="sex">Sex</label>
                    <select id="edit-sex" name="sex" class="dropdown">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="form-container">
                    <label for="ethnicity">Ethnicity</label>
                    <select id="edit-ethnicity" name="ethnicity" class="dropdown">
                        <option value="black">Black</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>
            <span class="form-checkbox">
                <input name="expert" id="edit-expert" type="checkbox">
                <label for="expert">The patient can record, edit, and delete their eGFR records</label>
            </span>
            <p class="error-message"></p>
            <button onclick="postEditDetails()">Edit Patient</button>
    </div>
    </form>
    </div>
</dialog>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const editDialog = document.getElementById("edit-dialog");
    function showEditDialog (show) {
        if (show) {
            editDialog.showModal();
            getEditDetails();
        } else {
            editDialog.close();
            $(".error-message").text(message);
        }
    }
    
    function getEditDetails() {
        $.post("requestHandler.php", {
            action: "getPatient",
            patientId: $("#patient-id").val() 
        }, function (data) {
            let patient = JSON.parse(data);
            $("#edit-first-name").val(patient.firstName);
            $("#edit-last-name").val(patient.lastName);
            $("#edit-email").val(patient.email);
            $("#edit-nhs").val(patient.NHSNumber);
            $("#edit-dob").val(patient.DoB);
            $("#edit-ethnicity").val(patient.ethnicity == true ? "black" : "other");
            $("#edit-sex").val(patient.sex);
            $("#edit-expert").prop("checked", patient.isExpert);
        });
    }

    function postEditDetails() {
        event.preventDefault();

        const patientData = {
            patientId: $("#patient-id").val(),
            firstName: $("#edit-first-name").val(),
            lastName: $("#edit-last-name").val(),
            email: $("#edit-email").val(),
            dob: $("#edit-dob").val(),
            nhs: $("#edit-nhs").val(),
            ethnicity: $("#edit-ethnicity").val(),
            sex: $("#edit-sex").val(),
            role: $("#edit-expert").is(":checked") ? "expert patient" : "patient"
        };
        $.post("requestHandler.php", {
            action: "editPatient",
            patientData: JSON.stringify(patientData)
        }, function (message) {
            if (message == "success") window.location.href = "dashboard.php";
            else $(".error-message").text(message);
        });
    }
</script>
</div>