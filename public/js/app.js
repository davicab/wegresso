var currentPage=page;switch(currentPage){case"home":document.addEventListener("DOMContentLoaded",function(){createChart1(),createChart2(),createChart3(),createChart4()});break;case"curso":break;case"graficos":handleCheck(),document.addEventListener("DOMContentLoaded",function(){chartBarReload(),chartLineReload(),chartHoBarReload()})}function createChart1(){var a=document.getElementById("chart-1").getAttribute("data-dados-grafico"),a=JSON.parse(a),e=document.getElementById("chart-1").getContext("2d");new Chart(e,{type:"line",data:{labels:a.labels,datasets:[{label:"Formados por ano",data:a.data,backgroundColor:"rgba(0, 123, 255, 0.5)",borderColor:"rgba(0, 123, 255, 1)",borderWidth:1}]},options:{responsive:!0,scales:{x:{display:!0,title:{display:!0,text:"Ano de Egresso"}},y:{beginAtZero:!0,display:!0,title:{display:!0,text:"Contagem de Alunos"}}}}})}function createChart2(){var a=document.getElementById("chart-2").getAttribute("data-dados-grafico"),e=JSON.parse(a),t=[];for(let a=1;a<=e.data.length+1;a++)t[a]=getRandomColor();a=document.getElementById("chart-2").getContext("2d");new Chart(a,{type:"pie",data:{labels:e.labels,datasets:[{data:e.data,backgroundColor:t}]},options:{responsive:!0}})}function createChart3(){var a=document.getElementById("chart-3").getAttribute("data-dados-grafico");const t=JSON.parse(a);var a=Object.keys(t),e=[...new Set(a.flatMap(a=>Object.keys(t[a].data)))],o=document.getElementById("chart-3").getContext("2d");new Chart(o,{type:"bar",data:{labels:e,datasets:a.map((a,e)=>({label:t[a].labels,data:Object.values(t[a].data),backgroundColor:getRandomColor()}))},options:{responsive:!0,scales:{x:{stacked:!0,title:{display:!0,text:"Ano"}},y:{stacked:!0,title:{display:!0,text:"Alunos"}}}}})}function getRandomColor(){let e="#";for(let a=0;a<6;a++)e+="0123456789ABCDEF"[Math.floor(16*Math.random())];return e}function createChart4(){var a=document.getElementById("chart-4").getAttribute("data-dados-grafico"),a=JSON.parse(a),e=document.getElementById("chart-4").getContext("2d");new Chart(e,{type:"bar",data:{labels:a.data.map(a=>a.ano_egresso),datasets:[{label:"Valores",data:a.data.map(a=>a.empregados),backgroundColor:"rgba(54, 162, 235, 0.5)",borderColor:"rgba(54, 162, 235, 1)",borderWidth:1}]},options:{responsive:!0,scales:{y:{beginAtZero:!0}}}})}let loadChart,loadLineChart,loadHChart;function handleCheck(){let o=document.getElementsByName("curso");const d=document.getElementById("chart-1");o.forEach((e,a)=>{var t=[...o];t.splice(a,1),e.addEventListener("click",()=>{var a;0!=e.checked&&(t.forEach((a,e)=>{t[e].checked=!1}),e.checked?(a=JSON.parse(e.value),loadChart.data.datasets[0].data=a.data,loadChart.data.datasets[0].label="Egressos de "+a.labels,loadChart.update(),loadLineChart.data.datasets[0].data=a.empregados,loadLineChart.update(),loadHChart.data.datasets[0].data=[a.media],loadHChart.data.labels=[a.labels],loadHChart.update()):d.dataset.dadosGrafico="")})})}function chartBarReload(){var a=document.getElementById("chart-1").getAttribute("data-dados-grafico"),a=JSON.parse(a),e=document.getElementById("chart-1").getContext("2d");loadChart=new Chart(e,{type:"bar",data:{labels:Object.keys(a.data),datasets:[{label:"Egressos de "+a.labels,data:Object.values(a.data),backgroundColor:"rgba(54, 162, 235, 0.5)",borderColor:"rgba(54, 162, 235, 1)",borderWidth:1}]},options:{responsive:!0,scales:{x:{title:{display:!0,text:"Ano"}},y:{title:{display:!0,text:"Alunos"}}}}})}function chartLineReload(){var a=document.getElementById("chart-2").getAttribute("data-dados-grafico"),a=JSON.parse(a),e=document.getElementById("chart-2").getContext("2d");loadLineChart=new Chart(e,{type:"line",data:{labels:Object.keys(a.empregados),datasets:[{label:"Egressos empregados por ano",data:Object.values(a.empregados),backgroundColor:"rgba(0, 123, 255, 0.5)",borderColor:"rgba(0, 123, 255, 1)",borderWidth:1}]},options:{responsive:!0,scales:{x:{display:!0,title:{display:!0,text:"Ano de Egresso"}},y:{beginAtZero:!0,display:!0,title:{display:!0,text:"Contagem de Alunos"}}}}})}function chartHoBarReload(){var a=document.getElementById("chart-3").getAttribute("data-dados-grafico"),a=JSON.parse(a),e=document.getElementById("chart-3").getContext("2d");loadHChart=new Chart(e,{type:"bar",data:{labels:[a.labels],datasets:[{label:"Média de tempo de conclusão (anos)",data:[a.media],backgroundColor:"rgba(0, 123, 255, 0.5)",borderColor:"rgba(0, 123, 255, 1)",borderWidth:1}]},options:{indexAxis:"y",responsive:!0,scales:{x:{beginAtZero:!0,title:{display:!0,text:"Tempo de Conclusão (anos)"}},y:{title:"curso",display:!0}}}})}function goBack(){window.history.back()}