
// Assume previousReadings is an array of past eGFR values
let previousReadings = [100, 85, 70, 75]; // in future this will be given by a data base 

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

function displayeGFRresult(eGFR)
{
// Display the result
document.getElementById('result').innerHTML = `<h2>Estimated GFR: ${eGFR.toFixed(2)} mL/min/1.73m²</h2>`;
}


function updateChart(newReading) {
    // Add the new reading to the dataset

    egfrChart.data.labels.push('Reading ' + (egfrChart.data.datasets[0].data.length + 1));
    egfrChart.data.datasets[0].data.push(newReading);
    egfrChart.update();
}

let currentegfrvalue;
function GetCurrentegfrValue(list) // this needs to be improved 
{
    let LastLet = list[list.length -1];
    if (LastLet > 90)
    {
        currentegfrvalue = 1;
    }
    else if(LastLet >60 && LastLet <89)
    {
        currentegfrvalue = 2;
    }
    else if(LastLet > 30 && LastLet < 59)
    {
        currentegfrvalue = 3; // there should be a 3A and 3B check as well look at coursework doc
    }
    else if (LastLet > 15 && LastLet <29)
    {
        currentegfrvalue = 4;
    }
    else { currentegfrvalue = 5}
}


