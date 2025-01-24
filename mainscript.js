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

               
    // diplays the last result of the reading
    displayeGFRresult(eGFR);

    // Update the chart with the new value
    updateChart(eGFR);
});






