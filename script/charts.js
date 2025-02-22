ctx = document.getElementById("egfr-chart").getContext("2d");
egfrChart = new Chart(ctx, {
  type: "line",
  data: {
    labels: dateLabels,
    datasets: [
      {
        label: "eGFR",
        borderColor: "rgba(75, 192, 192, 1)",
        fill: true,
        tension: 0.3,
        data: egfrReadings,
      },
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
    minRotation: 45,
  },
},
    },
  },
});

ctx = document.getElementById("bp-chart").getContext("2d");
egfrChart = new Chart(ctx, {
  type: "line",
  data: {
    labels: dateLabels,
    datasets: [
      {
        label: "Blood Pressure",
        borderColor: "rgb(192, 75, 75)",
        fill: true,
        tension: 0.5,
        data: bpReadings,
      },
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
    minRotation: 45,
  },
},
    },
  },
});