<dialog class="dialog" id="patient-dialog">
    <div class="patient-container form-wrapper">
        <h2>Create Patient</h2>
        <form class="patient-form form" method="POST">
            <div class="form-row">
                <div class="form-container">
                    <label for="first-name">First Name</label>
                    <input name="firstName" id="first-name" type="text" placeholder="First Name" required />
                </div>
                <div class="form-container">
                    <label for="last-name">Last Name</label>
                    <input name="lastName" id="last-name" type="text" placeholder="Last Name" required />
                </div>
            </div>
            <label for="email">Email</label>
            <input name="email" id="email" type="text" placeholder="Email" required />
            <label for="nhs">NHS Number</label>
            <input name="nhs" id="nhs" type="text" placeholder="NHS Number" required />
            <label for="dob">Date of Birth</label>
            <input name="dob" id="dob" type="date" placeholder="Date of Birth" required />
            <div class="form-row">
                <div class="form-container">
                    <label for="sex">Sex</label>
                    <select id="sex" id="sex" name="sex" class="dropdown" required>
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
            <span class="form-checkbox">
                <input name="expert" id="expert" type="checkbox">
                <label for="expert">The patient can record, edit, and delete their eGFR records</label>
            </span>
            <p class="error-message"></p>
            <button onclick="showPatientDialog(true)">Add patient</button>
    </div>
    </form>
    </div>
</dialog>


<script>
    const patientDialog = document.getElementById("patient-dialog");
    const patientWrapper = document.querySelector(".patient-container");
    const showPatientDialog = (show) => show ? patientDialog.showModal() : patientDialog.close();
    patientDialog.addEventListener("click", (e) => !patientWrapper.contains(e.target) && patientDialog.close());
</script>
</div>