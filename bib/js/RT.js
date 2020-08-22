$(document).ready(function () {
    if (document.getElementById('idUH') != undefined) {
        Relatorio();
    }else{
        SelectEnt('QualEnt');
    }
});

function Relatorio(){
    var idUH = document.getElementById('idUH').value;
    var idLogin = document.getElementById('idLogin').value;
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/SelecionarRT.json.php',
        data: {
            acao: 'Relatorio',
            idUH: idUH,
            idLogin: idLogin,
        },
        success: function (data) {
            $('#colocarRT').empty();
            $('#colocarRT').append(data);
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}

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
                var select = data.split('<select')[1]
                $('#SelectEnt').append('<select style="width: 100%; border-radius: 5px;"' + select);
                $('#TitleSelectEnt').empty();
                $('#TitleSelectEnt').append('Selecione um entidade:');
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

function Pesquisar(){
    var idUH = document.getElementById('idUH').value;
    var idEnt = document.getElementById('idEnt').value;
    var num = document.getElementById('num').value;
    window.open("RT.php?num1="+num+"&Ent="+idEnt+"&idUH="+idUH+"");
}

function EntSelected(acao) {
    var idEnt = document.getElementById('EntidadeGer').value;
    $('#nome_cliente').empty();
    $('#nome_cliente').append("<input type='hidden' id='idEnt' value='" + idEnt + "'>");
    MontarQualUH('selectBloco');
    var Ent = document.getElementById('nome_cliente').innerHTML;
}

function MontarQualUH(acao) {
    $('#Selecao').modal('show');
    if (acao == 'colocarButton') {
        idUH = document.getElementById('UHGer').value;
        $('#IDUH').empty();
        $('#IDUH').append('<input type="hidden" value="'+idUH+'" id="idUH">');
        $('#btao_relat').attr('onclick', 'Pesquisar()');
        return;
    }
    if (document.getElementById('idEnt') != undefined) {
        var idEnt = document.getElementById('idEnt').value;
        if (document.getElementById('Bloco') != undefined) {
            var idBloco = document.getElementById('Bloco').value;
        } else {
            var idBloco = '';
        }
        if (document.getElementById('UHGer') != undefined) {
            var idUH = document.getElementById('UHGer').value;
            $('#IDUH').empty();
            $('#IDUH').append('<input type="hidden" value="' + idUH + '" id="idUH">');
        } else {
            var idUH = '';
        }
        if (acao == 'primeiro') {
            acao = 'selectBloco';
        }
    } else {
        SelectEnt('QualEnt');
        $('#SelectBloco').empty();
        $('#btao_relat').removeAttr('onclick');
        return;
    }
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/SelecionarRT.json.php',
        data: {
            acao: acao,
            idEnt: idEnt,
            idBloco: idBloco,
            idUH: idUH,
        },
        success: function (data) {
            if (acao == 'selectBloco') {
                $('#SelectBloco').empty();
                $('#SelectBloco').append(data);
                $('#SelectUH').empty();
                $('#TitleSelectBloco').append('Selecione o Bloco:');
                $('#btao_relat').removeAttr('onclick');
                $('#IDUH').empty();
            }
            if (acao == 'UH') {
                $('#SelectUH').empty();
                $('#SelectUH').append(data);
                $('#TitleSelectUH').append('Selecione o Local:');
                $('#IDUH').empty();
            }
            $('#Selecao').modal('show');
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}