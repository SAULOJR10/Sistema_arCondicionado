$(document).ready(function () {
    Entidades();
    Funcionalidades();
});

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

function tipoEng() {
    var tipo_usu = document.getElementById('tipo_usuario').value;
    if (tipo_usu == 'eng') {
        $('#nomeUsu').attr('onkeyup', 'AutoComplete()');
    } else {
        $('#nomeUsu').removeAttr('onkeyup');
        jQuery('#nomeUsu').autocomplete('destroy');
    }
}

function AutoComplete() {
    var auto = document.getElementById('nomeUsu').value;
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/SelecionarPesquisar.json.php',
        data: {
            acao: 'AutoCompleta',
            auto: auto,
        },
        success: function (data) {
            $("#nomeUsu").autocomplete({
                source: data
            });
        },
        error: function (msg) {
            alert('ERRO' + msg.responseText);
        }
    });
}

function confirmeSenha() {
    var senha = document.getElementById('senha').value;
    var confirmSenha = document.getElementById('confirmSenha').value;
    if (senha != confirmSenha) {
        $('#confirmSenha').attr('style', 'border-color: red;');
        $('#senhaIncorreta').empty();
        $('#senhaIncorreta').attr('style', 'color: red; margin: 0%;');
        $('#senhaIncorreta').append('Senhas não conhecidem !!!');
    } else {
        $('#senha').attr('style', 'border-color: green;');
        $('#confirmSenha').attr('style', 'border-color: green;');
        $('#senhaIncorreta').empty();
        $('#senhaIncorreta').attr('style', 'color: green; margin: 0%;');
        $('#senhaIncorreta').append('Senhas corretas !!!');
    }
}

function Entidades() {
    idUsuario = document.getElementById('idLogin').value;
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/Cadastros.json.php',
        data: {
            acao: 'Entidades',
            idUsuario: idUsuario,
            processoData: false,
            contentype: false,
        },
        success: function (data) {
            $('#Entidades').append(data);
        },
        error: function (msg) {
            $('#Entidades').append(msg.responseText);
            alert(msg.responseText);
        }
    });
}

function SalvarUsuario() {
    var tipo_usu = document.getElementById('tipo_usuario').value;
    if (tipo_usu == 'nd') {
        $('#erro').append('Selecione o tipo de usuario');
        return;
    }
    var nomeUsu = document.getElementById('nomeUsu').value;
    if (nomeUsu == '') {
        $('#erro').append('Insira um nome ao usuario');
        return;
    }
    var teste = document.getElementById('senha').value;
    var confirmSenha = document.getElementById('confirmSenha').value;
    if (teste == confirmSenha) {
        var senha = teste
    } else {
        $('#erro').append('Senhas não Conhecidem !!!');
        return;
    }
    var quantEnt = document.getElementsByName('allEntidades').length;
    var entidades = '';
    for (i = 0; i <= quantEnt; i++) {
        if ($('#ch_entidade' + i).is(':checked')) {
            var entidades = entidades + document.getElementById('ch_entidade' + i).value + ',';
        }
    }
    alert(entidades);
    if (entidades == '') {
        $('#erro').append('Selecione quais entidade esse usuario participa');
        return;
    }
    var arquivo = document.getElementById('ftusu').files[0];
    var fd = new FormData();
    fd.append('acao', 'salvarUsuario');
    fd.append('arquivo', arquivo);
    fd.append('tipo_usu', tipo_usu);
    fd.append('nomeUsu', nomeUsu);
    fd.append('senha', senha);
    fd.append('entidades', entidades);
    $.ajax({
        url: 'bib/ajax/Cadastros.json.php',
        type: 'post',
            dataType: "json",
            data: fd,
            contentType: false,
            processData: false,
        success: function (data) {
            $('#Entidades').append(data);
        },
        error: function (msg) {
            alert(msg.responseText);
            $('#Entidades').append('ERRO' + msg.responseText);
        }
    });
}

function mostrarImg() {
    $('#ftusu').change(function () {
        const file = $(this)[0].files[0]

        if (file.size < (1024 * 2025)) {
            var reader = new FileReader();
            reader.readAsDataURL(file);

            reader.onload = function () {
                $('#imagemPre').attr('src', this.result);
            }
        } else {
            $('#imagemPre').attr('src', 'bib/img/i.png');
            document.getElementById("file").value = '';
        }


    })
}