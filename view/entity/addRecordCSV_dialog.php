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
    <script src = "view\entity\Helper.js"></script> 
    <script>
    const csvDialog = document.getElementById("csv-dialog");
    const showCSVDialog = (show) => show ? csvDialog.showModal() : csvDialog.close();

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