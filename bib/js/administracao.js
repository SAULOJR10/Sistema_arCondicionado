$(document).ready(function () {
        $(".cnpj").mask("99.999.999/9999-99");
        $(".telefone").mask("(99) 99999-9999");
        $(".cep").mask("99999-999");
        $(".cpf").mask("999.999.999-99");
});


function ADDAR(){
        var quant = document.getElementById('quantAr').value;
        var UH = document.getElementById('UHADDAR').value;
        var localizacao = '';
        var marca = '';
        var modelo = '';
        var potencia = '';
        var observacao = '';
        var tempo_uso = '';
        for(i=1; i <= quant; i++){
                localizacao = localizacao + document.getElementById('localizacao'+i).value + ';';
                marca = marca + document.getElementById('marca'+i).value + ';';
                modelo = modelo + document.getElementById('modelo'+i).value + ';';
                potencia = potencia + document.getElementById('potencia'+i).value + ';';
                observacao = observacao + document.getElementById('observacao'+i).value + ';';
                if($('#ch_usado'+i).is(':checked')){
                        tempo_uso = tempo_uso + document.getElementById('tempo_uso'+i).value + ';';
                }else{
                        tempo_uso = tempo_uso + 0 + ';';
                }
        }
        $.ajax({
                method: 'post',
                dataType: 'json',
                url: 'bib/ajax/CadastrarAdm.json.php',
                data: {
                        acao: 'ADDAR',
                        quant: quant,
                        UH: UH,
                        localizacao: localizacao,
                        marca: marca,
                        modelo: modelo,
                        potencia: potencia,
                        observacao: observacao,
                        tempo_uso: tempo_uso,
                        processoData: false,
                        contentype: false,
                },
                success: function (data) {
                        document.getElementById('quantAr').value = '';
                        $('#arCond').empty();
                        $('#CadProp2').modal('hide');
                },
                error: function (msg) {
                        alert(msg.responseText);
                }
        });
}

function MontarGerUH(bloco) {
        var andar = document.getElementById('andarGer').value;
        $.ajax({
                method: 'post',
                dataType: 'json',
                url: 'bib/ajax/SelecionarAdm.json.php',
                data: {
                        acao: 'MontarGerUH',
                        andar: andar,
                        bloco: bloco,
                        processoData: false,
                        contentype: false,
                },
                success: function (data) {
                        $('#gerenciamento').empty();
                        $('#gerenciamento').append(data);
                        $('#QualAndar').empty();
                        if (andar < 0) {
                                $('#QualAndar').append('Sub-Solo (' + andar + ')');
                        }
                        if (andar == 0) {
                                $('#QualAndar').append('Térreo');
                        }
                        if (andar > 0) {
                                $('#QualAndar').append('Andar ' + andar);
                        }
                },
                error: function (msg) {
                        alert(msg.responseText);
                }
        });
}

function SelectBlocosGer() {
        var idEnt = document.getElementById('idEnt').value;
        $.ajax({
                method: 'post',
                dataType: 'json',
                url: 'bib/ajax/SelecionarAdm.json.php',
                data: {
                        acao: 'SelectBloco',
                        idEnt: idEnt,
                        processoData: false,
                        contentype: false,
                },
                success: function (data) {
                        $('#blocoGer').empty();
                        $('#blocoGer').append(data);
                        aparecer('ger', 'aparecer');
                },
                error: function (msg) {
                        alert(msg.responseText);
                }
        });
}

function SelectAndarGer() {
        var idEnt = document.getElementById('idEnt').value;
        var idBloco = document.getElementById('blocoGer').value;
        $.ajax({
                method: 'post',
                dataType: 'json',
                url: 'bib/ajax/SelecionarAdm.json.php',
                data: {
                        acao: 'SelectAndar',
                        idEnt: idEnt,
                        idBloco: idBloco,
                        processoData: false,
                        contentype: false,
                },
                success: function (data) {
                        $('#colocarAndar').empty();
                        $('#colocarAndar').append(data);
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
                url: 'bib/ajax/SelecionarAdm.json.php',
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

function Title() {
        var idEnt = document.getElementById('idEnt').value;
        $.ajax({
                method: 'post',
                dataType: 'json',
                url: 'bib/ajax/SelecionarAdm.json.php',
                data: {
                        acao: 'infoTela',
                        idEnt: idEnt,
                        processoData: false,
                        contentype: false
                },
                success: function (data) {
                        var quant = data.split(";");
                        $('#UHGer').empty();
                        $('#UHGer').append(quant[0]);
                        $('#ARGer').empty();
                        $('#ARGer').append(quant[1]);
                        $('#SalaGer').empty();
                        $('#SalaGer').append(quant[2]);
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
                url: 'bib/ajax/SelecionarAdm.json.php',
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
                        $("#Corpo").append(data);
                        Title();
                },
                error: function (msg) {
                        alert(msg);
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

function SoUm(id) {
        if (id == 'ch_fisica') {
                $('#ch_juridica').prop('checked', false);
                var html = '<div class="col-sm-3"><p>CPF</p><div class="form-group"><input type="text" id="documentoProp" placeholder="77.777.777-77" class="form-control cpf" style="width: 98%; height:30px;"></div></div>';
                $('#ColocarAparecer').attr('onclick', "aparecer('Edit','aparecer', 'cad')");
        } else if (id == 'ch_juridica') {
                $('#ch_fisica').prop('checked', false);
                var html = '<div class="col-sm-12"><p>Razão Social</p><div class="form-group"><input type="text" id="razaoSocial" placeholder="Atividade exercida pela empresa..." class="form-control" style="width: 93%; height:30px;"></div></div><div class="col-sm-3"><p>CNPJ</p><div class="form-group"><input type="text" id="documentoProp" placeholder="77.777.777/7777-77" class="form-control cnpj" style="width: 98%; height:30px;"></div></div>';
                $('#ColocarAparecer').attr('onclick', "aparecer('Edit','aparecer', 'cad')");
        }
        $('#documento').empty();
        $('#documento').append(html);
}

function CadDadosAr(id){
        var nome = document.getElementById('nome').value;
        $.ajax({
                method: 'post',
                dataType: 'json',
                url: 'bib/ajax/CadastrarAdm.json.php',
                data: {
                        acao: id,
                        nome: nome,
                        processoData: false,
                        contentype: false
                },
                success: function (data) {
                        document.getElementById('nome').value = '';
                        $('#Edit').modal('hide');
                },
                error: function (msg) {
                        alert(msg);
                }
        }); 
}

function AbrirModal(abrir, fechar, idUH) {
        switch (fechar) {
                case 'Loc':
                        $('.dadoAr').empty();
                        $('.dadoAr').append('Localização');
                        var options = document.getElementById('localizacao1').innerHTML;
                        $('#EditDadosAr').empty();
                        $('#EditDadosAr').append('<div class="col-sm-6"><div class="form-group"><select class="form-control" id="dadosArEdit" style="color: #444444; width:80%;">'+options+'</select><i class="fas fa-pencil-alt" style="margin-top:3px;" id="removeEditar" onclick="Edit(\'Localizacao\')"></i><i class="fas fa-times" id="removeExcluir" style="color:red; font-size:2rem;" onclick="ExcluirDadosAR(\'Localizacao\')"></i></div></div><div class="col-sm-3" id="novonome"></div>');
                        $('#inserirOnclick').removeAttr('onclick');
                        $('#inserirOnclick').attr('onclick', 'CadDadosAr("InserirLocal")');
                        break;
                case 'Marca':
                        $('.dadoAr').empty();
                        $('.dadoAr').append('Marca');
                        var options = document.getElementById('marca1').innerHTML;
                        $('#EditDadosAr').empty();
                        $('#EditDadosAr').append('<div class="col-sm-6"><div class="form-group"><select class="form-control" id="dadosArEdit" style="color: #444444; width:80%;">'+options+'</select><i class="fas fa-pencil-alt" style="margin-top:3px;" id="removeEditar" onclick="Edit(\'Marca\')"></i><i class="fas fa-times" id="removeExcluir" style="color:red; font-size:2rem;" onclick="ExcluirDadosAR(\'Marca\')"></i></div></div><div class="col-sm-3" id="novonome"></div>');
                        $('#inserirOnclick').removeAttr('onclick');
                        $('#inserirOnclick').attr('onclick', 'CadDadosAr("InserirMarca")');
                        break;
                case 'Mod':
                        $('.dadoAr').empty();
                        $('.dadoAr').append('Modelo');
                        var options = document.getElementById('modelo1').innerHTML;
                        $('#EditDadosAr').empty();
                        $('#EditDadosAr').append('<div class="col-sm-6"><div class="form-group"><select class="form-control" id="dadosArEdit" style="color: #444444; width:80%;">'+options+'</select><i class="fas fa-pencil-alt" style="margin-top:3px;" id="removeEditar" onclick="Edit(\'Modelo\')"></i><i class="fas fa-times" id="removeExcluir" style="color:red; font-size:2rem;" onclick="ExcluirDadosAR(\'Modelo\')"></i></div></div><div class="col-sm-3" id="novonome"></div>');
                        $('#inserirOnclick').removeAttr('onclick');
                        $('#inserirOnclick').attr('onclick', 'CadDadosAr("InserirModelo")');
                        break;
                case 'Pot':
                        $('.dadoAr').empty();
                        $('.dadoAr').append('Potência');
                        var options = document.getElementById('potencia1').innerHTML;
                        $('#EditDadosAr').empty();
                        $('#EditDadosAr').append('<div class="col-sm-6"><div class="form-group"><select class="form-control" id="dadosArEdit" style="color: #444444; width:80%;">'+options+'</select><i class="fas fa-pencil-alt" style="margin-top:3px;" id="removeEditar" onclick="Edit(\'Potencia\')"></i><i class="fas fa-times" id="removeExcluir" style="color:red; font-size:2rem;" onclick="ExcluirDadosAR(\'Potencia\')"></i></div></div><div class="col-sm-3" id="novonome"></div>');
                        $('#inserirOnclick').removeAttr('onclick');
                        $('#inserirOnclick').attr('onclick', 'CadDadosAr("InserirPotencia")');
                        break;
        }
        if (fechar == 'Loc' || fechar == 'Marca' || fechar == 'Mod' || fechar == 'Pot') {
                fechar = 'CadProp2';
                $('#' + fechar).modal('hide');
        } else {
                $('#' + fechar).modal('hide');
        }
        if (abrir == 'CadProp') {
                $('#ColocarAbrir2').removeAttr('onclick');
                $('#ColocarAbrir2').attr('onclick', 'AbrirModal(\'CadProp2\', \'CadProp\', '+idUH+')');
                $('#QualUH').empty();
                $('#QualUH').append('<input type="hidden" value="' + idUH + '" id="PropUH">');
                $('#UH').empty();
                $('#UH').append(fechar);
        }
        if(abrir == 'CadProp2'){
                $('#QualUHAr').empty();
                $('#QualUHAr').append('<input type="hidden", value="'+idUH+'" id="UHADDAR"/>');
        }
        $('#' + abrir).modal('show');
}

function Edit(id) {
        $('#removeExcluir').remove();
        $('#removeEditar').remove();
        $('#novonome').empty();
        $('#novonome').append('<div class="form-group"><input type="text" style="width:150px;" id="NovoNomeDadosAr"/>&nbsp;&nbsp;&nbsp;<i class="fas fa-check" id="removeCheck" onclick="EditDadosAr(\''+id+'\')" style="color:green; font-size:2rem;"></i></div>');
}

function EditDadosAr(tabela){
        nomeAntigo = document.getElementById('dadosArEdit').value;
        novoNome = document.getElementById('NovoNomeDadosAr').value;
        $.ajax({
                method: 'post',
                dataType: 'json',
                url: 'bib/ajax/AtualizarAdm.json.php',
                data: {
                        acao: 'atualizarDadosAr',
                        tabela: tabela,
                        nomeAntigo: nomeAntigo,
                        novoNome: novoNome,
                        processoData: false,
                        contentype: false
                },
                success: function (data) {
                        $('#Edit').modal('hide');
                        $('#CadProp2').modal('show');
                },
                error: function (msg) {
                        alert(msg.responseText);
                }
        });
}

function ExcluirDadosAR(tabela){
        nomeAntigo = document.getElementById('dadosArEdit').value;
        $.ajax({
                method: 'post',
                dataType: 'json',
                url: 'bib/ajax/AtualizarAdm.json.php',
                data: {
                        acao: 'ExcluirDadosAr',
                        tabela: tabela,
                        nomeAntigo: nomeAntigo,
                        processoData: false,
                        contentype: false
                },
                success: function (data) {
                        $('#Edit').modal('hide');
                        quantAr();
                },
                error: function (msg) {
                        alert(msg.responseText);
                }
        });
}

function aparecer(classe, acao, id) {
        if (acao == 'aparecer') {
                $('.' + classe).removeAttr('style');
        }
        if (classe == 'desabledPessoa') {
                if (!$('#ch_cad').is(':checked')) {
                        $('.sumir').attr('style', 'display:none;');
                }
        }
        if ($('#ch_' + id).is(':checked')) {
                $('.' + acao).removeAttr('style');
                $('.' + classe).prop('disabled', false);
        } else {
                limparUHGer();
        }
}

function Gerenciadas(){
        var quant = document.getElementsByName('allUHS').length;
        var gerenciadas = ';';
        var naoGerenciadas = ';';
        for(i = 1; i <= quant; i++){
                if($('#ch_UH'+i).is(':checked')){
                        gerenciadas = gerenciadas + document.getElementById('gerenciada'+i).value + ';';
                }else{
                        naoGerenciadas = naoGerenciadas + document.getElementById('gerenciada'+i).value + ';';
                }
        }
        $.ajax({
                method: 'post',
                dataType: 'json',
                url: 'bib/ajax/AtualizarAdm.json.php',
                data: {
                        acao: 'Gerenciada',
                        gerenciadas: gerenciadas,
                        naoGerenciadas: naoGerenciadas,
                        processoData: false,
                        contentype: false
                },
                success: function (data) {
                        Tabela();
                },
                error: function (msg) {
                        alert(msg.responseText);
                }
        });
}

function limparUHGer() {
        document.getElementById('nomeProp').value = '';
        document.getElementById('documentoProp').value = '';
        document.getElementById('telefoneProp').value = '';
        document.getElementById('emailProp').value = '';
        document.getElementById('CEPProp').value = '';
        document.getElementById('enderecoProp').value = '';
        $('#selecioneEst').prop('selected', true);
        $('#selecioneCity').prop('selected', true);
        $('.Edit').attr('style', 'display:none;');
        $('.sumir').attr('style', 'display:none;');
        $('.opaco').attr('style', 'opacity:0.5;');
        $('#tipo_Prop1').prop('checked', false);
        $('#tipo_Prop2').prop('checked', false);
        $('#tipo_Prop1').prop('desabled', true);
        $('#tipo_Prop2').prop('desabled', true);
        $('#ch_cad').prop('checked', false);
        $('#ch_juridica').prop('checked', false);
        $('#ch_fisica').prop('checked', false);
}

function ADDProp() {
        if ($('#tipo_Prop1').is(':checked')) {
                var tipoPropriedade = document.getElementById('tipo_Prop1').value;
        } else if ($('#tipo_Prop2').is(':checked')) {
                var tipoPropriedade = document.getElementById('tipo_Prop2').value;
        }
        if ($('#ch_juridica').is(':checked')) {
                var tipoPessoa = document.getElementById('ch_juridica').value;
        } else if ($('#ch_fisica').is(':checked')) {
                var tipoPessoa = document.getElementById('ch_fisica').value;
        }
        if (document.getElementById('razaoSocialProp') != undefined) {
                var razaoSocial = document.getElementById('razaoSocialProp').value;
        } else {
                var razaoSocial = '';
        }
        var UH = document.getElementById('PropUH').value;
        var nomeProp = document.getElementById('nomeProp').value;
        var documento = document.getElementById('documentoProp').value;
        var telefoneProp = document.getElementById('telefoneProp').value;
        var emailProp = document.getElementById('emailProp').value;
        var CEPProp = document.getElementById('CEPProp').value;
        var EstadoProp = document.getElementById('EstadoProp').value;
        var CidadeProp = document.getElementById('CidadeProp').value;
        var enderecoProp = document.getElementById('enderecoProp').value;
        $.ajax({
                method: 'post',
                dataType: 'json',
                url: 'bib/ajax/CadastrarAdm.json.php',
                data: {
                        acao: 'ADDProp',
                        UH: UH,
                        nomeProp: nomeProp,
                        documento: documento,
                        razaoSocial: razaoSocial,
                        telefoneProp: telefoneProp,
                        emailProp: emailProp,
                        CEPProp: CEPProp,
                        EstadoProp: EstadoProp,
                        CidadeProp: CidadeProp,
                        tipoPropriedade: tipoPropriedade,
                        tipoPessoa: tipoPessoa,
                        enderecoProp: enderecoProp,
                        processoData: false,
                        contentype: false
                },
                success: function (data) {
                        AbrirModal('CadProp2', 'CadProp', UH);
                        limparUHGer();
                },
                error: function (msg) {
                        alert(msg.responseText);
                }
        });
}

function quantAr() {
        var quant = document.getElementById('quantAr').value;
        var idEnt = document.getElementById('idEnt').value;
        var html = '';
        $.ajax({
                method: 'post',
                dataType: 'json',
                url: 'bib/ajax/SelecionarAdm.json.php',
                data: {
                        acao: 'selects',
                        idEnt: idEnt,
                        processoData: false,
                        contentype: false
                },
                success: function (data) {
                        var options1 = data.split(';')[1];
                        var options2 = data.split(';')[2];
                        var options3 = data.split(';')[3];
                        var options4 = data.split(';')[4];
                        for (i = 1; i <= quant; i++) {
                                html = html + '<div class="col-sm-12">'
                                        + '<h5 style = "margin-top: 3.5%; float:left;">'
                                        + '<b><i class="far fa-check-square" style="floa:left; font-size:2rem;"></i>Ar Condicionado 0' + i + '</b>'
                                        + '</h5></div><div class="col-sm-3">'
                                        + '<p>Localização: <i onclick="AbrirModal(\'Edit\', \'Loc\')" class="fas fa-pencil-alt" style="float: right;"></i></p><div class="form-group">'
                                        + '<select class="form-control" style="color: #444444;" id="localizacao' + i + '">'+options1+'</select></div></div>'
                                        + '<div class="col-sm-3">'
                                        + '<p>Marca: <i onclick="AbrirModal(\'Edit\', \'Marca\')" class="fas fa-pencil-alt" style="float: right;"></i></p><div class="form-group">'
                                        + '<select class="form-control" id="marca'+i+'" style="color: #444444;">'+options2+'</select></div></div>'
                                        + '<div class="col-sm-3">'
                                        + '<p>Modelo: <i onclick="AbrirModal(\'Edit\', \'Mod\')" class="fas fa-pencil-alt" style="float: right;"></i></p><div class="form-group">'
                                        + '<select class="form-control" id="modelo'+i+'" style="color: #444444;">'+options3+'</select></div></div>'
                                        + '<div class="col-sm-3">'
                                        + '<p>Potência: <i onclick="AbrirModal(\'Edit\', \'Pot\')" class="fas fa-pencil-alt" style="float: right;"></i></p><div class="form-group">'
                                        + '<select class="form-control" id="potencia'+i+'" style="color: #444444;">'+options4+'</select></div></div>'
                                        + '<div class="col-sm-12"><p style="float: left; margin-top:1%;">Ar Condicionado usado ?</p><div class="col-xs-1 " style="padding-right: 0px; padding-left:0px; margin:0.5% 2% 0% 2%;">'
                                        + '<input id="ch_usado' + i + '" class="switch switch--shadow" type="checkbox"><label style="float:right; min-width: 40px;" for="ch_usado' + i + '"></label></div><div class="form-group">'
                                        + '<select class="form-control" id="tempo_uso'+i+'" style="color: #444444;"><option>Tempo de uso</option><option>6 meses</option><option>1 ano</option><option>1 ano e 6 meses</option></select></div></div>'
                                        + '<div class="col-sm-12"style="border-bottom:solid green 1px">'
                                        + '<p>Observações</p><input type="text" id="observacao'+i+'" style="width: 100%; margin-bottom:20px;" /></div>';
                        }
                        $('#ArCond').empty();
                        $('#ArCond').append(html);
                },
                error: function (msg) {
                        alert(msg.responseText);
                }
        });
}