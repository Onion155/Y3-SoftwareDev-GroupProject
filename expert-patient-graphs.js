document.addEventListener("DOMContentLoaded", function() {
    const calculateBtn = document.getElementById("calculate-btn");
    const returnBtn = document.getElementById("return-btn");
    const egfrResult = document.getElementById("egfr-result");
    const ctx = document.getElementById("egfr-chart").getContext("2d");

    let egfrData = [60, 55, 48, 45]; // Preloaded eGFR values

    function calculateEGFR(creatinine, age, sex, ethnicity) {
        let k = sex === "male" ? 0.9 : 0.7;
        let a = sex === "male" ? -0.411 : -0.329;
        let gfr = (140 - age) * (creatinine / k) ** a;

        if (ethnicity === "black") {
            gfr *= 1.2; // Adjust for ethnicity
        }

        return Math.round(gfr);
    }

    function updateChart() {
        new Chart(ctx, {
            type: "line",
            data: {
                labels: ["Previous", "3 months ago", "2 months ago", "Recent"],
                datasets: [{
                    label: "eGFR",
                    data: egfrData,
                    borderColor: "#51c4d3",
                    backgroundColor: "rgba(81, 196, 211, 0.2)",
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

    calculateBtn.addEventListener("click", function() {
        const creatinine = parseFloat(document.getElementById("creatinine").value);
        const age = parseInt(document.getElementById("age").value);
        const sex = document.getElementById("sex").value;
        const ethnicity = document.getElementById("ethnicity").value;

        if (!creatinine || !age) {
            alert("Please enter valid data.");
            return;
        }

        let newEGFR = calculateEGFR(creatinine, age, sex, ethnicity);
        egfrData.push(newEGFR);
        egfrResult.textContent = newEGFR;
        updateChart();
    });

    returnBtn.addEventListener("click", function() {
        window.location.href = "index.html"; // Adjust as needed
    });

    updateChart(); // Load initial chart data
});
