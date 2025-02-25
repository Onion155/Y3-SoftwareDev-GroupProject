document.addEventListener("DOMContentLoaded", function () {
  // Sample patient data
  const patients = {
      "39439373834": {
          eGFRData: [60, 55, 50, 45, 40],
          dates: ["2025-01-01", "2025-01-10", "2025-01-20", "2025-01-30", "2025-02-10"],
          pastNotes: [
              "2025-01-01: Initial checkup - Normal kidney function.",
              "2025-01-10: Slight decrease in eGFR, recommended hydration.",
              "2025-01-30: Continued decline, advised dietary changes."
          ],
          serumCreatinine: [1.1, 1.2, 1.4, 1.5, 1.7]
      }
  };

  // Load patient search
  document.getElementById("searchPatient").addEventListener("input", function () {
      let patientID = this.value.trim();
      if (patients[patientID]) {
          document.getElementById("patientNumber").textContent = patientID;
          loadPatientData(patientID);
      }
  });

  // Load patient data
  function loadPatientData(patientID) {
      let patient = patients[patientID];
      let tableBody = document.getElementById("patientTableBody");
      tableBody.innerHTML = "";

      patient.dates.forEach((date, index) => {
          let row = `<tr>
              <td>${date}</td>
              <td>${patient.serumCreatinine[index]}</td>
              <td>${patient.eGFRData[index]}</td>
              <td>${patient.pastNotes[index] || "No additional notes"}</td>
          </tr>`;
          tableBody.innerHTML += row;
      });

      document.getElementById("pastNotes").innerText = patient.pastNotes.join("\n");
      renderGraph(patient.dates, patient.eGFRData);
  }

  function renderGraph(dates, values) {
      let ctx = document.getElementById("eGFRChart").getContext("2d");
      new Chart(ctx, {
          type: "line",
          data: { 
              labels: dates, 
              datasets: [{ 
                  label: "eGFR", 
                  data: values, 
                  borderColor: "#51c4d3", 
                  backgroundColor: "rgba(81, 196, 211, 0.2)",
                  fill: true 
              }] 
          },
          options: {
              responsive: true,
              maintainAspectRatio: false,
              scales: {
                  x: {
                      type: 'category',
                      labels: dates,
                      title: {
                          display: true,
                          text: 'Date'
                      },
                      ticks: {
                          maxRotation: 90,
                          minRotation: 45
                      }
                  },
                  y: {
                      beginAtZero: true,
                      title: {
                          display: true,
                          text: 'eGFR'
                      },
                      ticks: {
                          stepSize: 5
                      }
                  }
              },
              plugins: {
                  legend: {
                      display: true,
                      position: 'top'
                  },
                  tooltip: {
                      mode: 'index',
                      intersect: false
                  }
              },
              interaction: {
                  mode: 'nearest',
                  axis: 'x',
                  intersect: false
              },
              elements: {
                  point: {
                      radius: 5,
                      hoverRadius: 7,
                      backgroundColor: '#51c4d3'
                  },
                  line: {
                      tension: 0.4
                  }
              }
          }
      });
  }

  // Add data functionality
  document.getElementById("addDataBtn").addEventListener("click", function () {
      let patientID = document.getElementById("patientNumber").textContent;
      if (patientID === "Not Selected") {
          alert("Please select a patient first.");
          return;
      }

      let date = prompt("Enter date (YYYY-MM-DD):");
      let serumCreatinine = parseFloat(prompt("Enter serum creatinine (mg/dL):"));
      let eGFR = parseFloat(prompt("Enter eGFR:"));
      let note = prompt("Enter note:");

      if (date && !isNaN(serumCreatinine) && !isNaN(eGFR)) {
          patients[patientID].dates.push(date);
          patients[patientID].serumCreatinine.push(serumCreatinine);
          patients[patientID].eGFRData.push(eGFR);
          patients[patientID].pastNotes.push(note);

          loadPatientData(patientID);
      } else {
          alert("Invalid data entered.");
      }
  });

  // Preload data for demonstration
  document.getElementById("searchPatient").value = "39439373834";
  document.getElementById("searchPatient").dispatchEvent(new Event("input"));
});