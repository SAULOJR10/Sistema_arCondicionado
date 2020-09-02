<?php
include_once "bib/comum/conexao.php";

session_start();
$idLogin = $_SESSION['idUsuario'];

if(isset($_GET['Ent'])){
    $Entidade = $_GET['Ent'];
}else{
    $Entidade = 'Selecione';
}

if (isset($_SESSION['numLogin'])) {
    $n1 = $_GET["num1"];
    $n2 = $_SESSION["numLogin"];
    if ($n1 != $n2) {
        header("Location:index.php");
        exit;
    }
} else {
    header("Location:index.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <?php include_once 'bib/comum/bibi.php'; ?>
    <link rel="stylesheet" type="text/css" href="bib/css/SistemaArCondicionado.css">
    <link rel="stylesheet" type="text/css" href="bib/css/tabelas.css">
</head>

<body class="mybody" style="background-color: white;">
    <?php include_once 'bib/comum/menu_bar.php'; ?>
    <div class="row">
        <div class="col-xs-3 infmenuslider inf_alt">
            <?php include_once 'bib/comum/menu.php'; ?>
        </div>
        <div class="col-xs-9 infcorpo inf_alt">
            <div class="limiter">
                <div class="container-table100">
                    <div class="row">

                        <div class="col-sm-12" style="background-color: white; height:100px; padding:0%;">

                            <div class="col-sm-12 button" id="Ordem" style="background-color: white; border: none;" align="center">
                                <i class="fas fa-map-marker-alt" style="font-size: 3rem; float:left; margin-left:30%; margin-top:1%;"></i>
                                <h3 style="font-size: 4rem; margin-top: 0%; margin-right:35%;">Cadastro Predial</h3>
                                <hr>
                            </div>
                        </div>
                        <div class="col-sm-12" style="height:100px;">
                            <div style="width:13%; padding-top:1%;" class="col-sm-2 button " id="Ordem" align="center">
                                <h1 style="margin-top:0%;"><b id="quantBloco">0</b></h1>
                                <h3 style="margin-top: 5px; font-size: 1.6rem;" align="center"> Blocos</h3>
                            </div>

                            <div style="width:13%; padding-top:1%;" class="col-sm-2 button" align="center">
                                <h1 style="margin-top:0%;"><b id="quantAndar">0</b></h1>
                                <h3 style="margin-top: 5px; font-size: 1.6rem;" align="center"> Andares</h3>
                            </div>

                            <div style="width:13%; padding-top:1%;" class="col-sm-2 button" align="center">
                                <h1 style="margin-top:0%;"><b id="quantUH">0</b></h1>
                                <h3 style="margin-top: 5px; font-size: 1.6rem;" align="center"> UHs </h3>
                            </div>

                            <div style="width:13%; padding-top:1%;" class="col-sm-2 button " id="Ordem" align="center">
                                <h1 style="margin-top:0%;"><b id="quantSala">0</b></h1>
                                <h3 style="margin-top: 5px; font-size: 1.6rem;" align="center"> Salas</h3>
                            </div>

                            <div style="width:13%; padding-top:1%;" class="col-sm-2 button " id="Ordem" align="center">
                                <h1 style="margin-top:0%;"><b id="quantEng">0</b></h1>
                                <h3 style="margin-top: 5px; font-size: 1.6rem;" align="center"> Engenheiros</h3>
                            </div>

                            <div onclick="AbrirModal('CadEnt')" class="col-sm-1 button mais">
                                <img src="bib/img/dadosEnt.png" style="width: 4.5rem;">
                                <h3 style="font-size:1.6rem;margin-top:0%;">Dados Entidade</h3>
                            </div>
                            <div id="BotaoCadEnt" tabindex="0" data-toggle="popover" data-trigger="hover" data-placement="bottom" title="Por favor, primeiro selecione ou cadastre uma entidade" class="col-sm-1 button mais">
                                <img src="bib/img/infoTec.png" style="width: 4.5rem;">
                                <h3 style="font-size:1.6rem;margin-top:0%;">Dados Engenheiro</h3>
                            </div>
                            <div id="BotaoCadSalas" tabindex="1" data-toggle="popover" data-trigger="hover" data-placement="bottom" title="Por favor, primeiro selecione ou cadastre uma entidade" class="col-sm-1 button mais">
                                <h3 style="font-size: 4.6rem;margin:0;margin-top:-5px; color:lightblue;">+</h3>
                                <h3 style="font-size:1.6rem;margin-top:0%;">Adicionar Sala ADM</h3>
                            </div>
                            <div id="BotaoCadBlocos" tabindex="2" data-toggle="popover" data-trigger="hover" data-placement="bottom" title="Por favor, primeiro selecione ou cadastre uma entidade" class="col-sm-1 button mais">
                                <h3 style="font-size: 4.6rem;margin:0;margin-top:-5px;">+</h3>
                                <h3 style="font-size:1.6rem;margin-top:0%;">Adicionar Bloco</h3>
                            </div>
                        </div>
                    </div>
                    <div id="tutorial" style="width:100%"></div>
                    <div style="margin-top: 1%; width:100%">
                        <div class="cad" style="display: none; background-color: white; width:100%;">
                            <div class="row">
                                <div class="col-sm-12 cadastro" style="padding:0%; padding-left:2%;">
                                    <h4><b>Cadastrar Bloco</b></h4>
                                </div>
                            </div>
                            <div class="row cadastro" style="margin-bottom:10px;">
                                <div class="col-sm-3">
                                    <div class="numeracao" style="padding-top: 2.5%;">1</div>
                                    <h5 style="margin-top: 5%;"><b>Nome e Andar</b></h5>
                                    <div class="col-sm-12" style="padding:0%;">
                                        <p style="background-color: rgb(194,228,255, 0.56); font-size:16px; text-align:center; margin-top: 10px; width:74%; padding-top:5px; padding-bottom:5px;"><b id="Bloco"></b></p><br>
                                        <h5 style="margin: 0%;">Nome (opcional):</h5>
                                        <input type="text" id="nomeBloco" style="margin-top: 2px; border:solid lightgray 1px;  width:74%; margin-bottom: 5%;">
                                        <h5 style="margin: 0%;">Quantidade de andares:</h5>
                                        <input type="number" min='0' id="quantAndarCad" onkeyup="MaisAndar('Cad')" id="quantCad" style="margin-top: 2px; border:solid lightgray 1px;  width:74%;">
                                        <div class="col-sm-6" style="padding: 0%;">
                                            <p>SubSolo (-1)</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="col-xs-3 " style="padding-right: 0px; padding-left:0px; margin:2% 5% 0% 20%;">
                                                <input id="ch_Sub01" onclick="SubSolo('Sub01')" name="SubSolo" class="switch switch--shadow" type="checkbox">
                                                <label style="float:right; min-width: 40px;" for="ch_Sub01"></label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6" style="padding: 0%;">
                                            <p>SubSolo (-2)</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="col-xs-3 " style="padding-right: 0px; padding-left:0px; margin:2% 5% 0% 20%;">
                                                <input id="ch_Sub02" onclick="SubSolo('Sub02')" name="SubSolo" value="" class="switch switch--shadow" type="checkbox">
                                                <label style="float:right; min-width: 40px;" for="ch_Sub02"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="numeracao">2</div>
                                    <h5 style="margin-top: 1.7%;"><b>Quantidade de UH(s) por andar:</b></h5>
                                    <div class="col-sm-12" style="margin-bottom: 3%;">
                                        <div class="form-group" style="float: right;">
                                            <h5 style="margin-left:15%; margin-top: 4px;">prefixo antes do numero do apartamento:</h5>
                                            <input type="text" style="height: 20px; font-size: 12px; text-align: left; width: 15%; padding: 1%;" value="" class="form-control" id="prefixoUH" maxlength="1" placeholder="ex: A-101">
                                        </div>
                                    </div>
                                    <div id="AndarCad">
                                    </div>
                                </div>
                                <div class="col-sm-1" style="background-color:white;" onclick="CadastrarBloco('Bloco')">
                                    <h5 style="margin-top: 25%;margin-bottom: 6%; margin-left:11%;"><b>Gravar</b></h5>
                                    <i class="far fa-save" style="font-size: 3.5rem;margin-left:22.5%; margin-bottom:25%;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="cadSala" style="display: none; background-color: white; width:100%;">
                            <div class="row">
                                <div class="col-sm-12 cadastro" style="padding:0%; padding-left:2%;">
                                    <h4><b>Cadastrar Sala</b></h4>
                                </div>
                            </div>
                            <div class="row cadastro" style="margin-bottom:10px;">
                                <div class="col-sm-3">
                                    <div class="numeracao" style="padding-top: 2.5%;">1</div>
                                    <h5 style="margin-top: 5%;"><b>configurações de bloco:</b></h5>
                                    <div class="col-sm-8" style="padding-right: 0%;">
                                        <div id="selecioneBloco">
                                        </div>
                                    </div>
                                    <div class="col-sm-2" style="padding: 12% 0% 0% 0%;">
                                        <b style="text-align: left;">OU</b>
                                    </div>
                                    <div class="col-sm-2" id="mudarSala" style="padding: 10% 0% 0% 0%;">
                                        <i class="fas fa-plus-circle" data-toggle="popover" data-trigger="hover" data-content="Adicione bloco" onclick="CadBlocoAdm()" style="font-size: 3rem;"></i>
                                    </div>
                                    <div id="BotaoCadBlocoSala"></div>
                                    <div class="col-sm-12" id="dv_relat">
                                        <input readonly="readonly" id="addSala" value="Adicionar Sala" class="fourth " style="background-color:#79bff7!important; width: 100%; font-size:14px; float:right;">
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="numeracao">2</div>
                                    <h5 style="margin-top: 1.7%;"><b>Configurações de sala:<b></h5>
                                    <div id="SalaCad">
                                    </div>
                                </div>
                                <div class="col-sm-1" style="background-color:white;" id="mudarAcao" onclick="CadastrarSala('cadSala')">
                                    <h5 style="margin-top: 25%;margin-bottom: 6%; margin-left:11%;"><b>Gravar</b></h5>
                                    <i class="far fa-save" style="font-size: 3.5rem;margin-left:22.5%; margin-bottom:25%;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="Edit" style="display: none; background-color: white;">
                        </div>
                        <div class="EditSala" style="display: none; background-color: white; width:100%;">
                            <div class="row">
                                <div class="col-sm-12 cadastro" style="padding:0%; padding-left:2%;">
                                    <h4><b>Editar Sala</b></h4>
                                </div>
                            </div>
                            <div class="row cadastro" style="margin-bottom:10px;">
                                <div class="col-sm-3">
                                    <div class="numeracao" style="padding-top: 2.5%;">1</div>
                                    <h5 style="margin-top: 5%;"><b>Editando:</b></h5>
                                    <div class="col-sm-12" style="padding: 25% 0% 0% 0%; height:215px; background-color:white;">

                                        <h3 style="text-align:center;"><b>Bloco ADM</b></h3>
                                        <h4 style="text-align:center;"><b>Andar 0</b></h4>
                                        <input type="hidden" id="antigoBlocoSala" value="213">
                                        <input type="hidden" id="antigoAndarSala" value="0">
                                        <input type="number" style="opacity:0; height:1px;" id="top">
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="numeracao">2</div>
                                    <h5 style="margin-top: 1.7%;"><b>Edição de sala:<b></b></b></h5><b><b>
                                            <div id="SalaCad">
                                                <div class="col-sm-3" id="Sala1" style="padding: 20px; border: solid 5px white; margin-right:53px;">
                                                    <div class="col-sm-12" style="padding: 0%;">
                                                        <h5 style="float: left; margin:0%;">Sala</h5>
                                                        <i class="fas fa-trash" onclick="UpdateSala('ExcluirSala', 1)" style="float: right;"></i>
                                                        <i class="far fa-save" onclick="UpdateSala('EditSala', 1)" style="float: right; margin-right:10px; font-size: 1.6rem;"></i>
                                                    </div>
                                                    <div class="col-sm-12" style="padding: 8% 0% 0% 0%;">
                                                        <div class="form-group" style="margin:0%;">
                                                            <input type="text" value="Sala 0" id="novoNomeSala1" name="" class="form-control" style="height: 25px; border: solid lightgray 1px; font-weight: 100;" placeholder="Nome"></div>
                                                        <input type="hidden" value="3043" id="UHEditApart1">
                                                        <h5 style="margin-top: 1%;">Bloco</h5>
                                                        <select id="BlocoEditSala1">
                                                            <option value="">Selecione</option>
                                                            <option value="211">Bloco A</option>
                                                            <option value="213" selected="">Bloco ADM</option>
                                                            <option value="216">Bloco ADM 2</option>
                                                            <option value="212">Bloco B</option>
                                                        </select>
                                                        <h5 style="margin-top: 1%;">Andar</h5>
                                                        <select id="AndarEditSala1">
                                                            <option value="">Selecione</option>
                                                            <option value="0" selected="">Térreo</option>
                                                            <option value="1">Andar 1</option>
                                                            <option value="2">Andar 2</option>
                                                            <option value="3">Andar 3</option>
                                                            <option value="4">Andar 4</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" id="tabela" style="margin-top: 1%;">
                    <div class="col-sm-12" style="padding:0%;" id="Corpo">
                    </div>
                </div>
                <div class="row" id="tabelaSala" style="margin-top: 1%;">
                    <div class="col-sm-12" style="padding:0%;" id="CorpoSala">
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>

    <!----------------------------------------------------------------Modal-------------------------------------------------------------------------->
    <div class="modal fade" id="CadEnt" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="width: 50%;">
            <div class="modal-content" style="border-radius: 15px;">
                <div class="modal-header header">
                    <h3 class="modal-title" id="exampleModalLabel" style="float: left; margin-left:28%;">Informações Técnicas</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="font-size: 3rem;">X</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12" style="border-bottom: solid lightgray 1px;">
                            <img src="bib/img/dadosEnt.png" style="width: 4rem; float:left;">
                            <h3 style="font-size:1.8rem; margin-left:1%;margin-top: 1.7%; float:left;">Dados da Entidade</h3>
                        </div>
                        <div class="col-sm-12">
                            <br>
                            <div class="numeracao">1</div>
                            <h5><b>Preencha por favor</b></h5><br>
                            <div class="col-sm-12">
                                <p>Razão Social</p>
                                <input type="text" id="razaoSocial">
                            </div>
                            <div class="col-sm-12">
                                <p>Nome Fantasia</p>
                                <input type="text" id="nomeFantasia">
                            </div>
                            <div class="col-sm-6">
                                <p>CNPJ</p>
                                <input type="text" class="cnpj" id="cnpjEnt">
                            </div>
                            <div class="col-sm-6">
                                <p>Telefone</p>
                                <input type="text" class="telefone" id="telefoneEnt">
                            </div>
                            <div class="col-sm-4">
                                <p>Estado</p>
                                <select style="width: 90%;" id="estadoEnt">
                                    <option value="nd">(UF)</option>
                                    <option value="GO">GO</option>
                                    <option value="MG">MG</option>
                                    <option value="MT">MT</option>
                                    <option value="MS">MS</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <p>Cidade</p>
                                <select style="width: 90%;" id="cidadeEnt">
                                    <option value="nd">Nenhuma</option>
                                    <option value="Caldas Novas">Caldas Novas</option>
                                    <option value="Morrinhos">Morrinhos</option>
                                    <option value="Goiania">Goiania</option>
                                    <option value="Catalão">Catalão</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <p>CEP</p>
                                <input type="text" class="cep" id="cepEnt">
                            </div>
                            <div class="col-sm-12">
                                <p>Endereco</p>
                                <input type="text" id="enderecoEnt">
                                <input type="hidden" id="idLogin" value="<?php echo  $idLogin ?>">
                            </div>
                            <div class="col-sm-12">
                                <input readonly="readonly" id="Entidade" onclick="CadastrarEntidade()" value="Salvar e Finalizar" class="fourth ">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="CadEng" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="width: 50%;">
            <div class="modal-content" style="border-radius: 15px;">
                <div class="modal-header header">
                    <h3 class="modal-title" id="exampleModalLabel" style="float: left; margin-left:28%;">Informações Técnicas</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="font-size: 3rem;">X</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12" style="border-bottom: solid lightgray 1px;">
                            <img src="bib/img/infoTec.png" style="width: 4rem; float:left;">
                            <h3 style="font-size:1.8rem; margin-left:1%;margin-top: 1.7%; float:left;">Dados do Engenheiro</h3>
                        </div>
                        <div class="col-sm-12">
                            <br>
                            <div class="numeracao">1</div>
                            <h5><b>Preencha por favor</b></h5><br>
                            <div class="col-sm-8">
                                <p>Nome</p>
                                <input type="text" id="nomeEng" />
                            </div>
                            <div class="col-sm-4" style="margin-bottom:1%;">
                                <p>CREA número</p>
                                <input type="text" id="CREA" />
                            </div>
                            <div class="col-sm-3">
                                <p>CPF</p>
                                <input type="text" id="cpfEng" class="cpf" />
                            </div>
                            <div class="col-sm-3">
                                <p>Telefone</p>
                                <input type="text" id="telefoneEng" class="telefone" />
                            </div>
                            <div class="col-sm-6">
                                <p>E-mail</p>
                                <input type="text" id="emailEng" />
                            </div>
                            <div class="col-sm-3">
                                <p>Estado</p>
                                <select id="estadoEng">
                                    <option value="nd">(UF)</option>
                                    <option>GO</option>
                                    <option>MG</option>
                                    <option>MT</option>
                                    <option>MS</option>
                                </select>
                            </div>
                            <div class="col-sm-5">
                                <p>Cidade</p>
                                <select id="cidadeEng">
                                    <option value="nd"></option>
                                    <option>Caldas Novas</option>
                                    <option>Morrinhos</option>
                                    <option>Goiania</option>
                                    <option>Catalão</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <p>CEP</p>
                                <input type="text" id="cepEng" class="cep" />
                            </div>
                            <div class="col-sm-12">
                                <p>Endereco</p>
                                <input type="text" id="enderecoEng" />
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <br>
                            <div class="numeracao">2</div>
                            <h5><b>Assinatura</b></h5><br>
                            <div class="col-sm-4">
                                <p>Assinatura digitalizada</p>
                                <label style="width:90%; margin-top:2%; font-size: 13px; border:solid lightblue 1px; color: #808080a8; text-align: center;min-height: 27px">
                                    &nbsp; Arquivo   <img src="bib/img/imagem.png" style="width: 15%;">
                                    <input type="file" accept="image/png, image/jpeg, image/jpg" value="Escolha a imagem" onclick="mostrarImg('01')" id="assinatura">
                                </label>
                            </div>
                            <div class="col-sm-4">
                                <img id="imagemPre01" src="bib/img/rubrica.jpg" style="height: 50px; width:100%">
                            </div>
                            <div class="col-sm-4">
                                <input readonly="readonly" id="btao_relat" onclick="CadastrarEngenheiro()" value="Salvar e Finalizar" class="fourth" style="margin-top:0px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalError" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="width: 30%;">
            <div class="modal-content" style="border-radius: 15px;">
                <div class="modal-header header" style="background-color:red;">
                    <span class="modal-title" id="exampleModalLabel" style="text-align:center;">Erro !!!</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="font-size: 3rem;">X</span>
                    </button>
                </div>
                <div class="modal-body" id="Erro">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" data-backdrop="static" id="sucesso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="width: 30%;">
            <div class="modal-content" style="border-radius: 15px;">
                <div class="modal-header header">
                    <span class="modal-title" id="exampleModalLabel" style="text-align:center;">Sucesso !!!</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" id="VoltarEditUH" style="font-size: 3rem;">X</span>
                    </button>
                </div>
                <div class="modal-body" id="msgSucesso">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditUH" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" id="tamanhoModal">
            <div class="modal-content" style="border-radius: 15px;">
                <div class="modal-header header">
                    <span class="modal-title" id="exampleModalLabel" style="text-align:center;">Edição de UHs</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="font-size: 3rem;">X</span>
                    </button>
                </div>
                <div class="modal-body" id="EditUH">
                </div>
            </div>
        </div>
    </div>
    <!----------------------------------------------------------------------------------------------------------------------------------------------->

    <?php include_once 'bib/comum/rodape.php'; ?>
    <script src="bib/js/menu.js"></script>
    <script src="bib/js/SistemaArCondicionado.js"></script>

</body>

</html>