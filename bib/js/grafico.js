google.charts.load('current', { packages: ['corechart', 'bar'] });
google.charts.setOnLoadCallback(drawColColors);

function drawColColors() {  
  var data = new google.visualization.DataTable();
  data.addColumn('string', 'Meses');
  data.addColumn('number', 'Completos');
  data.addColumn('number', 'Incompletos');
  data.addColumn('number', 'Não realizado');
  data.addRows([
    ['Janeiro', 4, 6, 1],
    ['Fevereiro', 8, 7, 5],
    ['Março', 5, 7, 5],
    ['Abril', 8, 6, 7],
    ['Maio', 3, 4, 8],
    ['Junho', 6, 7, 3],
    ['Julho', 2, 9, 6],
    ['Agosto', 5, 8, 3],
    ['Setembro', 7, 7, 1],
    ['Outubro', 4, 9, 5], 
    ['Novembro', 6, 4, 3],
    ['Dezembro', 9, 5, 7],
  ]);

  var options = {
    'legend':'right',
    'title':'Listagem dos equipamentos',  
    colors: ['#14591b', '#ff9d00', '#be181a'],
    'margin': -10,
    'is3D':true,
    seriesType: "bars",
    series: {4: {type: "line"}}
  };

  var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
  chart.draw(data, options);
}

google.charts.load("current", { packages: ["corechart"] });
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
  var data = google.visualization.arrayToDataTable([
    ['Task', 'Hours per Day'],
    ['Completo', 30],
    ['Incompleto', 40],
    ['Não realizado', 30],
  ]);

  var options = {
    title: '',
    colors: ['#14591b', '#ff9d00', '#be181a'],
    pieHole: 0.4,
  };

  var chart = new google.visualization.PieChart(document.getElementById('donutchart1'));
  chart.draw(data, options);
  var chart2 = new google.visualization.PieChart(document.getElementById('donutchart2'));
  chart2.draw(data, options);
} 