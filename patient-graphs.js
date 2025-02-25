// eGFR Data
const egfrData = [90, 85, 80, 70, 65, 60];
const bloodData = [3.5, 4.2, 4.8, 5.0, 5.5, 5.8];

// Initialize Graphs
const ctx1 = document.getElementById('egfrGraph').getContext('2d');
const ctx2 = document.getElementById('bloodGraph').getContext('2d');

// eGFR Graph
new Chart(ctx1, {
  type: 'line',
  data: {
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
    datasets: [{
      label: 'eGFR Levels',
      data: egfrData,
      borderColor: '#0078D7',
      borderWidth: 2,
      fill: false
    }]
  },
  options: {
    responsive: true
  }
});

// Blood Analysis Graph
new Chart(ctx2, {
  type: 'bar',
  data: {
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
    datasets: [{
      label: 'Potassium Levels',
      data: bloodData,
      backgroundColor: '#51c4d3'
    }]
  },
  options: {
    responsive: true
  }
});
