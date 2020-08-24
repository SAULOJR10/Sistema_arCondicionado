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
    <?php include_once 'bib/comum/menu_bar.php'; ?>
    <div class="row">
        <div class="col-xs-3 infmenuslider inf_alt">
            <?php include_once 'bib/comum/menu.php'; ?>
        </div>
        <div class="col-xs-9 infcorpo inf_alt">
            <div class="limiter">
                <div class="container-table100">
                    <div class="row">

                        <div class="col-sm-12" style="background-color: white; margin-bottom:2%; height:100px; padding:0%;">

                            <div class="col-sm-12 button" id="Ordem" style="background-color: white; height:80%;border: none;" align="center">
                                <h3 style="font-size: 4rem; margin-top: 0%;"><i class="fas fa-search" style="font-size: 3rem; margin-top:1%;"></i>&nbsp;&nbsp;Pesquisa Predial</h3>
                            </div>
                            <div class="col-sm-12" style="margin-top: 20px;padding:1%; border-bottom:solid lightgray 1px; border-top:solid lightgray 1px;">
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
                                            <input type="text" id="Prop" placeholder="(auto preeenchimento)" class="form-control" style="width: 98%; height:30px;">
                                        </div>
                                    </div>
                                    <div class="col-sm-8" style="height: 50px;"></div>
                                    <div class="col-sm-4">
                                        <input readonly="readonly" id="btao_relat" onclick="Pesquisar('Prop')" value="ir" class="fourth " style="height: 20px; font-size:1.2rem;">
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
                                        <p>Preencha</p>
                                        <div class="form-group">
                                            <input type="text" id="UH" placeholder="(auto preeenchimento)" class="form-control" style="width: 98%; height:30px;">
                                        </div>
                                    </div>
                                    <div class="col-sm-8" style="height: 50px;"></div>
                                    <div class="col-sm-4">
                                        <input readonly="readonly" id="btao_relat" onclick="Pesquisar('UH')" value="ir" class="fourth " style="height: 20px; font-size:1.2rem;">
                                    </div>
                                </div>
                            </div>
                                <div class="col-sm-2"></div>
                                <div class="col-sm-8" id="graficos" style="height:300px; text-align: center;">
                                    <h4 id="titulo" style="display: none;">Resultados:</h4>
                                </div>
                                <div class="col-sm-2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once 'bib/comum/rodape.php'; ?>
    <script src="bib/js/menu.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="bib/js/Pesquisar.js"></script>

</body>

</html>