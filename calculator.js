document.addEventListener("DOMContentLoaded", function () {
    console.log("DOM fully loaded and parsed");

    // Selecting elements
    const calculateBtn = document.getElementById("calculateBtn");
    const calculateBtnBottom = document.getElementById("calculateBtnBottom");
    const returnBtn = document.getElementById("returnBtn");
    const exportBtn = document.getElementById("exportBtn");
    const darkModeToggle = document.getElementById("darkModeToggle");
    const dateFilter = document.getElementById("dateFilter");

    const egfrResult = document.getElementById("egfrResult");
    const egfrTrendChartCtx = document.getElementById("egfrTrendChart")?.getContext("2d");
    const egfrStatus = document.getElementById("egfrStatus");
    const loader = document.getElementById("loader");

    console.log({ calculateBtn, calculateBtnBottom, returnBtn, exportBtn, darkModeToggle, egfrTrendChartCtx });

    if (!calculateBtn || !calculateBtnBottom || !returnBtn || !egfrTrendChartCtx || !dateFilter) {
        console.error("🚨 Missing one or more elements! Check IDs in HTML.");
        return;
    }

    // Retrieve stored eGFR history or set default data
    let egfrHistory = JSON.parse(localStorage.getItem("egfrHistory")) || [
        { date: "2025-01-01", egfr: 90, creatinine: 75 },
        { date: "2025-01-10", egfr: 75, creatinine: 85 },
        { date: "2025-01-20", egfr: 60, creatinine: 100 },
        { date: "2025-01-30", egfr: 45, creatinine: 115 },
        { date: "2025-02-10", egfr: 30, creatinine: 130 }
    ];

    function calculateEGFR(creatinine, age, sex, ethnicity) {
        let eGFR = 0;
        if (sex === "male") {
            eGFR = 141 * Math.pow(Math.min(creatinine / 88.4 / 0.9, 1), -0.411) * Math.pow(Math.max(creatinine / 88.4 / 0.9, 1), -1.209) * Math.pow(0.993, age);
        } else {
            eGFR = 141 * Math.pow(Math.min(creatinine / 88.4 / 0.7, 1), -0.329) * Math.pow(Math.max(creatinine / 88.4 / 0.7, 1), -1.209) * Math.pow(0.993, age);
        }
        if (ethnicity === "africanAmerican") {
            eGFR *= 1.159;
        }
        return eGFR.toFixed(2);
    }

    function renderGraph() {
        console.log("Rendering graph with data:", egfrHistory);

        if (window.egfrChart) {
            window.egfrChart.destroy();
        }

        let filteredData = egfrHistory;
        const selectedFilter = dateFilter.value;

        if (selectedFilter === "last6months") {
            const sixMonthsAgo = new Date();
            sixMonthsAgo.setMonth(sixMonthsAgo.getMonth() - 6);
            filteredData = egfrHistory.filter(entry => new Date(entry.date) >= sixMonthsAgo);
        } else if (selectedFilter === "last1year") {
            const oneYearAgo = new Date();
            oneYearAgo.setFullYear(oneYearAgo.getFullYear() - 1);
            filteredData = egfrHistory.filter(entry => new Date(entry.date) >= oneYearAgo);
        }

        window.egfrChart = new Chart(egfrTrendChartCtx, {
            type: "line",
            data: {
                labels: filteredData.map(entry => entry.date),
                datasets: [
                    {
                        label: "eGFR",
                        data: filteredData.map(entry => entry.egfr),
                        borderColor: function (context) {
                            const value = context.dataset.data[context.dataIndex];
                            return value >= 60 ? "green" : value >= 30 ? "orange" : "red";
                        },
                        backgroundColor: "rgba(81, 196, 211, 0.2)",
                        fill: true,
                        pointRadius: 5,
                        pointBackgroundColor: function (context) {
                            const value = context.dataset.data[context.dataIndex];
                            return value >= 60 ? "green" : value >= 30 ? "orange" : "red";
                        }
                    },
                    {
                        label: "Creatinine Level (µmol/L)",
                        data: filteredData.map(entry => entry.creatinine),
                        borderColor: "blue",
                        backgroundColor: "rgba(0, 0, 255, 0.2)",
                        fill: false,
                        borderDash: [5, 5]
                    },
                    {
                        label: "Normal eGFR Threshold (90)",
                        data: Array(filteredData.length).fill(90),
                        borderColor: "gray",
                        borderWidth: 1,
                        borderDash: [10, 5],
                        pointRadius: 0
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    zoom: {
                        pan: { enabled: true, mode: "x" },
                        zoom: {
                            wheel: { enabled: true },
                            pinch: { enabled: true },
                            mode: "x"
                        }
                    }
                },
                scales: {
                    x: { title: { display: true, text: "Date" } },
                    y: { title: { display: true, text: "eGFR" }, ticks: { stepSize: 10 } }
                }
            }
        });
    }

    function handleCalculate() {
        if (loader) loader.style.display = "block";

        setTimeout(() => {
            const creatinine = parseFloat(document.getElementById("creatinine").value);
            const age = parseInt(document.getElementById("age").value);
            const sex = document.getElementById("sex").value;
            const ethnicity = document.getElementById("ethnicity").value;

            if (!isNaN(creatinine) && !isNaN(age) && sex && ethnicity) {
                const eGFR = calculateEGFR(creatinine, age, sex, ethnicity);
                egfrResult.textContent = eGFR;

                const currentDate = new Date().toISOString().split('T')[0];
                egfrHistory.push({ date: currentDate, egfr: parseFloat(eGFR), creatinine: creatinine });
                localStorage.setItem("egfrHistory", JSON.stringify(egfrHistory));
                renderGraph();
            } else {
                alert("Please fill in all fields correctly.");
            }
            if (loader) loader.style.display = "none";
        }, 1000);
    }

    function exportData() {
        let csvContent = "Date,eGFR,Creatinine Level (µmol/L)\n";
        egfrHistory.forEach(entry => {
            csvContent += `${entry.date},${entry.egfr},${entry.creatinine}\n`;
        });

        const blob = new Blob([csvContent], { type: "text/csv" });
        const link = document.createElement("a");
        link.href = URL.createObjectURL(blob);
        link.download = "eGFR_Report.csv";
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    function toggleDarkMode() {
        document.body.classList.toggle("dark-mode");

        if (document.body.classList.contains("dark-mode")) {
            localStorage.setItem("darkMode", "enabled");
        } else {
            localStorage.setItem("darkMode", "disabled");
        }
    }

    if (localStorage.getItem("darkMode") === "enabled") {
        document.body.classList.add("dark-mode");
    }

    if (darkModeToggle) {
        darkModeToggle.addEventListener("click", toggleDarkMode);
    } else {
        console.warn("⚠️ Dark mode button not found in HTML!");
    }

    if (calculateBtn) calculateBtn.addEventListener("click", handleCalculate);
    if (calculateBtnBottom) calculateBtnBottom.addEventListener("click", handleCalculate);
    if (exportBtn) exportBtn.addEventListener("click", exportData);
    if (dateFilter) dateFilter.addEventListener("change", renderGraph);

    renderGraph();
});
