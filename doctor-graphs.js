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

    const searchInput = document.getElementById("searchPatient");
    const searchButton = document.getElementById("searchBtn");
    const patientNumberDisplay = document.getElementById("patientNumber");
    const patientTableBody = document.getElementById("patientTableBody");
    const pastNotesDisplay = document.getElementById("pastNotes");
    const addDataButton = document.getElementById("addDataBtn");
    let eGFRChartInstance = null;

    function loadPatientData(patientID) {
        if (!patients[patientID]) {
            alert("⚠️ Patient not found! Please check the ID.");
            return;
        }

        const patient = patients[patientID];
        patientNumberDisplay.textContent = patientID;
        patientTableBody.innerHTML = "";

        patient.dates.forEach((date, index) => {
            let row = `<tr>
                <td>${date}</td>
                <td>${patient.serumCreatinine[index]}</td>
                <td>${patient.eGFRData[index]}</td>
                <td>${patient.pastNotes[index] || "No additional notes"}</td>
            </tr>`;
            patientTableBody.innerHTML += row;
        });

        pastNotesDisplay.innerText = patient.pastNotes.join("\n");
        renderGraph(patient.dates, patient.eGFRData, patient.serumCreatinine);
    }

    function renderGraph(dates, eGFRValues, creatinineValues) {
        let ctx = document.getElementById("eGFRChart").getContext("2d");

        if (eGFRChartInstance) {
            eGFRChartInstance.destroy();
        }

        eGFRChartInstance = new Chart(ctx, {
            type: "line",
            data: {
                labels: dates,
                datasets: [
                    {
                        label: "eGFR",
                        data: eGFRValues,
                        borderColor: function (context) {
                            const value = context.dataset.data[context.dataIndex];
                            return value >= 60 ? "green" : value >= 30 ? "orange" : "red";
                        },
                        backgroundColor: "rgba(81, 196, 211, 0.2)",
                        fill: true,
                        pointBackgroundColor: function (context) {
                            const value = context.dataset.data[context.dataIndex];
                            return value >= 60 ? "green" : value >= 30 ? "orange" : "red";
                        }
                    },
                    {
                        label: "Serum Creatinine (mg/dL)",
                        data: creatinineValues,
                        borderColor: "blue",
                        backgroundColor: "rgba(0, 0, 255, 0.2)",
                        fill: false,
                        borderDash: [5, 5]
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: { title: { display: true, text: "Date" } },
                    y: { title: { display: true, text: "eGFR" }, ticks: { stepSize: 10 } }
                },
                plugins: {
                    legend: { display: true, position: "top" },
                    tooltip: {
                        enabled: true,
                        callbacks: {
                            label: function (tooltipItem) {
                                return `Date: ${tooltipItem.label}, eGFR: ${tooltipItem.raw}`;
                            }
                        }
                    }
                }
            }
        });
    }

    function addPatientData() {
        const patientID = patientNumberDisplay.textContent;
        if (patientID === "Not Selected") {
            alert("⚠️ Please select a patient first.");
            return;
        }

        const date = prompt("📅 Enter date (YYYY-MM-DD):");
        const serumCreatinine = parseFloat(prompt("💉 Enter serum creatinine (mg/dL):"));
        const eGFR = parseFloat(prompt("🩸 Enter eGFR value:"));
        const note = prompt("📝 Enter additional note:");

        if (!date || isNaN(serumCreatinine) || isNaN(eGFR)) {
            alert("🚨 Invalid data entered! Please provide valid numbers.");
            return;
        }

        patients[patientID].dates.push(date);
        patients[patientID].serumCreatinine.push(serumCreatinine);
        patients[patientID].eGFRData.push(eGFR);
        patients[patientID].pastNotes.push(note);

        loadPatientData(patientID);
    }

    searchButton.addEventListener("click", function () {
        const patientID = searchInput.value.trim();
        if (patientID) {
            loadPatientData(patientID);
        }
    });

    addDataButton.addEventListener("click", addPatientData);

    // Auto-load sample data for demonstration
    searchInput.value = "39439373834";
    searchButton.click();
});
