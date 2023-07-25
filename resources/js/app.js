var currentPage = page;
switch (currentPage){
    case 'home':
        document.addEventListener('DOMContentLoaded', function() {
          createChart1();
          createChart2();
          createChart3();
          createChart4();
        });
      break;
    case 'graficos':
      createChartCurso();
      break
}
//criaçao do grafico de linhas
function createChart1(){
  //seleciona o elemento chart do html
  const chartDataElement = document.getElementById('chart-1');

  // Recupera o JSON contendo os dados do atributo data
  const jsonString = chartDataElement.getAttribute('data-dados-grafico');

  // Faz o parsing do JSON para obter os dados
  const data = JSON.parse(jsonString);

  const ctx = document.getElementById('chart-1').getContext('2d');
  //cria o chart, estruturando os dados 
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
// criação do grafico de 'torta'
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
//criacao do grafico "stacked"
function createChart3(){
  const chartDataElement = document.getElementById('chart-3');

  // Recupera o JSON contendo os dados do atributo data
  const jsonString = chartDataElement.getAttribute('data-dados-grafico');

  // Faz o parsing do JSON para obter os dados
  const data = JSON.parse(jsonString);

  const ctx = document.getElementById('chart-3').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: data.data.map(entry => entry.ano_egresso),
      datasets: [{
        label: data.labels[0],
        data: data.data.map(entry => entry.curso0),
        backgroundColor: 'rgba(255, 99, 132, 0.5)'
      }, {
        label: data.labels[1],
        data: data.data.map(entry => entry.curso1),
        backgroundColor: 'rgba(54, 162, 235, 0.5)'
      }, {
        label: data.labels[2],
        data: data.data.map(entry => entry.curso2),
        backgroundColor: 'rgba(255, 206, 86, 0.5)'
      }]
    },
    options: {
      responsive: true,
      scales: {
        x: {
          stacked: true,
          title: {
            display: true,
            text: 'Ano'
          }
        },
        y: {
          stacked: true,
          title: {
            display: true,
            text: 'Alunos'
          }
        }
      }
    }
  });
}
//criacao do grafico "bars"
function createChart4(){
  const chartDataElement = document.getElementById('chart-4');

  // Recupera o JSON contendo os dados do atributo data
  const jsonString = chartDataElement.getAttribute('data-dados-grafico');

  // Faz o parsing do JSON para obter os dados
  const data = JSON.parse(jsonString);

  const ctx = document.getElementById('chart-4').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: data.data.map(entry => entry.ano_egresso),
      datasets: [{
        label: 'Valores',
        data: data.data.map(entry => entry.empregados),
        backgroundColor: 'rgba(54, 162, 235, 0.5)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
}
function createChartCurso(){
  const chartDataElement = document.getElementById('chart-curso');

  // Recupera o JSON contendo os dados do atributo data
  const jsonString = chartDataElement.getAttribute('data-dados-grafico');

  // Faz o parsing do JSON para obter os dados
  const data = JSON.parse(jsonString);

  console.log(data)

  const ctx = document.getElementById('chart-curso').getContext('2d');
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
            beginAtZero: false,
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