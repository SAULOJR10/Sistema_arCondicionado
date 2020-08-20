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
    <link rel="stylesheet" type="text/css" href="bib/css/tabelas.css">
</head>

<body class="mybody" style="background-color: white;">
    <?php include_once 'bib/comum/menu_bar.php'; ?>
    <div class="row">
        <div class="col-xs-3 infmenuslider inf_alt" style="overflow-y: visible;">
            <?php include_once 'bib/comum/menu.php'; ?>
        </div>
        <input type="hidden" id="idLogin" value="<?php echo $idLogin ?>">
        <div class="col-xs-9 infcorpo inf_alt" style="overflow-y: visible;">
            <div class="limiter">
                <div class="container-table100">
                    <div class="row">
                        <div class="col-sm-12" style="background-color: white; margin-bottom:2%; height:100px; padding:0%;">
                            <div id="TodosCheck">
                                <div class="col-sm-12 button" id="Ordem" style="background-color: white ; height:80px;border: none; text-align:center;" align="center">
                                    <h3 style="font-size: 3rem; margin-top: 1%;"><i class="fas fa-map-marker-alt" style="font-size: 3rem; margin-top:1%;"></i> &nbsp;&nbsp;&nbsp;Check-List Ar Condicionado</h3>
                                </div>

                                <div style="background-color: rgb(243,246,251); padding-top:1%; border-right: solid white 10px;" class="col-sm-3 button " id="Ordem" align="center">
                                    <img onclick="CheckList('Quinzenal')" src="bib/img/Quinzenal.png" style="width: 40%; height: 60px;">
                                    <p style="margin-bottom:2px; margin-top: 5px; font-size: 1.6rem;" align="center"> Check-List quinzenal</p>
                                    <p style="color: black;"><b class="Blocos">Bloco A </b></p>
                                    <p style="color: black; margin-top: 1%;"><b class="UHs">UH: 101</b></p>
                                    <span id="IDUH"><?php echo $idUH ?></span>
                                    <div class="col-sm-12" style="border: solid white 5px; margin-bottom: 5px;">
                                        <h5>Iniciado: <b style="color:red;" id="dataQuinzenal"></b></h5>
                                        <h5>Status: <b style="color: red;" id="statusQuinzenal"></b></h5>
                                    </div>
                                    <div class="col-sm-12" style="padding:0%; border: solid white 5px; margin-bottom: 5px;">
                                        <span id="tituloQuinzenal"></span>
                                        <div id="donutchart1" style="width:100%; height:200px; background-color: rgb(243,246,251);"></div>
                                    </div>
                                </div>
                                <div style="background-color: rgb(243,246,251); padding-top:1%; border-right: solid white 10px;" class="col-sm-3 button" align="center">
                                    <img onclick="CheckList('Mensal')" src="bib/img/Mensal.png" style="width: 40%; height: 60px;">
                                    <p style="margin-bottom:2px; margin-top: 5px; font-size: 1.6rem;" align="center"> Check-List mesal</p>
                                    <p style="color: black;"><b class="Blocos">Bloco A </b></p>
                                    <p style="color: black; margin-top: 1%;"><b class="UHs">UH: 101</b></p>
                                    <div class="col-sm-12" style="border: solid white 5px; margin-bottom: 5px;">
                                        <h5>Iniciado: <b style="color:red;" id="dataMensal"></b></h5>
                                        <h5>Status: <b style="color: red;" id="statusMensal"></b></h5>
                                    </div>
                                    <div class="col-sm-12" style="padding:0%; border: solid white 5px; margin-bottom: 5px;">
                                        <span id="tituloMensal"></span>
                                        <div id="donutchart2" style="width:100%; height:200px; background-color: rgb(243,246,251);"></div>
                                    </div>
                                </div>

                                <div style="background-color: rgb(243,246,251); padding-top:1%; border-right: solid white 10px;" class="col-sm-3 button" align="center">
                                    <img onclick="CheckList('Trimestral')" src="bib/img/Trimestral.png" style="width: 40%; height: 60px;">
                                    <p style="margin-bottom:2px; margin-top: 5px; font-size: 1.6rem;" align="center"> Check-List trimestral</p>
                                    <p style="color: black;"><b class="Blocos">Bloco A </b></p>
                                    <p style="color: black; margin-top: 1%;"><b class="UHs">UH: 101</b></p>
                                    <div class="col-sm-12" style="border: solid white 5px; margin-bottom: 5px;">
                                        <h5>Iniciado: <b style="color:red;" id="dataTrimestral"></b></h5>
                                        <h5>Status: <b style="color: red;" id="statusTrimestral"></b></h5>
                                    </div>
                                    <div class="col-sm-12" style="padding:0%; border: solid white 5px; margin-bottom: 5px;">
                                        <span id="tituloTrimestral"></span>
                                        <div id="donutchart3" style="width:100%; height:200px; background-color: rgb(243,246,251);"></div>
                                    </div>
                                </div>

                                <div style="background-color: rgb(243,246,251); padding-top:1%; border-right: solid white 10px;" class="col-sm-3 button" align="center">
                                    <img onclick="CheckList('Anual')" src="bib/img/Anual.png" style="width: 40%; height: 60px;">
                                    <p style="margin-bottom:2px; margin-top: 5px; font-size: 1.6rem;" align="center"> Check-List anual</p>
                                    <p style="color: black;"><b class="Blocos">Bloco A </b></p>
                                    <p style="color: black; margin-top: 1%;"><b class="UHs">UH: 101</b></p>
                                    <div class="col-sm-12" style="border: solid white 5px; margin-bottom: 5px;">
                                        <h5>Iniciado: <b style="color:red;" id="dataAnual"></b></h5>
                                        <h5>Status: <b style="color: red;" id="statusAnual"></b></h5>
                                    </div>
                                    <div class="col-sm-12" style="padding:0%; border: solid white 5px; margin-bottom: 5px;">
                                        <span id="tituloAnual"></span>
                                        <div id="donutchart4" style="width:100%; height:200px; background-color: rgb(243,246,251);"></div>
                                    </div>
                                </div>
                            </div>
                            <span id="ColocarAr"><?php echo $idAr ?></span>
                            <div class="col-sm-12" id="checklist">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!----------------------------------------------------------------Modal-------------------------------------------------------------------------->
    <div class="modal fade" id="CheckList" data-backdrop='static' tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style=" overflow:auto;">
        <div class="modal-dialog" role="document" style="width: 40%;">
            <div class="modal-content" style="border-radius: 15px;">
                <div class="modal-header header">
                    <h3 class="modal-title" id="exampleModalLabel" style="float: left; margin-left:35%;">Check Lists</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-6">
                            <div id="SelectEnt"></div>
                            <div id="SelectBloco"></div>
                            <div id="SelectAndar"></div>
                            <div id="SelectUH"></div>
                            <div id="SelectAr"></div>
                        </div>
                        <div class="col-sm-3"></div>
                    </div>
                    <div class="footer">
                        <div id="dv_relat"><input readonly="readonly" id="btao_relat" value="Prosseguir" class="fourth " style="width: 40%; float:right;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="agendar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style=" overflow:auto;">
        <div class="modal-dialog" role="document" style="width: 40%;">
            <div class="modal-content" style="border-radius: 15px;">
                <div class="modal-header header">
                    <h3 class="modal-title" id="exampleModalLabel" style="float: left; margin-left:45%;">Aviso</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-6">
                            <h4>Agendar aviso para o dia:</h4>
                            <input type="date" id="dataAgend" style="width: 100%;">
                            <h4>Observação:</h4>
                            <input type="text" id="observacao" style="width: 100%;">
                        </div>
                        <div class="col-sm-3"></div>
                    </div>
                    <div class="footer">
                        <div id="dv_relat"><input readonly="readonly" onclick="Avisar()" id="btao_relat" value="Prosseguir" class="fourth " style="width: 40%; float:right;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!----------------------------------------------------------------------------------------------------------------------------------------------->
    <script src="bib/js/menu.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="bib/js/Check-List.js"></script>
</body>

</html>