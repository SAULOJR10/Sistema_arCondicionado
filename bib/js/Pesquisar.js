$(document).ready(function () {
    Funcionalidades();
});

function Funcionalidades() {
    var tipo_usu = document.getElementById('tipo_usuario').value;
    if (tipo_usu == 'manutencionista') {
        $('#cadastropredial').removeAttr('onclick');
        $('#cadastropredial').attr('data-toggle', 'popover');
        $('#cadastropredial').attr('data-trigger', 'hover');
        $('#cadastropredial').attr('data-placement', 'bottom');
        $('#cadastropredial').attr('title', 'Você não tem acesso a essa funcionalidade !!!');
        $('#administracao').removeAttr('onclick');
        $('#administracao').attr('data-toggle', 'popover');
        $('#administracao').attr('data-trigger', 'hover');
        $('#administracao').attr('data-placement', 'bottom');
        $('#administracao').attr('title', 'Você não tem acesso a essa funcionalidade !!!');
        $('#relatoriomenu').removeAttr('onclick');
        $('#relatoriomenu').attr('data-toggle', 'popover');
        $('#relatoriomenu').attr('data-trigger', 'hover');
        $('#relatoriomenu').attr('data-placement', 'bottom');
        $('#relatoriomenu').attr('title', 'Você não tem acesso a essa funcionalidade !!!');
        $('usuariosmenu').removeAttr('onclick');
        $('usuariosmenu').attr('data-toggle', 'popover');
        $('usuariosmenu').attr('data-trigger', 'hover');
        $('usuariosmenu').attr('data-placement', 'bottom');
        $('usuariosmenu').attr('title', 'Você não tem acesso a essa funcionalidade !!!');
    }
    if (tipo_usu == 'eng') {
        $('#cadastropredial').removeAttr('onclick');
        $('#cadastropredial').attr('data-toggle', 'popover');
        $('#cadastropredial').attr('data-trigger', 'hover');
        $('#cadastropredial').attr('data-placement', 'bottom');
        $('#cadastropredial').attr('title', 'Você não tem acesso a essa funcionalidade !!!');
        $('#administracao').removeAttr('onclick');
        $('#administracao').attr('data-toggle', 'popover');
        $('#administracao').attr('data-trigger', 'hover');
        $('#administracao').attr('data-placement', 'bottom');
        $('#administracao').attr('title', 'Você não tem acesso a essa funcionalidade !!!');
        $('.checklist').removeAttr('onclick');
        $('.checklist').attr('data-toggle', 'popover');
        $('.checklist').attr('data-trigger', 'hover');
        $('.checklist').attr('data-placement', 'bottom');
        $('.checklist').attr('title', 'Você não tem acesso a essa funcionalidade !!!');
        $('usuariosmenu').removeAttr('onclick');
        $('usuariosmenu').attr('data-toggle', 'popover');
        $('usuariosmenu').attr('data-trigger', 'hover');
        $('usuariosmenu').attr('data-placement', 'bottom');
        $('usuariosmenu').attr('title', 'Você não tem acesso a essa funcionalidade !!!');
    }
}
$(function () {
    $('[data-toggle="popover"]').popover()
})

$('.popover-dismiss').popover({
    trigger: 'focus'
})

function SoUm(id) {
    switch (id) {
        case 'ch_Arcond':
            if ($('#ch_ArCond').is(':checked') && document.getElementById('idEnt') != undefined) {
                $('#ch_Prop').prop('checked', false);
                $('#ch_UH').prop('checked', false);
                $('.opaco').removeAttr('style');
                $('.opaco').attr('style', 'margin-top:15px;');
                $('#ch_Marca').removeAttr('disabled');
                $('#ch_Modelo').removeAttr('disabled');
                $('#ch_Potencia').removeAttr('disabled');
                $('#ch_Localizacao').removeAttr('disabled');
                $('#UH').attr('disabled', true);
                $('#pesquisarUH').removeAttr('onclick');
                $('#Prop').attr('disabled', true);
                document.getElementById('Prop').value = '';
                $('#pesquisarProp').removeAttr('onclick');
            } else {
                $('#graficosmarca').empty();
                $('#graficosmodelo').empty();
                $('#graficospotencia').empty();
                $('#graficoslocalizacao').empty();
                $('#titulo').attr('style', 'visibility: hidden');
                $('#titulomarca').attr('style', 'visibility: hidden');
                $('#titulomodelo').attr('style', 'visibility: hidden');
                $('#titulopotencia').attr('style', 'visibility: hidden');
                $('#titulolocalizacao').attr('style', 'visibility: hidden');
                $('.opaco').attr('style', 'margin-top:15px; opacity:0.5');
                $('#ch_ArCond').prop('checked', false);
                $('#ch_Marca').attr('disabled', true);
                $('#ch_Modelo').attr('disabled', true);
                $('#ch_Potencia').attr('disabled', true);
                $('#ch_Localizacao').attr('disabled', true);
                $('#ch_Marca').prop('checked', false);
                $('#ch_Modelo').prop('checked', false);
                $('#ch_Potencia').prop('checked', false);
                $('#ch_Localizacao').prop('checked', false);
            }
            break;
        case 'ch_Prop':
            if ($('#ch_Prop').is(':checked') && document.getElementById('idEnt') != undefined) {
                $('#ch_ArCond').prop('checked', false);
                $('#ch_UH').prop('checked', false);
                SoUm('ch_Arcond');
                $('#Prop').removeAttr('disabled');
                $('#pesquisarProp').attr('onclick', 'Pesquisar(\'Prop\')');
                $('#UH').attr('disabled', true);
                $('#pesquisarUH').removeAttr('onclick');
                $('#Bloco').attr('disabled', 'true');
                $('#UHGer').attr('disabled', 'true');
                document.getElementById('Bloco').value = '';
                document.getElementById('UHGer').value = '';
            } else {
                $('#ch_Prop').prop('checked', false);
                $('#Prop').attr('disabled', true);
                document.getElementById('Prop').value = '';
                $('#pesquisarProp').removeAttr('onclick');
            }
            break;
        case 'ch_UH':
            if ($('#ch_UH').is(':checked') && document.getElementById('idEnt') != undefined) {
                $('#ch_Prop').prop('checked', false);
                $('#Prop').attr('disabled', true);
                document.getElementById('Prop').value = '';
                $('#pesquisarProp').removeAttr('onclick');
                $('#ch_Arcond').prop('checked', false);
                SoUm('ch_Arcond');
                SelectBloco();
                $('#UH').removeAttr('disabled');
                $('#pesquisarUH').attr('onclick', 'Pesquisar(\'UH\')');
                $('#Bloco').attr('disabled', 'true');
                $('#UHGer').attr('disabled', 'true');
                document.getElementById('Bloco').value = '';
                document.getElementById('UHGer').value = '';
            } else {
                $('#ch_UH').prop('checked', false);
                $('#UH').attr('disabled', true);
                $('#pesquisarUH').removeAttr('onclick');
            }
            break;
    }

}

function PesquisarAr() {
    if ($('#ch_Localizacao').is(':checked')) {
        MontarGrafico('localizacao');
    }
    if ($('#ch_Marca').is(':checked')) {
        MontarGrafico('marca');
    }
    if ($('#ch_Modelo').is(':checked')) {
        MontarGrafico('modelo');
    }
    if ($('#ch_Potencia').is(':checked')) {
        MontarGrafico('potencia');
    }
    window.scroll(0, 100000);
}

function SelectEnt(acao) {
    $('#nome_cliente').empty();
    var idUsuario = document.getElementById('idLogin').value;
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/SelecionarPesquisar.json.php',
        data: {
            acao: acao,
            idUsuario: idUsuario,
            processoData: false,
            contentype: false,
        },
        success: function (data) {
            $('#nome_cliente').append(data);
            $('#onclick').removeAttr('onclick');
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}
function EntSelected() {
    var idEnt = document.getElementById('EntidadeGer').value;
    var nomeEnt = document.getElementById('optionEnt' + idEnt).textContent;
    $('#nome_cliente').empty();
    $('#nome_cliente').append("<input type='hidden' id='idEnt' value='" + idEnt + "'>" + nomeEnt);
}

function SelectBloco() {
    var idEnt = document.getElementById('idEnt').value;
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/SelecionarPesquisar.json.php',
        data: {
            acao: 'Bloco',
            idEnt: idEnt,
        },
        success: function (data) {
            $('#SelectBloco').empty();
            $('#SelectBloco').append(data);
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}

function SelectUH() {
    var idEnt = document.getElementById('idEnt').value;
    var idBloco = document.getElementById('Bloco').value;
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/SelecionarPesquisar.json.php',
        data: {
            acao: 'SelectUH',
            idEnt: idEnt,
            idBloco: idBloco,
        },
        success: function (data) {
            $('#SelectUH').empty();
            $('#SelectUH').append(data);
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}

function ImprimirResult() {
    $('#imprimir').append('style', 'visibility: hidden;');
    window.print();
    $('.modal-body').empty();
    $('.modal-body').append('<span id="resultPesq"></span>');
    $('#resultadosModal').modal('hide');
}

function limparModal() {
    $('.modal-body').empty();
    $('.modal-body').append('<span id="resultPesq"></span>');
}

function Pesquisar(acao) {
    if (acao == 'UH') {
        var pesquisa = document.getElementById('UHGer').value;
    }
    if (acao == 'Prop') {
        var pesquisa = document.getElementById('Prop').value;
    }
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/SelecionarPesquisar.json.php',
        data: {
            acao: acao,
            pesquisa: pesquisa,
        },
        success: function (data) {
            $('#resultPesq').append(data);
            $('#resultPesq').after("<div class='footer'><div id='dv_relat'><input readonly='readonly' onclick='ImprimirResult()' id='imprimir' value='Imprimir Resultado' class='fourth ' style='width: 40%; float:right;'></div></div>")
            $('#resultadosModal').modal('show');
        },
        error: function (msg) {
            alert('ERRO' + msg.responseText);
        }
    });
}

function MontarGrafico(id) {
    idEnt = document.getElementById('idEnt').value;
    google.charts.load("current", { packages: ["corechart"] });
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/SelecionarPesquisar.json.php',
        data: {
            acao: 'Ar',
            id: id,
            idEnt: idEnt,
        },
        success: function (data) {
            $('#titulo').removeAttr('style');
            $('#titulo').attr('style', 'margin: 30px;');

            var data = google.visualization.arrayToDataTable(data['dado']);

            title = id.toUpperCase();
            var options = {
                'title': '' + title + ':',
                titleTextStyle:{bold: false},
                pieHole: 0.3,
                tooltip: { text: 'value' },
                chartArea: { width: '100%', height: '60%' },
                legend: { position: 'bottom', textStyle: { fontSize: 10 } },
                fontSize: 15,
                pieSliceText: 'value',
                pieSliceTextStyle: { color: 'black' },
            };

            var chart = new google.visualization.PieChart(document.getElementById('graficos' + id));

            $('#titulo' + id).removeAttr('style');
            chart.draw(data, options);
        },
        error: function (msg) {
            alert('ERRO' + msg.responseText);
            $('#graficoslocalizacao').after(msg.responseText);
        }
    });
}

function AutoComplete() {
    var auto = document.getElementById('Prop').value;
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/SelecionarPesquisar.json.php',
        data: {
            acao: 'AutoCompleta',
            auto: auto,
        },
        success: function (data) {
            $("#Prop").autocomplete({
                source: data
            });
        },
        error: function (msg) {
            alert('ERRO' + msg.responseText);
        }
    });
}