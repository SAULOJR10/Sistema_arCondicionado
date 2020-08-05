$(document).ready(function () {
    MontarQualUH('primeiro');
    $('#onclick').removeAttr('onclick');
    var url = window.location.href;
    var url = url.split('&')[0];
    $('#onclick').attr('href', url);
});

function SelectEnt(acao) {
    $('#nome_cliente').empty();
    var idUsuario = document.getElementById('idLogin').value;
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/SelecionarCheck.json.php',
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
}

function OutroAr(){
    var idEnt = document.getElementById('EntidadeGer').value;
    var idUH = document.getElementById('UHGer').value;
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/SelecionarCheck.json.php',
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

function SalvaCheckList(){
    var funcionario = document.getElementById('idLogin').value;
    var idUH = document.getElementById('idUH').value;
    var idAr = document.getElementById('idAr').value;
    var periodo = document.getElementById('periodo').value;
    var quanItem = document.getElementsByName('allitem').length;
    var statusCheck = true;
    var finalizados = ';';
    var naoFinalizados = ';';
    var statusItem = ';';
    for(i=1; i <= quanItem; i++){
        if($('#ch_item'+i).is(':checked')){
            var finalizados = finalizados + document.getElementById('ch_item'+i).value + ';';
            var statusItem = statusItem + true + ';';
        }else{
            var statusCheck = false;
            var naoFinalizados = naoFinalizados + document.getElementById('ch_item'+i).value + ';';
            var statusItem = statusItem + false + ';';
        }
    }
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/CadastrarCheck.json.php',
        data: {
            acao: 'CheckList',
            funcionario:funcionario,
            idUH:idUH,
            idAr:idAr,
            statusCheck:statusCheck,
            finalizados:finalizados,
            naoFinalizados:naoFinalizados,
            statusItem:statusItem,
            periodo: periodo,
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

function MontarQualUH(acao) {
    $('#CheckList').modal('show');
    if (acao == 'colocarButton') {
        var idAr = document.getElementById('Ar').value;
        $('#ColocarAr').empty();
        $('#ColocarAr').append('<input type="hidden" id="idAr" value="'+idAr+'">');
        $('#btao_relat').attr('onclick', 'QualUH()');
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
        } else {
            var idUH = '';
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
        url: 'bib/ajax/SelecionarCheck.json.php',
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
            }
            if (acao == 'Andar') {
                $('#SelectAndar').empty();
                $('#SelectAndar').append(data);
                $('#SelectUH').empty();
                $('#SelectAr').empty();
                $('#btao_relat').removeAttr('onclick');
            }
            if (acao == 'UH') {
                $('#SelectUH').empty();
                $('#SelectUH').append(data);
                $('#SelectAr').empty();
                $('#btao_relat').removeAttr('onclick');
            }
            if (acao == 'Ar') {
                $('#SelectAr').empty();
                $('#SelectAr').append(data);
            }
            $('#CheckList').modal('show');
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
}

function CheckList(id) {
    var uh = document.getElementById('idUH').value;
    var idLogin = document.getElementById('idLogin').value;
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/SelecionarCheck.json.php',
        data: {
            acao: 'MontarCheckList',
            uh: uh,
            idLogin: idLogin,
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
        url: 'bib/ajax/SelecionarCheck.json.php',
        data: {
            acao: 'MontarTela',
            uh: idUH,
        },
        success: function (data) {
            $('.UHs').empty();
            $('.UHs').append(data.split(';')[1]);
            $('.Blocos').empty();
            $('.Blocos').append(data.split(';')[2]);
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}

// function MontarGraficos() {
    google.charts.load("current", { packages: ["corechart"] });
    google.charts.setOnLoadCallback(drawChart1);
    google.charts.setOnLoadCallback(drawChart2);
    google.charts.setOnLoadCallback(drawChart3);
    google.charts.setOnLoadCallback(drawChart4);
    function drawChart1() {
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Total', 3],
            ['Finalizados', 5],
            ['Restante', 2],
        ]);

        var options = {
            pieHole: 0.3,
            backgroundColor: '#f3f6fb',
            chartArea: { left: '10%', bottom: '15%', width: '80%', height: '80%' },
            colors: ['#3366cc', '#69bd63', '#dc3912'],
            legend: { position: 'bottom' },
            fontSize: 9,
            slices: {
                2: { offset: 0.08 }
            }
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart1'));
        chart.draw(data, options);
    }

    function drawChart2() {
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Total', 2],
            ['Finalizados', 3],
            ['Restante', 5],
        ]);

        var options = {
            pieHole: 0.3,
            backgroundColor: '#f3f6fb',
            chartArea: { left: '10%', bottom: '15%', width: '80%', height: '80%' },
            colors: ['#3366cc', '#69bd63', '#dc3912'],
            legend: { position: 'bottom' },
            fontSize: 9,
            slices: {
                2: { offset: 0.08 },
            }
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart2'));
        chart.draw(data, options);
    }

    function drawChart3() {
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Total', 7],
            ['Finalizados', 1],
            ['Restante', 2],
        ]);

        var options = {
            pieHole: 0.3,
            backgroundColor: '#f3f6fb',
            chartArea: { left: '10%', bottom: '15%', width: '80%', height: '80%' },
            colors: ['#3366cc', '#69bd63', '#dc3912'],
            legend: { position: 'bottom' },
            fontSize: 9,
            slices: {
                2: { offset: 0.08 },
            }
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart3'));
        chart.draw(data, options);
    }

    function drawChart4() {
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Total', 4],
            ['Finalizados', 3],
            ['Restante', 3],
        ]);

        var options = {
            pieHole: 0.3,
            backgroundColor: '#f3f6fb',
            chartArea: { left: '10%', bottom: '15%', width: '80%', height: '80%' },
            colors: ['#3366cc', '#69bd63', '#dc3912'],
            legend: { position: 'bottom' },
            fontSize: 9,
            slices: {
                2: { offset: 0.08 },
            }
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart4'));
        chart.draw(data, options);
    }
// }