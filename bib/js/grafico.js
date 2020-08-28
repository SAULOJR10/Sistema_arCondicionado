$(document).ready(function () {
  if (document.getElementById('idEnt') != undefined) {
    GraficoRosca();
  } else {
    SelectEnt('QualEnt');
    $('#modalEnt').modal('show');
  }
});

function SelectEnt(acao) {
  $('#nome_cliente').empty();
  var idUsuario = document.getElementById('idLogin').value;
  $.ajax({
      method: 'post',
      dataType: 'json',
      url: 'bib/ajax/SelecionarGraficos.json.php',
      data: {
          acao: acao,
          idUsuario: idUsuario,
          processoData: false,
          contentype: false,
      },
      success: function (data) {
          if (acao == 'QualEnt') {
              $('#SelectEnt').append('<h4 style=\'text-align:center;\'>Selecione a entidade:</h4>' + data);
          } else {
              $('#nome_cliente').append(data);
              $('#onclick').removeAttr('onclick');
          }
      },
      error: function (msg) {
          alert(msg.responseText);
      }
  });
}
function EntSelected(acao) {
  var idEnt = document.getElementById('EntidadeGer').value;
  var nomeEnt = document.getElementById('optionEnt' + idEnt).textContent;
  $('#nome_cliente').empty();
  $('#nome_cliente').append("<input type='hidden' id='idEnt' value='" + idEnt + "'>" + nomeEnt);
  $('#buttonModal').attr('data-dismiss', 'modal');
  GraficoRosca();
}

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
    'legend': 'right',
    'title': 'Listagem dos equipamentos',
    colors: ['#14591b', '#ff9d00', '#be181a'],
    'margin': -10,
    'is3D': true,
    seriesType: "bars",
    series: { 4: { type: "line" } }
  };

  var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
  chart.draw(data, options);
}

function GraficoRosca() {
  var idEnt = document.getElementById('idEnt').value;
  $.ajax({
    method: 'post',
    dataType: 'json',
    url: 'bib/ajax/SelecionarGraficos.json.php',
    data: {
      acao: 'GraficosRosca',
      idEnt: idEnt,
      processoData: false,
      contentype: false,
    },
    success: function (data) {
      var explode = data.split('&');
      var quant = explode.length -1;
      for (i = 0; i <= quant; i++) {
        if (i == 0) {
          id = 'Quinzenal';
        }
        if (i == 1) {
          id = 'Mensal';
        }
        if (i == 2) {
          id = 'Trimestral';
        }
        if (i == 3) {
          id = 'Anual';
        }
        var check_list = explode[i];
        var check_list = check_list.split(',');
        var completa = parseInt(check_list[0]);
        var incompleta = parseInt(check_list[1]);
        var naoRealizada = parseInt(check_list[2]);
        google.charts.load("current", { packages: ["corechart"] });
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Completa', completa],
          ['Incompleta', incompleta],
          ['Não realizada', naoRealizada],
        ]);

        var options = {
          pieHole: 0.3,
          tooltip: { text: 'value' },
          chartArea: { left: '10%', bottom: '15%', width: '80%', height: '80%' },
          colors: ['#69bd63', '#ff9d00', '#dc3912'],
          legend: { position: 'bottom' },
          fontSize: 12,
          pieSliceText: 'value',
          pieSliceTextStyle: { color: 'black', fontSize: '120px', margin: '20px' },
        };

        var chart = new google.visualization.PieChart(document.getElementById(id));
        chart.draw(data, options);
      }
    },
    error: function (msg) {
      alert(msg.responseText);
    }
  });
} 