<dialog class="dialog" id="edit-dialog">
    <div class="edit-container form-wrapper">
        <a href="#" onclick="showEditDialog(false)">
            <img id="x-icon" src="other/x-icon.png" alt="exit logo">
        </a>
        <h3>Modify Doctor</h3>
        <form class="edit-form form" method="POST">
            <div class="form-row">
              <input type="hidden" id="doctor-id" name="doctor-id">
                <div class="form-container">
                    <label for="edit-first-name">First Name</label>
                    <input name="firstName" id="edit-first-name" type="text" placeholder="First Name" />
                </div>
                <div class="form-container">
                    <label for="edit-last-name">Last Name</label>
                    <input name="lastName" id="edit-last-name" type="text" placeholder="Last Name" />
                </div>
            </div>
            <label for="edit-email">Email</label>
            <input name="email" id="edit-email" type="text" placeholder="Email" />
            <label for="edit-gmc">GMC Number</label>
            <input name="gmc" id="edit-gmc" type="text" placeholder="GMC Number" />
            <p class="error-message"></p>
            <button onclick="postEditDetails()">Edit Doctor</button>
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
            $(".error-message").text("");
        }
    }
    
    function getEditDetails() {
        $.post("requestHandler.php", {
            action: "getDoctor",
            doctorId: $("#doctor-id").val() 
        }, function (data) {
            let doctor = JSON.parse(data);
            $("#edit-first-name").val(doctor.firstName);
            $("#edit-last-name").val(doctor.lastName);
            $("#edit-email").val(doctor.email);
            $("#edit-gmc").val(doctor.GMCNumber);
        });
    }

    function postEditDetails() {
        event.preventDefault();

        const doctorData = {
            doctorId: $("#doctor-id").val(),
            firstName: $("#edit-first-name").val(),
            lastName: $("#edit-last-name").val(),
            email: $("#edit-email").val(),
            gmc: $("#edit-gmc").val(),
        };
        $.post("requestHandler.php", {
            action: "editDoctor",
            doctorData: JSON.stringify(doctorData)
        }, function (message) {
            if (message == "success") window.location.href = "dashboard.php";
            else $(".error-message").text(message);
        });
    }
</script>
</div>