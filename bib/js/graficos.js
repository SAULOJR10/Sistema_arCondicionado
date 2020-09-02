$(document).ready(function () {
  if (document.getElementById('idEnt') != undefined) {
    GraficoRosca();
    GraficoTorresQuinzenal();
    GraficoTorresMensal();
    GraficoTorresTrimestral();
    GraficoTorresAnual();
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
  GraficoTorresQuinzenal();
  GraficoTorresMensal();
  GraficoTorresTrimestral();
  GraficoTorresAnual();
}

google.charts.load("current", { packages: ["corechart"] });
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
      var quant = explode.length - 1;
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

function GraficoTorresQuinzenal() {
  var idEnt = document.getElementById('idEnt').value;
  $.ajax({
    method: 'post',
    dataType: 'json',
    url: 'bib/ajax/SelecionarGraficos.json.php',
    data: {
      acao: 'GraficosTorresQuinzenal',
      idEnt: idEnt,
      processoData: false,
      contentype: false,
    },
    success: function (data) {
      var dados = new google.visualization.DataTable();
      dados.addColumn('string', 'Meses');
      dados.addColumn('number', 'Completos');
      dados.addColumn('number', 'Incompletos');
      dados.addColumn('number', 'Não realizado');
      dados.addRows(data);

      var options = {
        legend: 'right',
        title: 'Check-Lists Quinzenal',
        titleTextStyle: { bold: false, fontSize: 20 },
        colors: ['#14591b', '#ff9d00', '#be181a'],
        'is3D': true,
        seriesType: "bars",
        chartArea: { left: '5%', top: '20%', bottom: '15%', width: '80%', height: '80%' },
        fontSize: 12,
        series: { 4: { type: "line" } }
      };

      var chart = new google.visualization.ColumnChart(document.getElementById('graficosTorresquinzenal'));
      chart.draw(dados, options);
    },
    error: function (msg) {
      alert(msg.responseText);
      $('#Ordem').after(msg.responseText);
    }
  });
}
function GraficoTorresMensal() {
  var idEnt = document.getElementById('idEnt').value;
  $.ajax({
    method: 'post',
    dataType: 'json',
    url: 'bib/ajax/SelecionarGraficos.json.php',
    data: {
      acao: 'GraficosTorresMensal',
      idEnt: idEnt,
      processoData: false,
      contentype: false,
    },
    success: function (data) {
      var dados = new google.visualization.DataTable();
      dados.addColumn('string', 'Meses');
      dados.addColumn('number', 'Completos');
      dados.addColumn('number', 'Incompletos');
      dados.addColumn('number', 'Não realizado');
      dados.addRows(data);

      var options = {
        legend: 'right',
        title: 'Check-Lists Quinzenal',
        titleTextStyle: { bold: false, fontSize: 20 },
        colors: ['#14591b', '#ff9d00', '#be181a'],
        'is3D': true,
        seriesType: "bars",
        chartArea: { left: '5%', top: '20%', bottom: '15%', width: '80%', height: '80%' },
        fontSize: 12,
        series: { 4: { type: "line" } }
      };

      var chart = new google.visualization.ColumnChart(document.getElementById('graficosTorresmensal'));
      chart.draw(dados, options);
    },
    error: function (msg) {
      alert(msg.responseText);
      $('#Ordem').after(msg.responseText);
    }
  });
}
function GraficoTorresTrimestral() {
  var idEnt = document.getElementById('idEnt').value;
  $.ajax({
    method: 'post',
    dataType: 'json',
    url: 'bib/ajax/SelecionarGraficos.json.php',
    data: {
      acao: 'GraficosTorresTrimestral',
      idEnt: idEnt,
      processoData: false,
      contentype: false,
    },
    success: function (data) {
      var dados = new google.visualization.DataTable();
      dados.addColumn('string', 'Meses');
      dados.addColumn('number', 'Completos');
      dados.addColumn('number', 'Incompletos');
      dados.addColumn('number', 'Não realizado');
      dados.addRows(data);

      var options = {
        legend: 'right',
        title: 'Check-Lists Quinzenal',
        titleTextStyle: { bold: false, fontSize: 20 },
        colors: ['#14591b', '#ff9d00', '#be181a'],
        'is3D': true,
        seriesType: "bars",
        chartArea: { left: '5%', top: '20%', bottom: '15%', width: '80%', height: '80%' },
        fontSize: 12,
        series: { 4: { type: "line" } }
      };

      var chart = new google.visualization.ColumnChart(document.getElementById('graficosTorrestrimestral'));
      chart.draw(dados, options);
    },
    error: function (msg) {
      alert(msg.responseText);
      $('#Ordem').after(msg.responseText);
    }
  });
}
function GraficoTorresAnual() {
  var idEnt = document.getElementById('idEnt').value;
  $.ajax({
    method: 'post',
    dataType: 'json',
    url: 'bib/ajax/SelecionarGraficos.json.php',
    data: {
      acao: 'GraficosTorresAnual',
      idEnt: idEnt,
      processoData: false,
      contentype: false,
    },
    success: function (data) {
      var dados = new google.visualization.DataTable();
      dados.addColumn('string', 'Meses');
      dados.addColumn('number', 'Completos');
      dados.addColumn('number', 'Incompletos');
      dados.addColumn('number', 'Não realizado');
      dados.addRows(data);

      var options = {
        legend: 'right',
        title: 'Check-Lists Quinzenal',
        titleTextStyle: { bold: false, fontSize: 20 },
        colors: ['#14591b', '#ff9d00', '#be181a'],
        'is3D': true,
        seriesType: "bars",
        chartArea: { left: '5%', top: '20%', bottom: '15%', width: '80%', height: '80%' },
        fontSize: 12,
        series: { 4: { type: "line" } }
      };

      var chart = new google.visualization.ColumnChart(document.getElementById('graficosTorresanual'));
      chart.draw(dados, options);
    },
    error: function (msg) {
      alert(msg.responseText);
      $('#Ordem').after(msg.responseText);
    }
  });
}