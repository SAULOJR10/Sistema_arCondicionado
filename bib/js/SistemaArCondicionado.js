$(document).ready(function () {
    $(".cnpj").mask("99.999.999/9999-99");
    $(".telefone").mask("(99) 99999-9999");
    $(".cep").mask("99999-999");
    $(".cpf").mask("999.999.999-99");
    if (document.getElementById('idEnt') != undefined) {
        $('#BotaoCadBlocos').attr('onclick', 'aparecer(\'cad\')');
        $('#BotaoCadSalas').attr('onclick', 'aparecer(\'cadSala\')');
        Tabela();
    }
    var idLogin = document.getElementById('idLogin').value;
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/Selecionar.json.php',
        data: {
            acao: 'tutorialParte1',
            idLogin: idLogin,
            processoData: false,
            contentype: false
        },
        success: function (data) {
            if (data != '0') {
                $('#tutorial').append(data);
                $('#Entidade').removeAttr('onclick');
                $('#Entidade').attr('onclick', 'CadastrarEntidade(\'primeiro\')');
            } else {
                $('#onclick').attr('onclick', 'SelectEnt(\'selectEnt\')');
                Tutorial('Parte2');
            }
        },
        error: function (msg) {

        }
    });
});

function Tutorial(id) {
    var idLogin = document.getElementById('idLogin').value;
    if (document.getElementById('idEnt') != undefined) {
        var idEnt = document.getElementById('idEnt').value;
    }
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/Selecionar.json.php',
        data: {
            acao: 'tutorial' + id,
            idLogin: idLogin,
            idEnt: idEnt,
            processoData: false,
            contentype: false
        },
        success: function (data) {
            if (id == 'Parte2') {
                if (data != 0) {
                    SelectEnt('SoUma');
                    $('#tutorial').empty();
                    $('#tutorial').append(data);
                    $('#onclick').attr('onclick', 'SelectEnt(\'selectEnt\')');
                    $('#BotaoCadEnt').attr('onclick', 'AbrirModal("CadEng")');
                } else {
                    $('#onclick').attr('onclick', 'SelectEnt(\'selectEnt\')');
                }
            }
            if (id == 'Parte3') {
                if (data != 0) {
                    SelectEnt('SoUma');
                    $('#onclick').attr('onclick', 'SelectEnt(\'selectEnt\')');
                    $('#tutorial').empty();
                    $('#tutorial').append(data);
                    $('#BotaoCadSalas').attr('onclick', 'aparecer("cadSala")');
                    $('#BotaoCadBlocos').attr('onclick', 'aparecer("cad")');
                } else {
                    $('#onclick').attr('onclick', 'SelectEnt(\'selectEnt\')');
                }
            }
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}

function Title() {
    var idEnt = document.getElementById('idEnt').value;
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/Selecionar.json.php',
        data: {
            acao: 'infoTela',
            idEnt: idEnt,
            processoData: false,
            contentype: false
        },
        success: function (data) {
            var quant = data.split(";");
            $('#quantBloco').empty();
            $('#quantBloco').append(quant[0]);
            $('#quantAndar').empty();
            $('#quantAndar').append(quant[1]);
            $('#quantUH').empty();
            $('#quantUH').append(quant[2]);
            $('#quantSala').empty();
            $('#quantSala').append(quant[3]);
            $('#quantEng').empty();
            $('#quantEng').append(quant[4]);
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}

function Tabela() {
    var idEnt = document.getElementById('idEnt').value;
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/Selecionar.json.php',
        data: {
            acao: 'tabela',
            idEnt: idEnt,
            processoData: false,
            contentype: false
        },
        success: function (data) {
            $("#Corpo").empty();
            $("#tutorial").empty();
            $('.cad').attr('style', 'display: none; background-color: white; width:100%;');
            $('.cadSala').attr('style', 'display: none; background-color: white; width:100%;');
            $('.Edit').attr('style', 'display: none; background-color: white; width:100%;');
            $('.EditSala').attr('style', 'display: none; background-color: white; width:100%;');
            $("#Corpo").append(data);
            Title();
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
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

function CadastrarBloco(acao) {
    var idEnt = document.getElementById('idEnt').value;
    var idApart = document.getElementById('prefixoUH').value;
    var nomeBloco = document.getElementById('nomeBloco').value;
    var testeSubSolo = document.getElementsByName('SubSolo');
    var quantSubSolo = 0;
    var quantAndar = document.getElementById('quantAndarCad').value;
    if (quantAndar == '') {
        $('#quantAndarCad').attr('style', 'margin-top: 2px; border:solid red 1px; width:74%;');
        mostrarErros('Campo quantidade de andar deve ser preenchido, mesmo que com zero (0)');
        return false;
    } else {
        $('#quantAndarCad').attr('style', 'margin-top: 2px; border:solid green 1px; width:74%;');
    }
    if (nomeBloco == '') {
        var nomeBloco = document.getElementById('nomePadrao').value;
    }
    var quantApart = '';
    for (i = 0; i <= quantAndar; i++) {
        var add = document.getElementById('quantApartCad' + i).value;
        if (add != '') {
            quantApart = quantApart + ',' + add;
            $('#quantApartCad' + i).attr('style', 'border:solid green 1px; width:100%');
        } else {
            $('#quantApartCad' + i).attr('style', 'border:solid red 1px; width:100%');
            mostrarErros('Todos os campos de apartamento deve ser preenchidos, mesmo que com zero (0)');
            return false;
        }
    }
    for (i = 0; i < testeSubSolo.length; i++) {
        if (testeSubSolo[i].checked) {
            quantSubSolo += 1;
        }
    }
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/Cadastrar.json.php',
        data: {
            acao: acao,
            idEnt: idEnt,
            nomeBloco: nomeBloco,
            quantAndar: quantAndar,
            quantSubSolo: quantSubSolo,
            idApart: idApart,
            quantApart: quantApart,
            processoData: false,
            contentype: false
        },
        success: function (data) {
            MostrarSucesso(data);
            Tabela();
            $('.cad').attr('style', 'display:none');
            $('#AndarCad').empty();
            document.getElementById('nomeBloco').value = '';
            document.getElementById('quantAndarCad').value = '';
            $('#ch_Sub01').prop('checked', false);
            $('#ch_Sub02').prop('checked', false);
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}

function LimparCadEnt() {
    document.getElementById('razaoSocial').value = '';
    $('#razaoSocial').removeAttr('style');
    document.getElementById('nomeFantasia').value = '';
    $('#nomeFantasia').removeAttr('style');
    document.getElementById('cnpjEnt').value = '';
    $('#cnpjEnt').removeAttr('style');
    document.getElementById('telefoneEnt').value = '';
    $('#telefoneEnt').removeAttr('style');
    document.getElementById('estadoEnt').value = '';
    $('#estadoEnt').removeAttr('style');
    document.getElementById('cidadeEnt').value = '';
    $('#cidadeEnt').removeAttr('style');
    document.getElementById('cepEnt').value = '';
    $('#cepEnt').removeAttr('style');
    document.getElementById('enderecoEnt').value = '';
    $('#enderecoEnt').removeAttr('style');
}

function CadastrarEntidade(id) {
    var idUsuario = document.getElementById('idLogin').value;
    var razaoSocial = document.getElementById('razaoSocial').value;
    var nomeFantasia = document.getElementById('nomeFantasia').value;
    var CNPJEnt = document.getElementById('cnpjEnt').value;
    var telefoneEnt = document.getElementById('telefoneEnt').value;
    var EstadoEnt = document.getElementById('estadoEnt').value;
    var cidadeEnt = document.getElementById('cidadeEnt').value;
    var cepEnt = document.getElementById('cepEnt').value;
    var enderecoEnt = document.getElementById('enderecoEnt').value;

    if (razaoSocial == '' || nomeFantasia == '' || CNPJEnt == '' || telefoneEnt == '' || cepEnt == '' || enderecoEnt == '' || EstadoEnt == 'nd' || cidadeEnt == 'nd') {
        mostrarErros('Campo obrigatorio, por  favor preencha');
        if (razaoSocial == '') {
            $('#razaoSocial').attr('style', 'border: solid red 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        } else {
            $('#razaoSocial').attr('style', 'border: solid green 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        }
        if (nomeFantasia == '') {
            $('#nomeFantasia').attr('style', 'border: solid red 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        } else {
            $('#nomeFantasia').attr('style', 'border: solid green 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        }
        if (CNPJEnt == '') {
            $('#cnpjEnt').attr('style', 'border: solid red 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        } else {
            $('#cnpjEnt').attr('style', 'border: solid green 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        }
        if (telefoneEnt == '') {
            $('#telefoneEnt').attr('style', 'border: solid red 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        } else {
            $('#telefoneEnt').attr('style', 'border: solid green 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        }
        if (EstadoEnt == 'nd') {
            $('#estadoEnt').attr('style', 'border: solid red 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        } else {
            $('#estadoEnt').attr('style', 'border: solid green 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        }
        if (cidadeEnt == 'nd') {
            $('#cidadeEnt').attr('style', 'border: solid red 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        } else {
            $('#cidadeEnt').attr('style', 'border: solid green 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        }
        if (cepEnt == '') {
            $('#cepEnt').attr('style', 'border: solid red 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        } else {
            $('#cepEnt').attr('style', 'border: solid green 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        }
        if (enderecoEnt == '') {
            $('#enderecoEnt').attr('style', 'border: solid red 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        } else {
            $('#enderecoEnt').attr('style', 'border: solid green 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        }
        return false;
    }

    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/Cadastrar.json.php',
        data: {
            acao: 'cadEnt',
            idUsuario: idUsuario,
            razaoSocial: razaoSocial,
            nomeFantasia: nomeFantasia,
            CNPJEnt: CNPJEnt,
            telefoneEnt: telefoneEnt,
            EstadoEnt: EstadoEnt,
            cidadeEnt: cidadeEnt,
            cepEnt: cepEnt,
            enderecoEnt: enderecoEnt,
            processoData: false,
            contentype: false
        },
        success: function (data) {
            if (id == 'primeiro') {
                $('#CadEnt').modal('hide');
                $('#BotaoCadEnt').attr('onclick', 'AbrirModal(\'CadEng\')');
                $('#BotaoCadBlocos').attr('onclick', 'aparecer(\'cad\')');
                $('#BotaoCadSalas').attr('onclick', 'aparecer(\'cadSala\')');
                SelectEnt('ultimaEnt');
                LimparCadEnt();
            } else {
                $('#CadEnt').modal('hide');
                $('#BotaoCadEnt').attr('onclick', 'AbrirModal(\'CadEng\')');
                $('#BotaoCadBlocos').attr('onclick', 'aparecer(\'cad\')');
                $('#BotaoCadSalas').attr('onclick', 'aparecer(\'cadSala\')');
                SelectEnt('selecttabela');
                LimparCadEnt();
            }
            MostrarSucesso(data);
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}

function LimparCadEng() {
    document.getElementById('nomeEng').value = '';
    $('#nomeEng').removeAttr('style');
    document.getElementById('CREA').value = '';
    $('#CREA').removeAttr('style');
    document.getElementById('cpfEng').value = '';
    $('#cpfEng').removeAttr('style');
    document.getElementById('cepEng').value = '';
    $('#cepEng').removeAttr('style');
    document.getElementById('telefoneEng').value = '';
    $('#telefoneEng').removeAttr('style');
    document.getElementById('emailEng').value = '';
    $('#emailEng').removeAttr('style');
    document.getElementById('estadoEng').value = '';
    $('#estadoEng').removeAttr('style');
    document.getElementById('cidadeEng').value = '';
    $('#cidadeEng').removeAttr('style');
    document.getElementById('enderecoEng').value = '';
    $('#enderecoEng').removeAttr('style');
    document.getElementById('assinatura').value = '';
    $('#assinatura').removeAttr('style');
    $('#imagemPre01').attr('src', 'bib/img/rubrica.jpg');
}

function CadastrarEngenheiro() {
    var idUsuario = document.getElementById('idLogin').value;
    var idEnt = document.getElementById('idEnt').value;
    var nomeEng = document.getElementById('nomeEng').value;
    var CREA = document.getElementById('CREA').value;
    var CPF = document.getElementById('cpfEng').value;
    var telefoneEng = document.getElementById('telefoneEng').value;
    var emailEng = document.getElementById('emailEng').value;
    var estadoEng = document.getElementById('estadoEng').value;
    var cidadeEng = document.getElementById('cidadeEng').value;
    var cepEng = document.getElementById('cepEng').value;
    var enderecoEng = document.getElementById('enderecoEng').value;
    var assinatura = document.getElementById('assinatura').value;
    if (nomeEng == '' || CREA == '' || CPF == '' || telefoneEng == '' || emailEng == '' || estadoEng == '' || cidadeEng == '' || enderecoEng == '' || assinatura == '') {
        mostrarErros('Campo obrigatorio, por  favor preencha');
        if (nomeEng == '') {
            $('#nomeEng').attr('style', 'border: solid red 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        } else {
            $('#nomeEng').attr('style', 'border: solid green 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        }
        if (CREA == '') {
            $('#CREA').attr('style', 'border: solid red 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        } else {
            $('#CREA').attr('style', 'border: solid green 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        }
        if (CPF == '') {
            $('#cpfEng').attr('style', 'border: solid red 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        } else {
            $('#cpfEng').attr('style', 'border: solid green 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        }
        if (telefoneEng == '') {
            $('#telefoneEng').attr('style', 'border: solid red 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        } else {
            $('#telefoneEng').attr('style', 'border: solid green 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        }
        if (emailEng == '') {
            $('#emailEng').attr('style', 'border: solid red 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        } else {
            $('#emailEng').attr('style', 'border: solid green 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        }
        if (estadoEng == 'nd') {
            $('#estadoEng').attr('style', 'border: solid red 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        } else {
            $('#estadoEng').attr('style', 'border: solid green 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        }
        if (cidadeEng == 'nd') {
            $('#cidadeEng').attr('style', 'border: solid red 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        } else {
            $('#cidadeEng').attr('style', 'border: solid green 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        }
        if (cepEng == '') {
            $('#cepEng').attr('style', 'border: solid red 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        } else {
            $('#cepEng').attr('style', 'border: solid green 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        }
        if (enderecoEng == '') {
            $('#enderecoEng').attr('style', 'border: solid red 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        } else {
            $('#enderecoEng').attr('style', 'border: solid green 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        }
        if (assinatura == '') {
            $('#assinatura').attr('style', 'border: solid red 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        } else {
            $('#assinatura').attr('style', 'border: solid green 1px;border-radius: 5px; margin-bottom: 5px; width: 100%;');
        }
        return false;
    }
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/Cadastrar.json.php',
        data: {
            acao: 'cadEng',
            idUsuario: idUsuario,
            idEnt: idEnt,
            nomeEng: nomeEng,
            CREA: CREA,
            CPF: CPF,
            cepEng: cepEng,
            telefoneEng: telefoneEng,
            emailEng: emailEng,
            estadoEng: estadoEng,
            cidadeEng: cidadeEng,
            enderecoEng: enderecoEng,
            assinatura: assinatura,
            processoData: false,
            contentype: false
        },
        success: function (data) {
            $('#CadEng').modal('hide');
            Tutorial('Parte3');
            LimparCadEng();
            Title();
            MostrarSucesso(data);
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}

function mostrarErros(msg) {
    $('#Erro').empty();
    $('#Erro').append('<h4 style="text-align:center;">' + msg + '</h4>');
    $('#modalError').modal('show');
    return false;
}

function CadastrarSala(acao) {
    var idEnt = document.getElementById('idEnt').value;
    var idBloco = document.getElementById('blocoSala').value;
    if (idBloco == '') {
        mostrarErros('Campo do Bloco deve ser preenchido');
        $('#blocoSala').attr('style', 'width: 80%; border: solid red 1px; border-radius: 5px; margin-bottom: 5px;');
        return false;
    } else {
        $('#blocoSala').attr('style', 'width: 80%; border: solid green 1px; border-radius: 5px; margin-bottom: 5px;');
    }
    var quantSala = document.getElementsByName('Sala').length;
    var teste = document.getElementById('quantAndarSala');
    if (teste != null) {
        var quantAndar = document.getElementById('quantAndarSala').value;
        var quantSubSolo = document.getElementById('quantSubSoloSala').value;
        if (quantAndar == '') {
            mostrarErros('Quantidade de andar deve ser preenchido, mesmo que com zero (0)');
            $('#quantAndarSala').attr('style', 'width: 80%; border: solid red 1px; border-radius: 5px; margin-bottom: 5px;');
            return false;
        } else {
            $('#quantAndarSala').attr('style', 'width: 80%; border: solid green 1px; border-radius: 5px; margin-bottom: 5px;');
        }
        if (quantSubSolo == '') {
            mostrarErros('Quantidade de sub-solo deve ser preenchido, mesmo que com zero (0)');
            $('#quantSubSoloSala').attr('style', 'width: 80%; border: solid red 1px; border-radius: 5px; margin-bottom: 5px;');
            return false;
        } else {
            $('#quantSubSoloSala').attr('style', 'width: 80%; border: solid green 1px; border-radius: 5px; margin-bottom: 5px;');
        }
    } else {
        var quantAndar = '';
        var quantSubSolo = 0;
    }
    if (acao != 'cadSalaBloco') {
        if (quantSala == 0) {
            mostrarErros('Pelo menos uma Sala deve ser adicionada');
            return false;
        }
    }
    nomeSala = '';
    andar = '';
    for (i = 1; i <= quantSala; i++) {
        if (document.getElementById('nomeSala' + i).value != '') {
            $('#nomeSala' + i).attr('style', 'height: 25px; border: solid green 1px; font-weight: 100;');
            var nomeSala = nomeSala + "," + document.getElementById('nomeSala' + i).value;
        } else {
            $('#nomeSala' + i).attr('style', 'height: 25px; border: solid red 1px; font-weight: 100;');
            mostrarErros('Campo nome deve ser preenchido');
            return false;
        }
        if (document.getElementById('SelectSala' + i).value != '') {
            $('#SelectSala' + i).attr('style', 'height: 25px; border: solid green 1px; font-weight: 100;');
            var andar = andar + "," + document.getElementById('SelectSala' + i).value;
        } else {
            $('#SelectSala' + i).attr('style', 'height: 25px; border: solid red 1px; font-weight: 100;');
            mostrarErros('Campo andar deve ser selecionado');
            return false;
        }
    }
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/Cadastrar.json.php',
        data: {
            acao: acao,
            idEnt: idEnt,
            idBloco: idBloco,
            quantSala: quantSala,
            quantAndar: quantAndar,
            quantSubSolo: quantSubSolo,
            nomeSala: nomeSala,
            andar: andar,
            processoData: false,
            contentype: false
        },
        success: function (data) {
            var explode = data.split(';');
            if (acao != 'cadSalaBloco') {
                $('.cadSala').attr('style', 'display: none; background-color: white; width:100%;');
            } else {
                MostrarSucesso(explode[0]);
                $('#addSala').attr('onclick', 'MaisSala(1)');
            }
            $('#SalaCad').empty();
            $('#blocoSala').removeAttr('id');
            $('#selecioneBloco').append('<input type="hidden" id="blocoSala" value="' + explode[1] + '">');
            $('#BotaoCadBlocoSala').empty();
            Title();
            if (acao == 'cadSala') {
                MostrarSucesso(data);
                Tabela();
            }
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}

function AbrirModal(modal) {
    $('#tutorial').empty();
    $('#' + modal).modal('show');
}

function MaisAndar(id) {
    var quant = document.getElementById('quantAndar' + id).value;
    $('#Andar' + id).empty();
    for (i = 0; i <= quant; i++) {
        if (i == 0) {
            $('#Andar' + id).append('<div class="col-sm-3" style="margin-bottom: 1%;"><h5 style="margin:0%;float: left;">Térreo:</h5><input type="number" min="0" id="quantApart' + id + i + '" style="border:solid lightgray 1px; width:100%"></div>');
        } else {
            $('#Andar' + id).append('<div class="col-sm-3" style="margin-bottom: 1%;"><h5 style="margin:0%;float: left;">Andar ' + i + ':</h5><input type="number" min="0" id="quantApart' + id + i + '" style="border:solid lightgray 1px; width:100%"></div>');
        }
    }
}

function MontarUpdateSala(idBloco, andar) {
    var idEnt = document.getElementById('idEnt').value;
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/Selecionar.json.php',
        data: {
            acao: 'montarEditSala',
            idEnt: idEnt,
            idBloco: idBloco,
            andar: andar,
            processoData: false,
            contentype: false,
        },
        success: function (data) {
            $('.cad').attr('style', 'display: none; background-color: white; width:100%;');
            $('.Edit').attr('style', 'display: none; background-color: white; width:100%;');
            $('.cadSala').attr('style', 'display: none; background-color: white; width:100%;');
            $('.EditSala').removeAttr('style');
            $('.EditSala').attr('style', 'display: block; background-color: white; width:100%;');
            $('.EditSala').empty();
            $('.EditSala').append(data);
            $('#top').focus();
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}

function Edit(idBloco, idApart) {
    var idEnt = document.getElementById('idEnt').value;
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/Selecionar.json.php',
        data: {
            acao: 'edit',
            idEnt: idEnt,
            idBloco: idBloco,
            idApart: idApart,
            processoData: false,
            contentype: false,
        },
        success: function (data) {
            $('.cad').attr('style', 'display: none; background-color: white; width:100%;');
            $('.cadSala').attr('style', 'display: none; background-color: white; width:100%;');
            $('.Edit').removeAttr('style');
            $('.Edit').attr('style', 'display: block; background-color: white; width:100%;');
            $('.Edit').empty();
            $('.Edit').append(data);
            $('#nomeEdit').focus();
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}

function updateBloco() {
    var idEnt = document.getElementById('idEnt').value;
    var nomeBloco = document.getElementById('nomeEdit').value;
    var idBlocoEdit = document.getElementById('idBlocoEdit').value;
    var idApart = document.getElementById('prefixoUHEdit').value;
    var testeSubSolo = document.getElementsByName('SubSoloEdit');
    var quantSubSolo = 0;
    var quantAndar = document.getElementById('quantAndarEdit').value;
    if (nomeBloco == '') {
        var nomeBloco = document.getElementById('nomePadraoEdit').value;
    }
    for (i = 0; i < testeSubSolo.length; i++) {
        if (testeSubSolo[i].checked) {
            quantSubSolo += 1;
        }
    }
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/Atualizar.json.php',
        data: {
            acao: 'updateBloco',
            idEnt: idEnt,
            nomeBloco: nomeBloco,
            idBlocoEdit: idBlocoEdit,
            quantAndar: quantAndar,
            quantSubSolo: quantSubSolo,
            idApart: idApart,
            processoData: false,
            contentype: false
        },
        success: function (data) {
            Tabela();
            MostrarSucesso(data);
            $('.Edit').attr('style', 'display:none');
            $('#AndarEdit').empty();
            document.getElementById('nomeEdit').value = '';
            document.getElementById('quantAndarEdit').value = '';
            $('#ch_SubEedit01').prop('checked', false);
            $('#ch_SubEedit02').prop('checked', false);
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}

function updateUH(acao, id) {
    var novoNome = document.getElementById('EditUH' + id).value;
    var novoLocal = document.getElementById('EditLocal' + id).value;
    var idEnt = document.getElementById('idEnt').value;
    var idBloco = document.getElementById('blocoEditUH').value;
    var idAndar = document.getElementById('andarEditUH').value;
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/Atualizar.json.php',
        data: {
            acao: acao,
            idApart: id,
            novoLocal: novoLocal,
            novoNome: novoNome,
            processoData: false,
            contentype: false
        },
        success: function (data) {
            $('#modalEditUH').modal('hide');
            $('#VoltarEditUH').attr('onclick', 'MontarEditUH(' + idEnt + ',' + idBloco + ',' + idAndar + ')');
            Tabela();
            MostrarSucesso(data);
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}

function MostrarSucesso(msg) {
    $('#msgSucesso').empty();
    $('#msgSucesso').append("<h4 style='text-align:center;'>" + msg + "</h4>");
    $('#sucesso').modal('show');
}

function AddUH() {
    var quant = document.getElementById('quantUHadd').value;
    var idbloco = document.getElementById('blocoADDuh').value;
    var andar = document.getElementById('andarADDuh').value;

    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/Cadastrar.json.php',
        data: {
            acao: 'addUH',
            quant: quant,
            idbloco: idbloco,
            andar: andar,
            processoData: false,
            contentype: false,
        },
        success: function (data) {
            $('#modalEditUH').modal('hide');
            $('#VoltarEditUH').removeAttr('onclick');
            MostrarSucesso(data);
            Tabela();
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}

function UpdateSala(acao, id) {
    var idEnt = document.getElementById('idEnt').value;
    var novoNome = document.getElementById('novoNomeSala' + id).value;
    var idBloco = document.getElementById('BlocoEditSala' + id).value;
    var idAndar = document.getElementById('AndarEditSala' + id).value;
    var idApart = document.getElementById('UHEditApart' + id).value;
    var antigoBloco = document.getElementById('antigoBlocoSala').value;
    var antigoAndar = document.getElementById('antigoAndarSala').value;
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/Atualizar.json.php',
        data: {
            acao: acao,
            idEnt: idEnt,
            idApart: idApart,
            novoNome: novoNome,
            idBloco: idBloco,
            idAndar: idAndar,
            processoData: false,
            contentype: false
        },
        success: function (data) {
            if (acao == 'ExcluirSala') {
                MontarUpdateSala(antigoBloco, antigoAndar);
            }
            Tabela();
            MostrarSucesso(data);
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}

function aparecer(id) {
    $('#tutorial').empty();
    if (id == 'cadSala') {
        MontarCadSala('SelectBlocos,');
        $('.cad').attr('style', 'display: none; background-color: white; width:100%;');
        $('.Edit').attr('style', 'display: none; background-color: white; width:100%;');
        $('.EditSala').attr('style', 'display: none; background-color: white; width:100%;');
        $('.' + id).removeAttr('style');
        $('.' + id).attr('style', 'display: block; background-color: white; width:100%;');
    } else if (id == 'cad') {
        var idEnt = document.getElementById('idEnt').value;
        $.ajax({
            method: 'post',
            dataType: 'json',
            url: 'bib/ajax/Selecionar.json.php',
            data: {
                acao: 'cad',
                idEnt: idEnt,
                processoData: false,
                contentype: false,
            },
            success: function (data) {
                $('.Edit').attr('style', 'display: none; background-color: white; width:100%;');
                $('.EditSala').attr('style', 'display: none; background-color: white; width:100%;');
                $('.cadSala').attr('style', 'display: none; background-color: white; width:100%;');
                $('.' + id).removeAttr('style');
                $('.' + id).attr('style', 'display: block; background-color: white; width:100%;');
                $('#Bloco').empty();
                $('#Bloco').append('Bloco ' + data);
                $('#Bloco').append('<input type="hidden" id="nomePadrao" value="Bloco ' + data + '"/>');
            },
            error: function (msg) {
                alert(msg.responseText);
            }
        });
    }
}

function MaisSala(id) {
    $('#addSala').removeAttr('onclick');
    var valor = parseInt(id);
    var valor = valor + 1;
    $('#addSala').attr('onclick', 'MaisSala(' + valor + ')');
    var html = "<div class='col-sm-3' id='Sala" + id + "' style='padding: 20px; border: solid 5px white; margin-right:53px;'>" +
        "<div class='col-sm-12' style='padding: 0%;'>" +
        "<h5 style='float: left; margin:0%;'>Sala</h5>" +
        "<i class='fas fa-trash' onclick='removerSala(" + id + ")' style='float: right ;'></i>" +
        "</div>" +
        "<div class='col-sm-12' style='padding: 8% 0% 0% 0%;'>" +
        "<div class='form-group' style='margin:0%;'>" +
        "<input type='text' id='nomeSala" + id + "' name='Sala' class='form-control' style='height: 25px; border: solid lightgray 1px; font-weight: 100;' placeholder='Nome'/>" +
        "</div>" +
        "<h5 style='margin-top: 1%;'>Andar</h5>" +
        "<select id='SelectSala" + id + "'>" +
        "</select>" +
        "</div>" +
        "</div>";
    $('#SalaCad').append(html);
    MontarCadSala('selectAndar,' + id)
}

function removerSala(id) {
    $('#Sala' + id).remove();
}

function limpar() {
    $('#SalaCad').empty();
    $('#addSala').attr('onclick', 'MaisSala(1)')
}

function MontarCadSala(id) {
    $('#BotaoCadBlocoSala').empty();
    var teste = id.split(",")[0];
    var id = id.split(",")[1];
    var idEnt = document.getElementById('idEnt').value;
    if (teste == 'selectAndar') {
        var bloco = document.getElementById('blocoSala').value;
        $.ajax({
            method: 'post',
            dataType: 'json',
            url: 'bib/ajax/Selecionar.json.php',
            data: {
                acao: 'SelectAndar',
                idEnt: idEnt,
                bloco: bloco,
                processoData: false,
                contentype: false,
            },
            success: function (data) {
                $('#SelectSala' + id).empty();
                $('#SelectSala' + id).append(data);
            },
            error: function (msg) {
                alert(msg.responseText);
            }
        });
    } else if (teste == 'SelectBlocos') {
        $('#selecioneBloco').empty();
        $.ajax({
            method: 'post',
            dataType: 'json',
            url: 'bib/ajax/Selecionar.json.php',
            data: {
                acao: 'SelectBlocos',
                idEnt: idEnt,
                processoData: false,
                contentype: false,
            },
            success: function (data) {
                $('#selecioneBloco').empty();
                $('#selecioneBloco').append(data);
                $('#mudarSala').empty();
                $('#mudarSala').append('<i class="fas fa-plus-circle" data-toggle="popover" data-trigger="hover" data-content="Adicione bloco" onclick="CadBlocoAdm()" style="font-size: 3rem;"></i>');
                $('#mudarAcao').removeAttr('onclick');
                $('#mudarAcao').attr('onclick', 'CadastrarSala(\'cadSala\')');
            },
            error: function (msg) {
                alert(msg.responseText);
            }
        });
    }
}

function MontarEditUH(idEnt, idBloco, Andar) {
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/Selecionar.json.php',
        data: {
            acao: 'MontarEditUH',
            idEnt: idEnt,
            idBloco: idBloco,
            Andar: Andar,
            processoData: false,
            contentype: false,
        },
        success: function (data) {
            if (data == 'Sem') {
                $('#tamanhoModal').removeAttr('style');
                $('#tamanhoModal').attr('style', 'width: 30%;');
                $('#EditUH').empty();
                $('#EditUH').append('<h4>Não existe nenhuma UH nesse andar, adicione UHs</h4>')
                $('#modalEditUH').modal('show');
                $('#VoltarEditUH').removeAttr('onclick');
            } else {
                $('#tamanhoModal').removeAttr('style');
                $('#tamanhoModal').attr('style', 'width: 50%;');
                $('#EditUH').empty();
                $('#EditUH').append(data);
                $('#modalEditUH').modal('show');
                $('#VoltarEditUH').removeAttr('onclick');
            }
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}

function MontarAddUH(idEnt, idBloco, Andar) {
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'bib/ajax/Selecionar.json.php',
        data: {
            acao: 'addUHS',
            idEnt: idEnt,
            idBloco: idBloco,
            Andar: Andar,
            processoData: false,
            contentype: false,
        },
        success: function (data) {
            $('#tamanhoModal').removeAttr('style');
            $('#tamanhoModal').attr('style', 'width: 30%;');
            $('#EditUH').empty();
            $('#EditUH').append(data);
            $('#modalEditUH').modal('show');
        },
        error: function (msg) {
            alert(msg.responseText);
        }
    });
}

function SubSolo(id) {
    switch (id) {
        case 'Sub01':
            if ($('#ch_Sub02').is(':checked', false)) {
                $('#ch_Sub02').prop('checked', false);
            }
        case 'Sub02':
            if ($('#ch_Sub02').is(':checked')) {
                $('#ch_Sub01').prop('checked', true);
            }
            break;
        case 'SubEdit01':
            if ($('#ch_SubEdit02').is(':checked', false)) {
                $('#ch_SubEdit02').prop('checked', false);
            }
        case 'SubEdit02':
            if ($('#ch_SubEdit02').is(':checked')) {
                $('#ch_SubEdit01').prop('checked', true);
            }
            break;
    }
}

function CadBlocoAdm() {
    $('#selecioneBloco').empty();
    $('#SalaCad').empty();
    $('#selecioneBloco').append('<h5 style="margin:10% 0% 0% 0%;">Adicione bloco:</h5><input type="text" style="width:80%;" id="blocoSala"/>');
    $('#selecioneBloco').append('<h5 style="margin:0%;">Quant de Andar:</h5><input type="text" style="width:80%;" id="quantAndarSala"/>');
    $('#selecioneBloco').append('<h5 style="margin:0%;">Quant de Sub-Solo:</h5><input type="text" style="width:80%;" id="quantSubSoloSala"/>');
    $('#BotaoCadBlocoSala').empty();
    $('#BotaoCadBlocoSala').append('<div class="col-sm-12" id="dv_relat"><input readonly="readonly" id="addBlocos" value="Adicionar Bloco" class="fourth " style="background-color:#79bff7!important; width: 100%; font-size:14px; float:right;" onclick="CadastrarSala(\'cadSalaBloco\')"></div>')
    $('#mudarSala').empty();
    $('#mudarSala').append('<i class="fas fa-list" data-toggle="popover" data-trigger="hover" data-content="Selecione bloco" onclick="MontarCadSala(\'SelectBlocos,\')" style="font-size: 3rem;"></i>');
    $('#nomeBlocoAdm').focus();
    $('#mudarAcao').removeAttr('onclick');
    $('#mudarAcao').attr('onclick', 'CadastrarSala(\'cadSala\')');
    var teste = document.getElementById('addBlocos')
    if (teste != null) {
        $('#addSala').removeAttr('onclick');
    }
}

function mostrarImg(id) {
    $('#assinatura').change(function () {
        const file = $(this)[0].files[0]

        if (file.size < (1024 * 2025)) {
            var reader = new FileReader();
            reader.readAsDataURL(file);

            reader.onload = function () {
                $('#imagemPre' + id).attr('src', this.result);
            }
        } else {
            $('#imagemPre' + id).attr('src', 'bib/img/imagem.png');
            document.getElementById("file").value = '';
        }


    })
}

$(function () {
    $('[data-toggle="popover"]').popover()
})

$('.popover-dismiss').popover({
    trigger: 'focus'
})