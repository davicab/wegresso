document.addEventListener('DOMContentLoaded', function() {
    // Recuperar o elemento com ID 'chart'
    const chartDataElement = document.getElementById('chart');

    // Verificar se o elemento foi encontrado antes de acessar o atributo data
    if (chartDataElement !== null) {
      // Recupera o JSON contendo os dados do atributo data
      const jsonString = chartDataElement.getAttribute('data-dados-grafico');

      // Faz o parsing do JSON para obter os dados
      const data = JSON.parse(jsonString);

      const ctx = document.getElementById('chart').getContext('2d');
      new Chart(ctx, {
        type: 'line',
        data: {
          labels: data.map(entry => entry.ano_egresso),
          datasets: [{
            label: 'Formados por ano',
            data: data.map(entry => entry.count),
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
    } else {
      console.error("Elemento 'chart-data' não encontrado.");
    }
  });
