$(document).ready(function () {
    if (document.getElementById('idAr') != undefined) {
        $('#CheckList').modal('hide');
        MontarTela();
    } else {
        MontarQualUH('primeiro');
    }
    $('#onclick').removeAttr('onclick');
    var url = window.location.href;
    var url = url.split('&')[0];
    $('#onclick').attr('href', url);
});
url = window.location.href;
urlEnt = '';
urlAr = '';
urlUH = '';

function SelectEnt(acao) {
    $('#nome_cliente').empty();
    var idUsuario = document.getElementById('idLogin').value;
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/SelecionarCheckManutencao.json.php',
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
    MontarQualUH('selectBloco');
    var Ent = document.getElementById('nome_cliente').innerHTML;
    urlEnt = url + '&Ent=' + Ent;
}

function Refresh() {
    var url = window.location.href;
    var url = url.split('&')[0];
    window.location.href = url;
    document.location.reload(true);
}

function OutroAr() {
    var idEnt = document.getElementById('idEnt').value;
    var idUH = document.getElementById('idUH').value;
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/SelecionarCheckManutencao.json.php',
        data: {
            acao: 'Ar',
            idEnt: idEnt,
            idUH: idUH,
        },
        success: function (data) {
            $('#SelectEnt').attr('style', 'visibility:hidden; height:1px;');
            $('#SelectBloco').empty();
            $('#SelectAndar').empty();
            $('#SelectAr').empty();
            $('#SelectAr').append(data);
            $('#CheckList').modal('show');
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}

function SalvaCheckList() {
    var funcionario = document.getElementById('idLogin').value;
    var idUH = document.getElementById('idUH').value;
    var idAr = document.getElementById('idAr').value;
    var periodo = document.getElementById('periodo').value;
    var quantItem = document.getElementsByName('allitem').length;
    var statusCheck = true;
    var finalizados = ';';
    var naoFinalizados = ';';
    var statusFinalizados = ';';
    var statusNaoFinalizados = ';';
    var FinalizadosOBS = ';';
    var NaoFinalizadosOBS = ';';
    for (i = 1; i <= quantItem; i++) {
        if ($('#ch_item' + i).is(':checked')) {
            var finalizados = finalizados + document.getElementById('ch_item' + i).value + ';';
            var statusFinalizados = statusFinalizados + true + ';';
            var FinalizadosOBS = FinalizadosOBS + document.getElementById('obs' + i).value + ';';
        } else {
            var statusCheck = false;
            var naoFinalizados = naoFinalizados + document.getElementById('ch_item' + i).value + ';';
            var statusNaoFinalizados = statusNaoFinalizados + false + ';';
            var NaoFinalizadosOBS = NaoFinalizadosOBS + document.getElementById('obs' + i).value + ';';
        }
    }
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/CadastrarCheckManutencao.json.php',
        data: {
            acao: 'CheckList',
            funcionario: funcionario,
            idUH: idUH,
            idAr: idAr,
            statusCheck: statusCheck,
            finalizados: finalizados,
            naoFinalizados: naoFinalizados,
            FinalizadosOBS: FinalizadosOBS,
            NaoFinalizadosOBS: NaoFinalizadosOBS,
            statusFinalizados: statusFinalizados,
            statusNaoFinalizados: statusNaoFinalizados,
            periodo: periodo,
        },
        success: function (data) {
            VoltarTodos();
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}

function Continue(id) {
    window.location.href = id;
}

function MontarQualUH(acao) {
    $('#CheckList').modal('show');
    if (acao == 'colocarButton') {
        var idAr = document.getElementById('Ar').value;
        $('#ColocarAr').empty();
        $('#ColocarAr').append('<input type="hidden" id="idAr" value="' + idAr + '">');
        urlAr = urlUH + '&idAr=' + idAr;
        $('#btao_relat').attr('onclick', 'Continue(\'' + urlAr + '\')');
        return;
    }
    if (document.getElementById('idEnt') != undefined) {
        var idEnt = document.getElementById('idEnt').value;
        if (document.getElementById('Bloco') != undefined) {
            var idBloco = document.getElementById('Bloco').value;
        } else {
            var idBloco = '';
        }
        if (document.getElementById('andarGer') != undefined) {
            var andar = document.getElementById('andarGer').value;
        } else {
            var andar = '';
        }
        if (document.getElementById('UHGer') != undefined) {
            var idUH = document.getElementById('UHGer').value;
            $('#IDUH').empty();
            $('#IDUH').append('<input type="hidden" value="' + idUH + '" id="idUH">');
            urlUH = urlEnt + '&idUH=' + idUH;
        } else {
            var idUH = '';
        }
        if (document.getElementById('idAr') != undefined) {
            var idAr = document.getElementById('idAr').value;
        } else {
            var idAr = '';
        }
        if (acao == 'primeiro') {
            acao = 'selectBloco';
        }
    } else {
        SelectEnt('QualEnt');
        $('#SelectBloco').empty();
        $('#SelectAndar').empty();
        $('#btao_relat').removeAttr('onclick');
        return;
    }
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/SelecionarCheckManutencao.json.php',
        data: {
            acao: acao,
            idEnt: idEnt,
            idBloco: idBloco,
            andar: andar,
            idUH: idUH,
        },
        success: function (data) {
            if (acao == 'selectBloco') {
                $('#SelectBloco').empty();
                $('#SelectBloco').append(data);
                $('#SelectUH').empty();
                $('#SelectAndar').empty();
                $('#SelectAr').empty();
                $('#btao_relat').removeAttr('onclick');
                $('#IDUH').empty();
                $('#ColocarAr').empty();
            }
            if (acao == 'Andar') {
                $('#SelectAndar').empty();
                $('#SelectAndar').append(data);
                $('#SelectUH').empty();
                $('#SelectAr').empty();
                $('#btao_relat').removeAttr('onclick');
                $('#IDUH').empty();
                $('#ColocarAr').empty();
            }
            if (acao == 'UH') {
                $('#SelectUH').empty();
                $('#SelectUH').append(data);
                $('#SelectAr').empty();
                $('#btao_relat').removeAttr('onclick');
                $('#IDUH').empty();
                $('#ColocarAr').empty();
            }
            if (acao == 'Ar') {
                $('#SelectAr').empty();
                $('#SelectAr').append(data);
                $('#ColocarAr').empty();
            }
            $('#CheckList').modal('show');
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}

function descerScroll(num) {
    num2 = num + 200;
    $('#descer').attr('onclick', 'descerScroll('+num2+')');
    window.scroll(0, num2);
}

function abrirModal(modal) {
    $('#' + modal).modal('show');
}

function Avisar() {
    var idUH = document.getElementById('idUH').value;
    var data = document.getElementById('dataAgend').value;
    var obs = document.getElementById('observacao').value;
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/CadastrarCheckManutencao.json.php',
        data: {
            acao: 'Avisar',
            idUH: idUH,
            data: data,
            obs: obs,
        },
        success: function (data) {
            $('#agendar').modal('hide');
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}

function QualUH() {
    var idUH = document.getElementById('UHGer').value;
    $('#IDUH').empty();
    $('#IDUH').append('<input type="hidden" id="idUH" value="' + idUH + '">');
    $('#btao_relat').removeAttr('onclick');
    $('#CheckList').modal('hide');
    MontarTela();
    VoltarTodos();
}
function VoltarTodos() {
    $('#TodosCheck').removeAttr('style');
    $('#checklist').empty();
    MontarTela();
}

function MarcarTodos() {
    var todos = document.getElementsByName('allitem').length;
    for (i = 1; i <= todos; i++) {
        $('#ch_item' + i).prop('checked', true);
    }
}

function ColocarOBS(id) {
    $('#tirar' + id).empty();
    $('#obs' + id).removeAttr('style');
    $('#obs' + id).attr('style', 'width:100%;');
    $('#obs' + id).focus();
}

function CheckList(id) {
    var uh = document.getElementById('idUH').value;
    var idLogin = document.getElementById('idLogin').value;
    var idAr = document.getElementById('idAr').value;
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/SelecionarCheckManutencao.json.php',
        data: {
            acao: 'MontarCheckList',
            uh: uh,
            idLogin: idLogin,
            idAr: idAr,
            id: id,
        },
        success: function (data) {
            $('#TodosCheck').attr('style', 'display:none;');
            $('#checklist').empty();
            $('#checklist').append(data);
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}

function MontarTela() {
    var idUH = document.getElementById('idUH').value;
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/SelecionarCheckManutencao.json.php',
        data: {
            acao: 'MontarTela',
            uh: idUH,
        },
        success: function (data) {
            $('.UHs').empty();
            $('.UHs').append(data.split(';')[1]);
            $('.Blocos').empty();
            $('.Blocos').append(data.split(';')[2]);
            google.charts.setOnLoadCallback(drawChart1);
            google.charts.setOnLoadCallback(drawChart2);
            google.charts.setOnLoadCallback(drawChart3);
            google.charts.setOnLoadCallback(drawChart4);
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}
google.charts.load("current", { packages: ["corechart"] });
function drawChart1() {
    var idUH = document.getElementById('idUH').value;
    var idAr = document.getElementById('idAr').value;
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/SelecionarCheckManutencao.json.php',
        data: {
            acao: 'Quinzenal',
            uh: idUH,
            idAr: idAr,
        },
        success: function (data) {
            var quantTotal = data.split(';')[0];
            $('#tituloQuinzenal').empty();
            $('#tituloQuinzenal').append('<h5>Total de itens: ' + quantTotal + '</h5>');
            var quantFinalizados = data.split(';')[1];
            var quantNaoFinalizados = data.split(';')[2];
            if (quantFinalizados == 0 && quantNaoFinalizados == 0) {
                quantNaoFinalizados = quantTotal;
            }
            var dataCheck = data.split(';')[3];
            $('#dataQuinzenal').empty();
            $('#dataQuinzenal').append(dataCheck);
            var status = data.split(';')[4];
            $('#statusQuinzenal').empty();
            $('#statusQuinzenal').append(status);
            var data = google.visualization.arrayToDataTable([
                ['Titulo', 'Quantidade'],
                ['Finalizados', parseInt(quantFinalizados)],
                ['Restante', parseInt(quantNaoFinalizados)],
            ]);

            var options = {
                pieHole: 0.3,
                tooltip: { text: 'value' },
                backgroundColor: '#f3f6fb',
                chartArea: { left: '10%', bottom: '15%', width: '80%', height: '80%' },
                colors: ['#69bd63', '#dc3912'],
                legend: { position: 'bottom' },
                fontSize: 12,
                pieSliceText: 'value',
                pieSliceTextStyle: { color: 'black' },
            };

            var chart = new google.visualization.PieChart(document.getElementById('donutchart1'));
            chart.draw(data, options);
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}

function drawChart2() {
    google.charts.load("current", { packages: ["corechart"] });
    var idUH = document.getElementById('idUH').value;
    var idAr = document.getElementById('idAr').value;
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/SelecionarCheckManutencao.json.php',
        data: {
            acao: 'Mensal',
            uh: idUH,
            idAr: idAr,
        },
        success: function (data) {
            var quantTotal = data.split(';')[0];
            $('#tituloMensal').empty();
            $('#tituloMensal').append('<h5>Total de itens: ' + quantTotal + '</h5>');
            var quantFinalizados = data.split(';')[1];
            var quantNaoFinalizados = data.split(';')[2];
            if (quantFinalizados == 0 && quantNaoFinalizados == 0) {
                quantNaoFinalizados = quantTotal;
            }
            var dataCheck = data.split(';')[3];
            $('#dataMensal').empty();
            $('#dataMensal').append(dataCheck);
            var status = data.split(';')[4];
            $('#statusMensal').empty();
            $('#statusMensal').append(status);
            var data = google.visualization.arrayToDataTable([
                ['Titulo', 'Quantidade'],
                ['Finalizados', parseInt(quantFinalizados)],
                ['Restante', parseInt(quantNaoFinalizados)],
            ]);

            var options = {
                pieHole: 0.3,
                tooltip: { text: 'value' },
                backgroundColor: '#f3f6fb',
                chartArea: { left: '10%', bottom: '15%', width: '80%', height: '80%' },
                colors: ['#69bd63', '#dc3912'],
                legend: { position: 'bottom' },
                fontSize: 12,
                pieSliceText: 'value',
                pieSliceTextStyle: { color: 'black', fontSize: '120px', margin: '20px' },
            };

            var chart = new google.visualization.PieChart(document.getElementById('donutchart2'));
            chart.draw(data, options);
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}

function drawChart3() {
    google.charts.load("current", { packages: ["corechart"] });
    var idUH = document.getElementById('idUH').value;
    var idAr = document.getElementById('idAr').value;
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/SelecionarCheckManutencao.json.php',
        data: {
            acao: 'Trimestral',
            uh: idUH,
            idAr: idAr,
        },
        success: function (data) {
            var quantTotal = data.split(';')[0];
            $('#tituloTrimestral').empty();
            $('#tituloTrimestral').append('<h5>Total de itens: ' + quantTotal + '</h5>');
            var quantFinalizados = data.split(';')[1];
            var quantNaoFinalizados = data.split(';')[2];
            if (quantFinalizados == 0 && quantNaoFinalizados == 0) {
                quantNaoFinalizados = quantTotal;
            }
            var dataCheck = data.split(';')[3];
            $('#dataTrimestral').empty();
            $('#dataTrimestral').append(dataCheck);
            var status = data.split(';')[4];
            $('#statusTrimestral').empty();
            $('#statusTrimestral').append(status);
            var data = google.visualization.arrayToDataTable([
                ['Titulo', 'Quantidade'],
                ['Finalizados', parseInt(quantFinalizados)],
                ['Restante', parseInt(quantNaoFinalizados)],
            ]);

            var options = {
                pieHole: 0.3,
                tooltip: { text: 'value' },
                backgroundColor: '#f3f6fb',
                chartArea: { left: '10%', bottom: '15%', width: '80%', height: '80%' },
                colors: ['#69bd63', '#dc3912'],
                legend: { position: 'bottom' },
                fontSize: 12,
                pieSliceText: 'value',
                pieSliceTextStyle: { color: 'black', fontSize: '120px', margin: '20px' },
            };

            var chart = new google.visualization.PieChart(document.getElementById('donutchart3'));
            chart.draw(data, options);
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}

function drawChart4() {
    google.charts.load("current", { packages: ["corechart"] });
    var idUH = document.getElementById('idUH').value;
    var idAr = document.getElementById('idAr').value;
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/SelecionarCheckManutencao.json.php',
        data: {
            acao: 'Anual',
            uh: idUH,
            idAr: idAr,
        },
        success: function (data) {
            var quantTotal = data.split(';')[0];
            $('#tituloAnual').empty();
            $('#tituloAnual').append('<h5>Total de itens: ' + quantTotal + '</h5>');
            var quantFinalizados = data.split(';')[1];
            var quantNaoFinalizados = data.split(';')[2];
            if (quantFinalizados == 0 && quantNaoFinalizados == 0) {
                quantNaoFinalizados = quantTotal;
            }
            var dataCheck = data.split(';')[3];
            $('#dataAnual').empty();
            $('#dataAnual').append(dataCheck);
            var status = data.split(';')[4];
            $('#statusAnual').empty();
            $('#statusAnual').append(status);
            var data = google.visualization.arrayToDataTable([
                ['Titulo', 'Quantidade'],
                ['Finalizados', parseInt(quantFinalizados)],
                ['Restante', parseInt(quantNaoFinalizados)],
            ]);

            var options = {
                pieHole: 0.3,
                tooltip: { text: 'value' },
                backgroundColor: '#f3f6fb',
                chartArea: { left: '10%', bottom: '15%', width: '80%', height: '80%' },
                colors: ['#69bd63', '#dc3912'],
                legend: { position: 'bottom' },
                fontSize: 12,
                pieSliceText: 'value',
                pieSliceTextStyle: { color: 'black', fontSize: '120px', margin: '20px' },
            };

            var chart = new google.visualization.PieChart(document.getElementById('donutchart4'));
            chart.draw(data, options);
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}