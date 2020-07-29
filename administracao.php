<?php
include_once "bib/comum/conexao.php";

session_start();
$idLogin = $_SESSION['idUsuario'];

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
    <link rel="stylesheet" type="text/css" href="bib/css/administracao.css">
    <link rel="stylesheet" type="text/css" href="bib/css/tabelas.css">
</head>

<body class="mybody" style="background-color: white;">
    <?php include_once 'bib/comum/menu_bar.php'; ?>
    <div class="row">
        <div class="col-xs-3 infmenuslider inf_alt">
            <?php include_once 'bib/comum/menu.php'; ?>
        </div>
        <input type="hidden" id="idLogin" value="<?php echo $idLogin ?>">
        <div class="col-xs-9 infcorpo inf_alt">
            <div class="limiter">
                <div class="container-table100">
                    <div class="row">

                        <div class="col-sm-12" style="background-color: white; margin-bottom:2%; height:100px; padding:0%;">

                            <div class="col-sm-4 button" id="Ordem" style="background-color: white ; height:80%;border: none;" align="center">
                                <i class="fas fa-map-marker-alt" style="font-size: 3rem; float:left; margin-left:10%; margin-top:1%;"></i>
                                <h3 style="font-size: 4rem; margin-top: 0%; margin-right:35%;">Gerência</h3>
                                <h3 style="font-size: 4rem; float:right; margin-right:15%; margin-top:-15px;">Predial</h3>
                            </div>

                            <div style="padding-top:1%;" class="col-sm-2 button " id="Ordem" align="center">
                                <h1 style="margin-top: 0%;"><b id="UHGer">0</b></h1>
                                <h3 style="margin-top: 5px; font-size: 1.6rem;" align="center"> UHs gerenciadas</h3>
                            </div>

                            <div style="padding-top:1%;" class="col-sm-2 button" align="center">
                                <h1 style="margin-top: 0%;"><b id="ARGer">0</b></h1>
                                <h3 style="margin-top: 5px; font-size: 1.6rem;" align="center"> Ar cond. gerenciados</h3>
                            </div>

                            <div style="padding-top:1%;" class="col-sm-2 button" align="center">
                                <h1 style="margin-top: 0%;"><b id="SalaGer">0</b></h1>
                                <h3 style="margin-top: 5px; font-size: 1.6rem;" align="center"> Salas gerenciadas</h3>
                            </div>

                            <div onclick="SelectBlocosGer()" class="col-sm-2 button mais" style="border:none;">
                                <i class="fas fa-cogs" style="font-size: 3rem; float:left; margin:5% 40% 10% 40%;"></i>
                                <h3 style="font-size: 1.6rem;margin-top:0%;">Gerenciar</h3>
                            </div>

                            <div class="ger" style="display: none; background-color: white; width:100%;">
                                <div class="row">
                                    <div class="col-sm-12 gerenciar" style="padding:0%; padding-left:2%;">
                                        <h4><b>Gerenciando</b></h4>
                                    </div>
                                </div>
                                <div class="row gerenciar" style="margin-bottom:10px;">
                                    <div class="col-sm-3">
                                        <div class="numeracao" style="padding-top: 2.5%;">1</div>
                                        <h5 style="margin-top: 5%;"><b>Escolha bloco</b></h5>
                                        <div class="col-sm-12" style="padding-top:8%; padding-left:0%;">
                                            <h5 style="margin: 0%;">Bloco:</h5>
                                            <select id="blocoGer" onchange="SelectAndarGer()" style="height:30px; border:solid lightgray 1px; width:100%; margin-top:2.2%;">
                                            </select>
                                        </div>
                                        <div class="col-sm-12" style="padding-top:8%; padding-left:0%;" id="colocarAndar">

                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="numeracao">2</div>
                                        <h5 style="margin-top: 1.7%;"><b>Escolha as UH(s) e cadastre suas informações</b></h5>
                                        <h5 style="margin-top: 4%;"><b id="QualAndar"></b></h5>
                                        <div id="gerenciamento"></div>
                                    </div>
                                    <div class="col-sm-1" style="background-color:white;" onclick="Gerenciadas()">
                                        <h5 style="margin-top: 25%;margin-bottom: 6%; margin-left:11%;"><b>Gravar</b></h5>
                                        <i class="far fa-save" style="font-size: 3.5rem;margin-left:22.5%; margin-bottom:25%;"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12" style="margin-top:20px;padding:0%;" id="Corpo">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!----------------------------------------------------------------Modal-------------------------------------------------------------------------->
    <div class="modal fade" id="CadProp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="width: 50%;">
            <div class="modal-content" style="border-radius: 15px;">
                <div class="modal-header header">
                    <h3 class="modal-title" id="exampleModalLabel" style="float: left; margin-left:28%;">Cadastro de propriedade</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="font-size: 3rem;">X</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12" style="border-bottom: solid lightgray 1px;">
                            <img src="bib/img/infoTec.png" style="width: 4rem; float:left;">
                            <h3 style="font-size:1.8rem; margin-left:1%;margin-top: 1.7%; float:left;">Dados do Proprietário</h3>
                            <div id="QualUH">
                            </div>
                            <div id="ColocarAbrir2">
                                <img src="bib/img/Seta.png" style="width: 3rem; float:right;margin-top: 0.8%;">
                                <h3 style="font-size:1.8rem; margin-left:8%;margin-top: 1.7%; float:right; margin-bottom:20px;"><b>1° PASSO</b></h3>
                            </div>
                        </div>
                        <div class="col-sm-12" style="margin-bottom: 15px;">
                            <div class="numeracao" style="margin-top: 2%;">1</div>
                            <h5 style="margin-top: 3.5%; float:left;"><b>Cadastro de Propriedade</b></h5>
                            <div class="col-xs-1 " style="padding-right: 0px; padding-left:0px; margin:3% 0% 0% 0%;">
                                <input id="ch_cad" onchange="aparecer('desabledPessoa', 'opaco', 'cad')" class="switch switch--shadow" type="checkbox">
                                <label style="float:right; min-width: 40px;" for="ch_cad"></label>
                            </div>
                        </div>
                        <div class="opaco" style="opacity:0.5;">
                            <div class="col-sm-5" style="margin-left: 40px;">
                                <span><b>Proprietário Único</b></span>
                                <input class="desabledPessoa" id="tipo_Prop1" disabled="true" onchange="aparecer('sumir','aparecer', 'cad')" type="radio" value="Unica" name="propriedade">
                            </div>
                            <div class="col-sm-6">
                                <span><b>Propriedade de Cotas</b></span>
                                <input class="desabledPessoa" id="tipo_Prop2" disabled="true" onchange="aparecer('sumir','aparecer', 'cad')" type="radio" value="Cotas" name="propriedade">
                            </div>
                        </div>
                        <div class="sumir" style="display: none;">
                            <div class="col-sm-12" style="margin-bottom: 15px;">
                                <div class="numeracao" style="margin-top: 2%;">2</div>
                                <h5 style="margin-top: 3.5%; float:left;"><b>Proprietario da UH <span id="UH"></span></b></h5>
                            </div>
                            <div class="col-sm-6">
                                <span style="float: left;">Pessoa fisica</span>
                                <div class="col-xs-2 " style="padding-right: 0px; padding-left:0px; margin:0% 0% 0% 0%;">
                                    <input id="ch_fisica" value="Fisica" class="switch switch--shadow" onchange="SoUm('ch_fisica')" type="checkbox">
                                    <label style="float:right; min-width: 40px;" for="ch_fisica"></label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <span style="float: left;">Pessoa juridica</span>
                                <div class="col-xs-2 " style="padding-right: 0px; padding-left:0px; margin:0% 0% 0% 0%;">
                                    <input id="ch_juridica" value="Juridica" class="switch switch--shadow" onchange="SoUm('ch_juridica')" type="checkbox">
                                    <label style="float:right; min-width: 40px;" for="ch_juridica"></label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="text" name="nomeProp" id="nomeProp" placeholder="Insira o nome..." class="form-control" style="width: 98%; height:30px;">
                                    <i class="fas fa-user-plus" id="ColocarAparecer" style="font-size: 2.5rem; margin-left:2%"></i>
                                    <i class="fas fa-check-circle" style="font-size: 2.5rem; margin-left:2%"></i>
                                </div>
                            </div>
                        </div>
                        <div class="Edit" style="display: none;">
                            <div id="documento">
                            </div>
                            <div class="col-sm-4">
                                <p>Telefone</p>
                                <div class="form-group">
                                    <input type="text" id="telefoneProp" placeholder="(77) 77777-7777" class="form-control" style="width: 98%; height:30px;">
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <p>Email</p>
                                <div class="form-group">
                                    <input type="text" id="emailProp" placeholder="...@gmail.com" class="form-control" style="width: 98%; height:30px;">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <p>Cep</p>
                                <div class="form-group">
                                    <input type="text" id="CEPProp" placeholder="77777-777" class="form-control" style="width: 98%; height:30px;">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <p>Estado</p>
                                <div class="form-group">
                                    <select class="form-control" id="EstadoProp" style="color: #444444; width:98%">
                                        <option value="" id="selecioneEst">Selecione</option>
                                        <option value="GO">GO</option>
                                        <option value="MG">MG</option>
                                        <option value="RJ">RJ</option>
                                        <option value="SP">SP</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <p>Cidade</p>
                                <div class="form-group">
                                    <select class="form-control" id="CidadeProp" style="color: #444444; width:98%">
                                        <option value="" id="selecioneCity">Selecione</option>
                                        <option value="Caldas Novas">Caldas Novas</option>
                                        <option value="Araguari">Araguari</option>
                                        <option value="Rio de Janeiro">Rio de Janeiro</option>
                                        <option value="São Paulo">São Paulo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <p>Endereco</p>
                                <div class="form-group">
                                    <input type="text" placeholder="Rua xx Quadra xx Lote xx Setor xx" class="form-control" id="enderecoProp" style="width: 98%; height:30px;">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="footer">
                        <div id="dv_relat"><input readonly="readonly" onclick="ADDProp()" value="Gravar e Prosseguir" class="fourth " style="width: 40%; float:right;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="CadProp2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style=" overflow:auto;">
        <div class="modal-dialog" role="document" style="width: 50%;">
            <div class="modal-content" style="border-radius: 15px;">
                <div class="modal-header header">
                    <h3 class="modal-title" id="exampleModalLabel" style="float: left; margin-left:28%;">Cadastro de propriedade</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="font-size: 3rem;">X</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12" style="border-bottom: solid lightgray 1px;">
                            <img src="bib/img/arcondicionado.png" style="width: 4rem; float:left;">
                            <h3 style="font-size:1.8rem; margin-left:1%;margin-top: 1.7%; float:left;">Dados do Ar Condicionado</h3>
                            <div id="QualUHAr"></div>
                            <div onclick="AbrirModal('CadProp', 'CadProp2')">
                                <h3 style="font-size:1.8rem; margin-left:1%;margin-top: 1.7%; float:right; margin-bottom:20px;"><b>2° PASSO</b></h3>
                                <img src="bib/img/Seta2.png" style="width: 3rem; float:right;margin-top: 0.8%;">
                            </div>
                        </div>
                        <div class="col-sm-12" style="margin-bottom: 15px;">
                            <div class="numeracao" style="margin-top: 2%;">1</div>
                            <h5 style="margin-top: 3.5%; float:left;"><b>Dados do Ar Condicionado</b></h5>
                            <div class="col-sm-11" style="margin-left:30px; border-bottom:solid green 1px; padding:0%;">
                                <p>Quantidade:</p>
                                <input onkeyup="quantAr()" id="quantAr" type="number" style="margin-bottom:10px;" />
                            </div>
                            <div class="col-sm-11" style="margin-left:30px; padding:0%;" id="ArCond">
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <div id="dv_relat"><input readonly="readonly" onclick="ADDAR()" id="btao_relat" value="Gravar e Prosseguir" class="fourth " style="width: 40%; float:right;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="Edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style=" overflow:auto;">
        <div class="modal-dialog" role="document" style="width: 40%;">
            <div class="modal-content" style="border-radius: 15px;">
                <div class="modal-header header">
                    <h3 class="modal-title" id="exampleModalLabel" style="float: left; margin-left:28%;">Cadastro de propriedade</h3>
                    <button type="button" class="close" onclick="AbrirModal('CadProp2','Edit')" aria-label="Close">
                        <span aria-hidden="true" style="font-size: 3rem;">X</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12" style="border-bottom: solid lightgray 1px;">
                            <img src="bib/img/arcondicionado.png" style="width: 4rem; float:left;">
                            <h3 style="font-size:1.8rem; margin-left:1%;margin-top: 1.7%; float:left;">Dados do Ar Condicionado</h3>
                        </div>
                        <div class="col-sm-12" style="margin-bottom: 15px;">
                            <div class="numeracao" style="margin-top: 2%;">1</div>
                            <h5 style="margin-top: 3.5%;"><b>Gerenciar <span class="dadoAr"></span></b></h5>
                            <div class="col-sm-12" style="margin-top:20px;">
                                <p><b>Inserir:</b></p>
                                <input type="text" style="width:38%;" />
                                <i class="fas fa-check" style="color: green; font-size:2rem; margin-left:5%;"></i>
                            </div>
                            <div class="col-sm-12" style="margin-top:20px;">
                                <p><b>Editar:</b></p>
                            </div>
                            <div id="EditDadosAr">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <div id="dv_relat"><input readonly="readonly" id="btao_relat" value="ok" class="fourth " style="width: 40%; margin:0 auto; margin-top:2%"></div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!----------------------------------------------------------------------------------------------------------------------------------------------->
    <?php include_once 'bib/comum/rodape.php'; ?>
    <script src="bib/js/menu.js"></script>
    <script src="bib/js/administracao.js"></script>
    <script>
        $(function() {
            $('#nomeProp').autocomplete({
                source: 'bib/ajax/AutoComplete.php'
            });
        });
    </script>
</body>

</html>