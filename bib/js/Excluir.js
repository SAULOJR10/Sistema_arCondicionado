$(document).ready(function () {
    MontarExcluir();
    Funcionalidades();
});

function MontarExcluir(){
    var idLogin = document.getElementById('idLogin').value;
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/Excluir.json.php',
        data: {
            acao: 'MontarExcluir',
            idLogin: idLogin,
            processoData: false,
            contentype: false,
        },
        success: function (data) {
            $('#demo-table').append(data);
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}

function RemoverUsu(idLogin){
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/Excluir.json.php',
        data: {
            acao: 'Excluir',
            idLogin: idLogin,
            processoData: false,
            contentype: false,
        },
        success: function (data) {
            $('#MSG').empty();
            $('#MSG').append(data);
            $('#Avisos').modal('show');
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}

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

function EntSelected(teste) {
    var idEnt = document.getElementById('EntidadeGer').value;
    var nomeEnt = document.getElementById('optionEnt' + idEnt).textContent;
    $('#nome_cliente').empty();
    $('#nome_cliente').append("<input type='hidden' id='idEnt' value='" + idEnt + "'>" + nomeEnt);
    $('#onclick').attr('onclick', 'SelectEnt(\'selectEnt\')');
    $('#BotaoCadEnt').attr('onclick', 'AbrirModal(\'CadEng\')');
    $('#BotaoCadBlocos').attr('onclick', 'aparecer(\'cad\')');
    $('#BotaoCadSalas').attr('onclick', 'aparecer(\'cadSala\')');
    Title();
    if (teste != 'normal') {
        Tutorial('Parte2');
    }
    Tabela();
}

function SelectEnt(acao) {
    $('#nome_cliente').empty();
    var idUsuario = document.getElementById('idLogin').value;
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/Selecionar.json.php',
        data: {
            acao: acao,
            idUsuario: idUsuario,
            processoData: false,
            contentype: false,
        },
        success: function (data) {
            $('#nome_cliente').append(data);
            $('#onclick').removeAttr('onclick');
            if (acao == 'SoUma3') {
                $('#nome_cliente').empty();
                $('#nome_cliente').append(data);
                Tutorial('Parte3');
            }
            if (acao == 'ultimaEnt') {
                Tutorial('Parte2');
                $('#onclick').attr('onclick', 'SelectEnt(\'selectEnt\')');
            }
            if (acao == 'SoUma' || acao == 'primeira') {
                $('#onclick').attr('onclick', 'SelectEnt(\'selectEnt\')');
            }
            if (acao == 'selecttabela') {
                $('#onclick').attr('onclick', 'SelectEnt(\'selectEnt\')');
                Tabela();
            }
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}