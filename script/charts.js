var bpChart = null;

function renderBpGraph(filter) {
  let filteredData = filterHistory(bpHistory, filter)
  ctx = document.getElementById("bp-chart").getContext("2d");
  if (!bpChart) { //Create new chart if it doesn't exist
    bpChart = new Chart(ctx, {
      type: "line",
      data: {
        datasets: [
          {
            label: "Blood Pressure",
            borderColor: "rgb(192, 75, 75)",
            tension: 0.5,
          }
        ],
      },
      options: {
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: false,
            title: {
              display: true,
              text: "Blood Pressure (mmHg)",
            },
          },
          x: {
            ticks: {
              autoSkip: true,
              maxTicksLimit: 6,
            },
          },
        },
      },
    });
  }
  bpChart.data.labels = filteredData.map(entry => entry.date);
  bpChart.data.datasets[0].data = filteredData.map(entry => entry.egfr);
  bpChart.update();
}

var egfrChart = null;

function renderEgfrGraph(filter) {
  console.log("hi");
  let filteredData = filterHistory(egfrHistory, filter)
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
            tension: 0.3,
          },
          {
            label: "Normal eGFR Threshold (90)",
            data: Array(filteredData.length).fill(90),
            borderColor: "gray",
            borderWidth: 1,
            borderDash: [10, 5],
            pointRadius: 0
          }
        ],
      },
      options: {
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: false,
            title: {
              display: true,
              text: "eGFR (mL/min/1.73m²)",
            },
          },
          x: {
            ticks: {
              autoSkip: true,
              maxTicksLimit: 6,
            },
          },
        },
      },
    });
  }


  egfrChart.data.labels = filteredData.map(entry => entry.date);
  egfrChart.data.datasets[0].data = filteredData.map(entry => entry.egfr);
  egfrChart.update();
}

function filterHistory(dataHistory, filterType) {
  let filteredData = dataHistory.sort((a, b) => new Date(a.date) - new Date(b.date));;
  const selectedFilter = filterType;

  if (selectedFilter === "last6months") {
    const sixMonthsAgo = new Date();
    sixMonthsAgo.setMonth(sixMonthsAgo.getMonth() - 6);
    return dataHistory.filter(entry => new Date(entry.date) >= sixMonthsAgo);

  } else if (selectedFilter === "last1year") {
    const oneYearAgo = new Date();
    oneYearAgo.setFullYear(oneYearAgo.getFullYear() - 1);
    return dataHistory.filter(entry => new Date(entry.date) >= oneYearAgo);
  } else {
    return dataHistory;
  }
}

$(document).ready( function() {
  renderEgfrGraph($("#egfr-date-filter").val());
  renderBpGraph($("#bp-date-filter").val());

  $("#egfr-date-filter").on('change', function () {
    renderEgfrGraph($("#egfr-date-filter").val());
  });

  $("#bp-date-filter").on('change', function () {
    renderBpGraph($("#bp-date-filter").val());
  });
});