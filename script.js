// script.js
document.getElementById('egfr-form').addEventListener('submit', function(event) {
    event.preventDefault();

    // Retrieve input values
    let age = parseInt(document.getElementById('age').value);
    let gender = document.getElementById('gender').value;
    let ethnicity = document.getElementById('ethnicity').value;
    let creatinine = parseFloat(document.getElementById('creatinine').value);

    // Validate inputs
    if (isNaN(age) || isNaN(creatinine) || !gender || !ethnicity) {
        alert('Please fill out all fields correctly.');
        return;
    }

    // Define constants
    let k = (gender === 'female') ? 0.7 : 0.9;
    let alpha = (gender === 'female') ? -0.329 : -0.411;
    let minSCr = Math.min(creatinine / k, 1);
    let maxSCr = Math.max(creatinine / k, 1);
    let genderFactor = (gender === 'female') ? 1.018 : 1;
    let ethnicityFactor = (ethnicity === 'black') ? 1.159 : 1;

    // Calculate eGFR
    let eGFR = 141 * Math.pow(minSCr, alpha) * Math.pow(maxSCr, -1.209) *
               Math.pow(0.993, age) * genderFactor * ethnicityFactor;

    // Display the result
    document.getElementById('result').innerHTML = `<h2>Estimated GFR: ${eGFR.toFixed(2)} mL/min/1.73m²</h2>`;

    // Update the chart with the new value
    updateChart(eGFR);
});

// Assume previousReadings is an array of past eGFR values
let previousReadings = [90, 85, 80, 75]; // This would come from a database or user input

// Create the chart
let ctx = document.getElementById('egfr-chart').getContext('2d');
let egfrChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Reading 1', 'Reading 2', 'Reading 3', 'Reading 4'],
        datasets: [{
            label: 'eGFR over Time',
            data: previousReadings,
            borderColor: 'rgba(75, 192, 192, 1)',
            fill: false,
            tension: 0.1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: false,
                title: {
                    display: true,
                    text: 'eGFR (mL/min/1.73m²)'
                }
            }
        }
    }
});

function updateChart(newReading) {
    // Add the new reading to the dataset
    egfrChart.data.labels.push('Current Reading');
    egfrChart.data.datasets[0].data.push(newReading);
    egfrChart.update();
}
