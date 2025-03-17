    <dialog class="dialog" id="csv-dialog">
        <div class="csv-container form-wrapper">
            <a href="#" onclick="showCSVDialog(false)">
                <img id="x-icon" src="other/x-icon.png" alt="My Kidney Buddy mascot logo">
            </a>
            <h3>Create Patients</h3>
            <div id="csv-table-wrapper">
            <div id="csv-table-container">
                <table class="csv-table-content">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>NHS Number</th>
                            <th>DoB</th>
                            <th>Female</th>
                            <th>Black</th>
                            <th>Expert</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>

                        </tr>
                    </tbody>
                </table>
            </div>
                <button id="good-button" onclick="postCSVAddDetails() ">Add Records</button>
                <button id="bad-button" onclick="clearTableRecords()">Cancel .csv</button>
        </div>
        <div id="upload-container">
            <input type="file" id="csvFileInput" accept=".csv" />
            <button onclick="handleFileUpload()">Upload .csv</button>
        </div>
        </div>
    </dialog>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    const csvDialog = document.getElementById("csv-dialog");
    const showCSVDialog = (show) => show ? csvDialog.showModal() : csvDialog.close();

        // Function to parse CSV data
        function parseCSV(csv) { // this breaks the data up in the csv file
            const lines = csv.split('\n');
            const headers = lines[0].split(',');
            const data = [];

            for (let i = 1; i < lines.length; i++) {
                const row = lines[i].split(',');
                if (row.length === headers.length) {
                    const entry = {};
                    for (let j = 0; j < headers.length; j++) {
                        entry[headers[j].trim()] = row[j].trim();
                    }
                    data.push(entry);
                }
            }
            return data;
        }

        // Function to add data to patients, it sends the data to the correct patient
        var rowsCreated;
        
        function addDataToRow(csvData) {
            const patientsData = parseCSV(csvData);
            rowsCreated = 0;
            patientsData.forEach(patient => {
                const firstName = patient['First Name'];
                const lastName = patient['Last Name'];
                const email = patient['Email'];
                const nhs = patient['NHS Number'];
                const dob = patient['DoB'];
                const isBlack = patient['Black'];
                const isExpert = patient['Expert'];
                const isFemale = patient['Female']

                createTableRow(firstName, lastName, email, nhs, dob, isFemale, isBlack, isExpert);
                rowsCreated++;

            });
        }

        function clearTableRecords() {
            $("#csv-table-wrapper").hide();
            $("#upload-container").show();
            $(".csv-table-content tbody").empty();
        }

        // Function to handle file upload
        function handleFileUpload() {
            const fileInput = document.getElementById('csvFileInput');
            const file = fileInput.files[0];
            const reader = new FileReader();

            reader.onload = function (event) {
                const csvData = event.target.result;
                addDataToRow(csvData);
            };

            if (file) {
                reader.readAsText(file);
            } else {
                alert('Please select a CSV file to upload.');
            }
        }

        function createTableRow(firstName, lastName, email, nhs, dob, isFemale, isBlack, isExpert) {
            var row = $("<tr>");
            row.append($("<td>").append(createInput(firstName, "csv-fn-"+ (rowsCreated+1), "input", "First Name")));
            row.append($("<td>").append(createInput(lastName, "csv-ln-" + (rowsCreated+1), "input", "Last Name")));
            row.append($("<td>").append(createInput(email, "csv-email-" + (rowsCreated+1), "input", "Email")));
            row.append($("<td>").append(createInput(nhs, "csv-nhs-" + (rowsCreated+1), "input", "NHS Number")));
            row.append($("<td>").append(createInput(dob, "csv-dob-" + (rowsCreated+1), "date", "Date of Birth")));
            row.append($("<td>").append(createCheckBox(isFemale == 1, "csv-female-" + (rowsCreated+1))));
            row.append($("<td>").append(createCheckBox(isBlack == 1, "csv-black-" + (rowsCreated+1))));
            row.append($("<td>").append(createCheckBox(isExpert == 1, "csv-expert-" + (rowsCreated+1))));
            $(".csv-table-content tbody").append(row);
            $("#csv-table-wrapper").show();
            $("#upload-container").hide();
        }
            function createInput(value, id, type, placeholder) {
                var textField = $("<input>")
                    .attr("type", type)
                    .attr("id", id)
                    .attr("placeholder", "Enter " + placeholder)
                    .val(value ? value : "");
                return textField;
            }

        function createCheckBox(value, id) {
            console.log(value);
            var checkBox = $("<input>")
            .attr("type", "checkbox")
            .attr("id", id)
            .prop("checked", value)
            return checkBox
        }

        function postCSVAddDetails() {
            event.preventDefault();
            
            for(let i = 1; i < rowsCreated + 1; i++) {
                const patientsData = {
                    firstName: $("#csv-fn"+"-"+i).val(),
                    lastName: $("#csv-ln"+"-"+i).val(),
                    email: $("#csv-email"+"-"+i).val(),
                    dob: $("#csv-dob"+"-"+i).val(),
                    nhs: $("#csv-nhs"+"-"+i).val(),
                    ethnicity: $("#csv-black"+i).is(":checked") ? "black" : "other",
                    sex: $("#csv-female"+"-"+i).is(":checked") ? "female" : "male",
                    role: $("#csv-expert"+"-"+i).is(":checked") ? "expert patient" : "patient"
                };
                $.post("requestHandler.php", {
                    action: "addPatient",
                    patientData: JSON.stringify(patientsData)
                }, function (message) {
                    if (message == "success") alert("Row " + i + " successfully added");
                    else alert("Row " + i + " error: " + message);
                    if (i == rowsCreated) window.location.href = "dashboard.php";

                });
          }
        }
</script>