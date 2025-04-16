

function parseCSV(csv) {
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
        const isFemale = patient['Female'];

        createTableRow(firstName, lastName, email, nhs, dob, isFemale, isBlack, isExpert);
        rowsCreated++;
    });
}

function clearTableRecords() {
    $("#csv-table-wrapper").hide();
    $("#upload-container").show();
    $(".csv-table-content tbody").empty();
}

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

