const form = document.getElementById("egfr-form");
const ctx = document.getElementById("egfrGraph").getContext("2d");

let egfrData = {
  labels: [], // X-axis labels (e.g., Test 1, Test 2, etc.)
  datasets: [
    {
      label: "eGFR Value (ml/min/1.73m²)",
      data: [], // Calculated eGFR values
      backgroundColor: "rgba(75, 192, 192, 0.2)", // Transparent fill
      borderColor: "rgba(75, 192, 192, 1)", // Line color
      borderWidth: 2,
    },
  ],
};
// Create the Chart.js graph
const egfrChart = new Chart(ctx, {
  type: "line", // Line chart
  data: egfrData,
  options: {
    responsive: true, 
    plugins: {
      legend: {
        position: "top", 
      },
    },
    scales: {
      y: {
        beginAtZero: true, 
        title: {
          display: true,
          text: "eGFR (ml/min/1.73m²)", 
        },
      },
    },
  },
});

// Function to calculate eGFR using the MDRD formula
function calculateEGFR(creatinine, age, gender, ethnicity) {
  let multiplier = 1;
  if (gender === "female") multiplier *= 0.742;
  if (ethnicity === "black") multiplier *= 1.21;

  // MDRD formula
  const eGFR = (
    186 *
    Math.pow(creatinine / 88.4, -1.154) * // Convert creatinine to mg/dL
    Math.pow(age, -0.203) *
    multiplier
  ).toFixed(2); // Round to 2 decimal places

  return eGFR;
}

// Event listener for the form submission
form.addEventListener("submit", (event) => {
  event.preventDefault(); // Prevent the form from reloading the page

  // Get input values from the form
  const age = parseInt(document.getElementById("age").value, 10);
  const gender = document.getElementById("gender").value;
  const ethnicity = document.getElementById("ethnicity").value;
  const creatinine = parseFloat(document.getElementById("creatinine").value);

  // Calculate the eGFR value
  const eGFR = calculateEGFR(creatinine, age, gender, ethnicity);

  // Determine the CKD stage based on eGFR
  let ckdStage = "";
  if (eGFR >= 90) ckdStage = "Stage 1 (Normal)";
  else if (eGFR >= 60) ckdStage = "Stage 2 (Mildly Reduced)";
  else if (eGFR >= 45) ckdStage = "Stage 3A (Moderately Reduced)";
  else if (eGFR >= 30) ckdStage = "Stage 3B (Severely Reduced)";
  else if (eGFR >= 15) ckdStage = "Stage 4 (Severely Reduced)";
  else ckdStage = "Stage 5 (Kidney Failure)";

  // Update the graph
  const currentTest = `Test ${egfrData.labels.length + 1}`; 
  egfrData.labels.push(currentTest); 
  egfrData.datasets[0].data.push(eGFR); 
  
  egfrChart.update(); 

  alert(`Your eGFR: ${eGFR} ml/min/1.73m²\nCKD Stage: ${ckdStage}`);
});
