document.addEventListener('DOMContentLoaded', function() {
    createChart1();
    createChart2();
});

function createChart1(){
  const chartDataElement = document.getElementById('chart-1');

  // Recupera o JSON contendo os dados do atributo data
  const jsonString = chartDataElement.getAttribute('data-dados-grafico');

  // Faz o parsing do JSON para obter os dados
  const data = JSON.parse(jsonString);

  const ctx = document.getElementById('chart-1').getContext('2d');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: data.labels,
      datasets: [{
        label: 'Formados por ano',
        data: data.data,
        backgroundColor: 'rgba(0, 123, 255, 0.5)',
        borderColor: 'rgba(0, 123, 255, 1)',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      scales: {
        x: {
            display: true,
            title: {
              display: true,
              text: 'Ano de Egresso', // Rótulo do eixo x
            }
          },
        y: {
            beginAtZero: true,
            display: true,
            title: {
                display: true,
                text: 'Contagem de Alunos', // Rótulo do eixo y
            }
        }
      }
    }
  });
}

function createChart2(){
  const chartDataElement = document.getElementById('chart-2');

  // Recupera o JSON contendo os dados do atributo data
  const jsonString = chartDataElement.getAttribute('data-dados-grafico');

  // Faz o parsing do JSON para obter os dados
  const data = JSON.parse(jsonString);

  const ctx = document.getElementById('chart-2').getContext('2d');
  new Chart(ctx, {
    type: 'pie',
    data: {
      labels: data.labels,
      datasets: [{
        data: data.data,
        backgroundColor: [
          'rgba(255, 99, 132, 0.5)', // Engenharia de Computação
          'rgba(54, 162, 235, 0.5)', // Engenharia Elétrica
          'rgba(255, 206, 86, 0.5)' // Engenharia Civil
        ],
        borderColor: [
          'rgba(255, 99, 132, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)'
        ],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true
    }
  });
}