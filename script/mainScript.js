    // script.js
document.getElementById('egfr-form').addEventListener('submit', function(event) {
    event.preventDefault();

    // Retrieve input values
    let age = parseInt(document.getElementById('age').value);
    let sex = document.getElementById('sex').value;
    let ethnicity = document.getElementById('ethnicity').value;
    let creatinine = parseFloat(document.getElementById('creatinine').value);
    let eGFR;

    // Validate inputs
    if (isNaN(age) || isNaN(creatinine) || !sex || !ethnicity) {
        alert('Please fill out all fields correctly.');
        return;
    }

    
    function calculateEGFR(sex, age, creatinine, race) {
        const sexFactor = sex === 'female' ? 0.9 : 0.7;
        const raceFactor = race === 'black'? 1.210 :1;
        // creatinine should be divided by 0.00113 to convert to mg/dl
        const eGFR = 186 * Math.pow(creatinine/88.4, -1.154) * Math.pow(age,-0.203) * sexFactor * raceFactor;
        return eGFR;
    }
    // calculates eGFR   
    eGFR = calculateEGFR(sex , age , creatinine, creatinine ,ethnicity );

    // diplays the last result of the reading
    displayeGFRresult(eGFR);

    // Update the chart with the new value
    updateChart(eGFR);

})