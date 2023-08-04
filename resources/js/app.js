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
  console.log(data)

  const keysObj = {};

  // Percorre a array data.data
  data.data.forEach(item => {
    // Itera sobre as chaves do objeto (exceto "ano_egresso")
    for (const key in item) {
      if (key !== "ano_egresso") {
        // Armazena a chave no objeto keysObj
        keysObj[key] = true;
      }
    }
  });
  
  // Obtém um array contendo todas as chaves do objeto keysObj
  const keysArray = Object.keys(keysObj);
  
  console.log(keysArray);

  const ctx = document.getElementById('chart-3').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: data.data.map(entry => entry.ano_egresso),

      datasets : keysArray.map((key, index) => ({
        label: data.labels[index],
        data: data.data.map(entry => entry[key]),
        backgroundColor: getRandomColor()
      }))
      // datasets: [
      // {
      //   label: data.labels[0],
      //   data: data.data.map(entry => entry.curso1),
      //   backgroundColor: 'rgba(255, 99, 132, 0.5)'
      // }, {
      //   label: data.labels[1],
      //   data: data.data.map(entry => entry.curso2),
      //   backgroundColor: 'rgba(54, 162, 235, 0.5)'
      // }, {
      //   label: data.labels[2],
      //   data: data.data.map(entry => entry.curso3),
      //   backgroundColor: 'rgba(255, 206, 86, 0.5)'
      // }]
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

                loadChart.data.datasets[0].data = obj.data.map(entry => entry.curso);
                loadChart.data.datasets[0].label = `Egressos de ${obj.labels}`
                loadChart.update();

                loadLineChart.data.datasets[0].data = obj.empregados.map(entry => entry.empregados);
                loadLineChart.update();

                loadHChart.data.datasets[0].data = [obj.mediaFormatura];
                loadHChart.data.labels = obj.labels
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
          labels: data.data.map(entry => entry.ano_egresso),
          datasets: [{
              label: `Egressos de ${data.labels}`,
              data: data.data.map(entry => entry.curso),
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
        labels: data.empregados.map(entry => entry.ano_egresso),
        datasets: [{
          label: 'Egressos empregados por ano',
          data: data.empregados.map(entry => entry.empregados),
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
      labels: data.labels,
      datasets: [{
        label: 'Média de tempo de conclusão (anos)',
        data: [data.mediaFormatura],
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
        }
      }
    }
  });
}

function goBack() {
    window.history.back();
}
