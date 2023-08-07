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
    case 'curso':
      break
    case 'graficos':
        handleCheck();
        document.addEventListener('DOMContentLoaded', function() {
          chartBarReload();
          chartLineReload();
          chartHoBarReload();
        });
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
  const colors = [];
  for(let i = 1; i <= data.data.length + 1; i++){
      colors[i] = getRandomColor();
  }

  const ctx = document.getElementById('chart-2').getContext('2d');
  new Chart(ctx, {
    type: 'pie',
    data: {
      labels: data.labels,
      datasets: [{
        data: data.data,
        backgroundColor: colors,
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
  const data = JSON.parse(jsonString)

  const keysArray = Object.keys(data);

  const years = [...new Set(keysArray.flatMap(key => Object.keys(data[key].data)))];

  const ctx = document.getElementById('chart-3').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: years,
      datasets: keysArray.map((key, index) => ({
        label: data[key].labels,
        data: Object.values(data[key].data),
        backgroundColor: getRandomColor()
      }))
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

function getRandomColor() {
  const letters = '0123456789ABCDEF';
  let color = '#';
  for (let i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
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
let loadChart;
let loadLineChart;
let loadHChart;
function handleCheck(){
    let checkboxes = document.getElementsByName('curso');
    const canvas = document.getElementById('chart-1');

    checkboxes.forEach((item, index) => {

        var cut_index = [...checkboxes]
        cut_index.splice(index, 1);

        item.addEventListener("click", () =>{

            if(item.checked == false) return

            cut_index.forEach((item, index) => {
                cut_index[index].checked = false
            });

            if (item.checked) {
                const obj = JSON.parse(item.value)

                loadChart.data.datasets[0].data = obj.data;
                loadChart.data.datasets[0].label = `Egressos de ${obj.labels}`
                loadChart.update();

                loadLineChart.data.datasets[0].data = obj.empregados;
                loadLineChart.update();

                loadHChart.data.datasets[0].data = [obj.media];
                loadHChart.data.labels = [obj.labels]
                loadHChart.update();
            } else {
                canvas.dataset.dadosGrafico = "";
            }
        })
    });
}
function chartBarReload() {
    const chartDataElement = document.getElementById('chart-1');
    const jsonString = chartDataElement.getAttribute('data-dados-grafico');

    const data = JSON.parse(jsonString);

    const ctx = document.getElementById('chart-1').getContext('2d');
    loadChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: Object.keys(data.data), // Anos como labels
            datasets: [{
                label: `Egressos de ${data.labels}`,
                data: Object.values(data.data), // Quantidade de alunos por ano
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Ano'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Alunos'
                    }
                }
            }
        }
    });
}

function chartLineReload(){
    const chartDataElement = document.getElementById('chart-2');

    const jsonString = chartDataElement.getAttribute('data-dados-grafico');

    const data = JSON.parse(jsonString);

    const ctx = document.getElementById('chart-2').getContext('2d');
    //cria o chart, estruturando os dados
    loadLineChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: Object.keys(data.empregados),
        datasets: [{
          label: 'Egressos empregados por ano',
          data: Object.values(data.empregados),
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
function chartHoBarReload(){
  const chartDataElement = document.getElementById('chart-3');

  const jsonString = chartDataElement.getAttribute('data-dados-grafico');

  const data = JSON.parse(jsonString);

  const ctx = document.getElementById('chart-3').getContext('2d');
  //cria o chart, estruturando os dados
  loadHChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [data.labels],
      datasets: [{
        label: 'Média de tempo de conclusão (anos)',
        data: [data.media],
        backgroundColor: 'rgba(0, 123, 255, 0.5)',
        borderColor: 'rgba(0, 123, 255, 1)',
        borderWidth: 1
      }]
    },
    options: {
      indexAxis: 'y',
      responsive: true,
      scales: {
        x: {
          beginAtZero: true,
          title: {
            display: true,
            text: 'Tempo de Conclusão (anos)'
          }
        },
        y: {
          title: 'curso',
          display: true
        }
      }
    }
  });
}

function goBack() {
    window.history.back();
}
