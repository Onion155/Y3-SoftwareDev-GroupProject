//API calls (database->PHP(server-side)->javascript(client-side))
//Retrieves data from patients assigned to signed in doctor
$.get("requestHandler.php", { action: 'getPatients' }, function (data, status) {
  console.log(JSON.parse(data));
  let patients = JSON.parse(data); //store patients as JSON
  loadDropDown(patients);  
});

//Retrieves username to display welcome text to user
$.get("requestHandler.php", { action: 'getUsername' }, function (username) {
  document.getElementById("welcome").innerHTML = `Welcome back ${username}!`;
  })

function fetchPatientRecords() { //Retrieves all patient records of a patient
$.get("requestHandler.php", { action: 'getPatientRecords' }, function (data) {
  let patientRecords = JSON.parse(data); //store patient records as JSON
  loadChart(patientRecords);
});
}

function setPatientIdSession(selectedPatientID) { //Sets session of patientid for the server to keep track of
  $.post("requestHandler.php", { patientid: selectedPatientID });
  }
  

//Fill dropdown with patients assigned to doctor
function loadDropDown(patients) {
  let patientsDropDown = document.getElementById("patient-dropdown")
  let out = patientsDropDown.innerHTML;

  for(let p in patients) {
    out += `<option value="${patients[p].id}">NHS: ${patients[p].NHSNumber}</option>"`;
  }
  patientsDropDown.innerHTML = out;
  
  loadPatientData();

  patientsDropDown.addEventListener("change", loadPatientData);

  function loadPatientData() {
    let patientID = patientsDropDown.value;
    setPatientIdSession(patientID);
    let patient = patients.find(p => p.id === parseInt(patientID));
    loadForm(patient);
    fetchPatientRecords();
  }
}

//Fill form with patient data
function loadForm(patient) {
  document.getElementById("age").value = calculateAge(patient.DoB);
  if (patient.isBlack === true) {
    document.getElementById("ethnicity").value = "black";
  } else {
    document.getElementById("ethnicity").value = "non-black";
  }
  document.getElementById("sex").value = patient.sex;
}

function calculateAge(DoB) {
  const today = new Date();
  const birthDate = new Date(DoB);

  let age = today.getFullYear() - birthDate.getFullYear();

  const monthDifference = today.getMonth() - birthDate.getMonth();
  const dayDifference = today.getDate() - birthDate.getDate();

  if (monthDifference < 0 || (monthDifference === 0 && dayDifference < 0)) {
    age--;
  }

  return age;
}

let egfrChart;

function loadChart(patientRecords) { // Creates the eGFR readings graph chart
  var previousReadings = [];
  var readingsLabels = [];
  
  for(let i = 0; i < patientRecords.length; i++) {
    previousReadings[i] = patientRecords[i].eGFR;
    readingsLabels[i] = "Reading " + (i+1);
  }
  console.log(previousReadings);
  ctx = document.getElementById("egfr-chart").getContext("2d");
  if (!egfrChart) { //Create new chart if it doesn't exist
    egfrChart = new Chart(ctx, {
      type: "line",
      data: {
        datasets: [
          {
            label: "eGFR over Time",
            borderColor: "rgba(75, 192, 192, 1)",
            fill: false,
            tension: 0.1,
          },
        ],
      },
      options: { scales: { y: {
            beginAtZero: false,
            title: {
              display: true,
              text: "eGFR (mL/min/1.73m²)",
            },
          },
        },
      },
    });
  }
 
  
  egfrChart.data.labels = readingsLabels
  egfrChart.data.datasets[0].data = previousReadings;
  egfrChart.update();
}

function displayeGFRresult(eGFR) { // Display the result
  document.getElementById("result").innerHTML = `<h2>Estimated GFR: ${eGFR.toFixed(2)} mL/min/1.73m²</h2>`;
}

function updateChart(newReading) {// Add the new reading to the dataset
  egfrChart.data.labels.push(
    "Reading " + (egfrChart.data.datasets[0].data.length + 1)
  );
  egfrChart.data.datasets[0].data.push(newReading);
  egfrChart.update();
}

let currentegfrvalue;
function GetCurrentegfrValue(list) {
  // this needs to be improved
  let LastLet = list[list.length - 1];
  if (LastLet > 90) {
    currentegfrvalue = 1;
  } else if (LastLet > 60 && LastLet < 89) {
    currentegfrvalue = 2;
  } else if (LastLet > 30 && LastLet < 59) {
    currentegfrvalue = 3; // there should be a 3A and 3B check as well look at coursework doc
  } else if (LastLet > 15 && LastLet < 29) {
    currentegfrvalue = 4;
  } else {
    currentegfrvalue = 5;
  }
}
