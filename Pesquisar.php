<?php
include_once "bib/comum/conexao.php";

session_start();
$idLogin = $_SESSION['idUsuario'];

if (isset($_GET['Ent'])) {
    $Entidade = $_GET['Ent'];
    if (isset($_GET['idUH'])) {
        $idUH = $_GET['idUH'];
        $idUH = "<input type='hidden' value='$idUH' id='idUH'/>";
        if (isset($_GET['idAr'])) {
            $idAr = $_GET['idAr'];
            $idAr = "<input type='hidden' value='$idAr' id='idAr'/>";
        } else {
            $idAr = '';
        }
    } else {
        $idUH = '';
        $idAr = '';
    }
} else {
    $Entidade = 'Selecione';
    $idUH = '';
    $idAr = '';
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
    <link rel="stylesheet" type="text/css" href="bib/css/administracao.css">
    <link rel="stylesheet" type="text/css" href="bib/css/Pesquisar.css">
    <link rel="stylesheet" type="text/css" href="bib/css/tabelas.css">
</head>

<body class="mybody" style="background-color: white;">
    <input type="hidden" id="idLogin" value="<?php echo $idLogin ?>">
    <?php include_once 'bib/comum/menu_bar.php'; ?>
    <div class="row">
        <div class="col-xs-3 infmenuslider inf_alt">
            <?php include_once 'bib/comum/menu.php'; ?>
        </div>
        <div class="col-xs-9 infcorpo inf_alt" style="overflow: visible;">
            <div class="limiter">
                <div class="container-table100">
                    <div class="row">

                        <div class="col-sm-12" style="background-color: white; height:88px; padding:0%;">

                            <div class="col-sm-12 button" id="Ordem" style="background-color: white; height:80%;border: none; margin: 0%;" align="center">
                                <h3 style="font-size: 4rem; margin: 0%;"><i class="fas fa-search" style="font-size: 3rem; margin-top:1%;"></i>&nbsp;&nbsp;Pesquisa Predial</h3>
                            </div>
                            <div class="col-sm-12" style="margin-top: 20px;padding:1%; border-top:solid lightgray 1px;">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <img src="bib/img/Pesquisa.jpg" style="float: left; width:80px; height:80px;">
                                        <h2>Escolha tipo de pesquisa</h2>
                                    </div>
                                    <div class="col-sm-4 divs">
                                        <div class="col-sm-8" style="padding: 0%;">
                                            <div class="numeracao" style="padding-top: 2%;">1</div>
                                            <h5 style="margin-top: 5%; float:left;"><b>Ar Condicionado</b></h5>
                                        </div>
                                        <div class="col-sm-4">
                                            <div style="padding-right: 0px; padding-left:0px; margin:2% 0% 0% 16%;">
                                                <input id="ch_ArCond" class="switch switch--shadow" type="checkbox" onclick="SoUm('ch_Arcond')">
                                                <label style="float:right; min-width: 40px;" for="ch_ArCond"></label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 opaco" style="margin-top:15px;; opacity:0.5;">
                                            <div class="col-sm-8">
                                                <p>Marca</p>
                                            </div>
                                            <div class="col-sm-4">
                                                <div style="padding-right: 0px; padding-left:0px; margin:2% 0% 0% 27%;">
                                                    <input id="ch_Marca" name="AR" class="switch switch--shadow" type="checkbox" disabled="true">
                                                    <label style="float:right; min-width: 40px;" for="ch_Marca"></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-8">
                                                <p>Modelo</p>
                                            </div>
                                            <div class="col-sm-4">
                                                <div style="padding-right: 0px; padding-left:0px; margin:2% 0% 0% 27%;">
                                                    <input id="ch_Modelo" name="AR" class="switch switch--shadow" type="checkbox" disabled="true">
                                                    <label style="float:right; min-width: 40px;" for="ch_Modelo"></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-8">
                                                <p>Potência</p>
                                            </div>
                                            <div class="col-sm-4">
                                                <div style="padding-right: 0px; padding-left:0px; margin:2% 0% 0% 27%;">
                                                    <input id="ch_Potencia" name="AR" class="switch switch--shadow" type="checkbox" disabled="true">
                                                    <label style="float:right; min-width: 40px;" for="ch_Potencia"></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-8">
                                                <p>Localizacao</p>
                                            </div>
                                            <div class="col-sm-4">
                                                <div style="padding-right: 0px; padding-left:0px; margin:2% 0% 0% 27%;">
                                                    <input id="ch_Localizacao" name="AR" class="switch switch--shadow" type="checkbox" disabled="true">
                                                    <label style="float:right; min-width: 40px;" for="ch_Localizacao"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-8" style="height: 50px;"></div>
                                        <div class="col-sm-4">
                                            <input readonly="readonly" onclick="PesquisarAr()" id="Ar" value="ir" class="fourth " style="height: 20px; font-size:1.2rem;">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 divs">
                                        <div class="col-sm-8" style="padding: 0%;">
                                            <div class="numeracao" style="padding-top: 2%;">2</div>
                                            <h5 style="margin-top: 5%; float:left;"><b>Proprietário</b></h5>
                                        </div>
                                        <div class="col-sm-4">
                                            <div style="padding-right: 0px; padding-left:0px; margin:2% 0% 0% 27%;">
                                                <input id="ch_Prop" class="switch switch--shadow" type="checkbox" onclick="SoUm('ch_Prop')">
                                                <label style="float:right; min-width: 40px;" for="ch_Prop"></label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12" style="margin-top:15px">
                                            <p>Nome</p>
                                            <div class="form-group">
                                                <input type="text" id="Prop" onkeyup="AutoComplete()" placeholder="(auto preeenchimento)" class="form-control" style="width: 98%; height:30px;" disabled>
                                            </div>
                                        </div>
                                        <div class="col-sm-8" style="height: 50px;"></div>
                                        <div class="col-sm-4">
                                            <input readonly="readonly" id="pesquisarProp" onclick="Pesquisar('Prop')" value="ir" class="fourth " style="height: 20px; font-size:1.2rem;">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 divs">
                                        <div class="col-sm-8" style="padding: 0%;">
                                            <div class="numeracao" style="padding-top: 2%;">3</div>
                                            <h5 style="margin-top: 5%; float:left;"><b>UH</b></h5>
                                        </div>
                                        <div class="col-sm-4">
                                            <div style="padding-right: 0px; padding-left:0px; margin:2% 0% 0% 27%;">
                                                <input id="ch_UH" class="switch switch--shadow" type="checkbox" onclick="SoUm('ch_UH')">
                                                <label style="float:right; min-width: 40px;" for="ch_UH"></label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12" style="margin-top:15px">
                                            <span id="SelectBloco">
                                                <p>Selecione Bloco:</p><select class='form-control' style='opacity: 0.5; border-radius:5px; width: 100%; margin-bottom: 10px;' disabled>
                                                    <option>Bloco A</option>
                                                </select>
                                            </span>
                                            <span id="SelectUH">
                                                <p>Selecione UH:</p><select class='form-control' style='opacity: 0.5; border-radius:5px; width: 100%;' disabled>
                                                    <option>101</option>
                                                </select>
                                            </span>
                                        </div>
                                        <div class="col-sm-8" style="height: 50px;"></div>
                                        <div class="col-sm-4">
                                            <input readonly="readonly" id="pesquisarUH" value="ir" class="fourth " style="height: 20px; font-size:1.2rem;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12" style="height:300px; text-align: center;">
                                    <h3 id="titulo" style="display: none;"><b><u>Resultados:</b></u></h3>
                                    <div class="col-sm-3" id="titulomarca" style="visibility: hidden"><b>Marca:</b></div>
                                    <div class="col-sm-3" id="titulomodelo" style="visibility: hidden"><b>Modelo:</b></div>
                                    <div class="col-sm-3" id="titulopotencia" style="visibility: hidden"><b>Potência:</b></div>
                                    <div class="col-sm-3" id="titulolocalizacao" style="visibility: hidden"><b>Localização:</b></div>
                                    <div class="col-sm-3" style="height: 100%;" id="graficosmarca"></div>
                                    <div class="col-sm-3" style="height: 100%;" id="graficosmodelo"></div>
                                    <div class="col-sm-3" style="height: 100%;" id="graficospotencia"></div>
                                    <div class="col-sm-3" style="height: 100%;" id="graficoslocalizacao"></div>
                                    <input type="text" style="visibility: hidden;" id="focus">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-------------------------------------------------------------Modais-------------------------------------------------------->
    <div class="modal fade" id="resultadosModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style=" overflow:auto;">
        <div class="modal-dialog" role="document" style="width: 50%;">
            <div class="modal-content" style="border-radius: 15px;">
                <div class="modal-header header">
                    <h3 class="modal-title" id="exampleModalLabel" style="float: left; margin-left:30%;">Resultado da pesquisa</h3>
                    <button type="button" class="close" onclick="limparModal()" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="font-size: 3rem;">X</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="resultPesq"></span>
                </div>
            </div>
        </div>
    </div>
    <!---------------------------------------------------------------------------------------------------------------------------->

    <script src="bib/js/menu.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="bib/js/Pesquisar.js"></script>

</body>

</html>