    <dialog class="dialog" id="csv-dialog">
        <div class="csv-container form-wrapper">
            <a href="#" onclick="showCSVDialog(false)">
                <img id="x-icon" src="other/x-icon.png" alt="exit logo">
            </a>
            <h3>Add Records</h3>
            <div id="csv-table-wrapper">
            <div id="csv-table-container">
                <table id="records-table" class="csv-table-content">
                    <thead>
                        <tr>
                            <th>Creatinine</th>
                            <th>Blood Pressure</th>
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
    <script type = "module" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            const recordsData = parseCSV(csvData);
            rowsCreated = 0;
            recordsData.forEach(record => {
                //const dateCreated = record['Date Created'];
                const creatinine = record["Creatinine"];
                const bloodPressure = record["Blood Pressure"];
                createTableRow(creatinine, bloodPressure);
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

        function createTableRow(creatinine, bloodPressure) {
            var row = $("<tr>");
            //row.append($("<td>").append(createInput(firstName, "csv-date-created-"+ (rowsCreated+1), "Date of Creation")));
            row.append($("<td>").append(createInput(creatinine, "csv-creatinine-" + (rowsCreated+1), "Creatinine")));
            row.append($("<td>").append(createInput(bloodPressure, "csv-blood-pressure-" + (rowsCreated+1), "Blood Pressure")));
            $(".csv-table-content tbody").append(row);
            $("#csv-table-wrapper").show();
            $("#upload-container").hide();
        }
            function createInput(value, id, placeholder) {
                var textField = $("<input>")
                    .attr("type", "input")
                    .attr("id", id)
                    .attr("placeholder", "Enter " + placeholder)
                    .val(value ? value : "");
                return textField;
            }

        function postCSVAddDetails() {
            event.preventDefault();

            let rowCount = 0;
            for(let i = 1; i < rowsCreated + 1; i++) {
                const recordData = {
                   //dateCreated: $("#add-date-created"+"-"+1).val(),
                    creatinine: $("#csv-creatinine"+"-"+i).val(),
                    bloodPressure: $("#csv-blood-pressure"+"-"+i).val(),
                };
                $.post("requestHandler.php", {
                    action: "addRecord",
                    recordData: JSON.stringify(recordData)
                }, function (message) {

                    if (message == "success") rowCount++;
                    else alert("Row " + i + " error: " + message);

                    if (i == rowsCreated) {
                      if (rowCount == rowsCreated) {
                        alert("All Rows have been successfully added");
                        window.location.href = "dashboard.php";
                      }
                      else if (rowCount > 0) {
                        alert(rowCount + " Row(s) have been successfully added");
                        window.location.href = "dashboard.php";
                      }
                      else alert("No rows have been added");
                    }
                });
            }
        }
</script>