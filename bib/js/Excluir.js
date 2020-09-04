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
            alert(data);
            location.reload();
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}

function Funcionalidades(){
    var tipo_usu = document.getElementById('tipo_usuario').value;
    if(tipo_usu == 'manutencionista'){
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
        $('#relatorio').removeAttr('onclick');
        $('#relatorio').attr('data-toggle', 'popover');
        $('#relatorio').attr('data-trigger', 'hover');
        $('#relatorio').attr('data-placement', 'bottom');
        $('#relatorio').attr('title', 'Você não tem acesso a essa funcionalidade !!!');
        $('#cadastrousuario').removeAttr('onclick');
        $('#cadastrousuario').attr('data-toggle', 'popover');
        $('#cadastrousuario').attr('data-trigger', 'hover');
        $('#cadastrousuario').attr('data-placement', 'bottom');
        $('#cadastrousuario').attr('title', 'Você não tem acesso a essa funcionalidade !!!');
        $('#excluirusuario').removeAttr('onclick');
        $('#excluirusuario').attr('data-toggle', 'popover');
        $('#excluirusuario').attr('data-trigger', 'hover');
        $('#excluirusuario').attr('data-placement', 'bottom');
        $('#excluirusuario').attr('title', 'Você não tem acesso a essa funcionalidade !!!');
    }
}

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