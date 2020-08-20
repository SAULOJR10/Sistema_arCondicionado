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

                            <div class="col-sm-4 button" id="Ordem" style="background-color: white ; height:80%;border: none;" align="center">
                                <i class="fas fa-search" style="font-size: 3rem; float:left; margin-left:10%; margin-top:1%;"></i>
                                <h3 style="font-size: 4rem; margin-top: 0%; margin-right:35%;">Pesquisa</h3>
                                <h3 style="font-size: 4rem; float:right; margin-right:15%; margin-top:-15px;">Predial</h3>
                            </div>

                            <div style="padding-top:1%;" class="col-sm-3 button " id="Ordem" align="center">
                                <h1 style="margin-top: 0%;"><b>425</b></h1>
                                <h3 style="margin-top: 5px; font-size: 1.6rem;" align="center"> UHs gerenciadas</h3>
                            </div>

                            <div style="padding-top:1%;" class="col-sm-3 button" align="center">
                                <h1 style="margin-top: 0%;"><b>425</b></h1>
                                <h3 style="margin-top: 5px; font-size: 1.6rem;" align="center"> Ar cond. gerenciados</h3>
                            </div>
                            <div class="col-sm-12" style="margin-top: 20px;padding:1%; border-bottom:solid lightgray 1px; border-top:solid lightgray 1px;">
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
                                                <input id="ch_Marca" class="switch switch--shadow" type="checkbox" disabled="true">
                                                <label style="float:right; min-width: 40px;" for="ch_Marca"></label>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <p>Modelo</p>
                                        </div>
                                        <div class="col-sm-4">
                                            <div style="padding-right: 0px; padding-left:0px; margin:2% 0% 0% 27%;">
                                                <input id="ch_Modelo" class="switch switch--shadow" type="checkbox" disabled="true">
                                                <label style="float:right; min-width: 40px;" for="ch_Modelo"></label>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <p>Potência</p>
                                        </div>
                                        <div class="col-sm-4">
                                            <div style="padding-right: 0px; padding-left:0px; margin:2% 0% 0% 27%;">
                                                <input id="ch_Potencia" class="switch switch--shadow" type="checkbox" disabled="true">
                                                <label style="float:right; min-width: 40px;" for="ch_Potencia"></label>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <p>Localizacao</p>
                                        </div>
                                        <div class="col-sm-4">
                                            <div style="padding-right: 0px; padding-left:0px; margin:2% 0% 0% 27%;">
                                                <input id="ch_Localizacao" class="switch switch--shadow" type="checkbox" disabled="true">
                                                <label style="float:right; min-width: 40px;" for="ch_Localizacao"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-8" style="height: 50px;"></div>
                                    <div class="col-sm-4">
                                        <input readonly="readonly" id="btao_relat" value="ir" class="fourth " style="height: 20px; font-size:1.2rem;">
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
                                            <input type="text" placeholder="(auto preeenchimento)" class="form-control" style="width: 98%; height:30px;">
                                        </div>
                                    </div>
                                    <div class="col-sm-8" style="height: 50px;"></div>
                                    <div class="col-sm-4">
                                        <input readonly="readonly" id="btao_relat" value="ir" class="fourth " style="height: 20px; font-size:1.2rem;">
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
                                            <input type="text" placeholder="(auto preeenchimento)" class="form-control" style="width: 98%; height:30px;">
                                        </div>
                                    </div>
                                    <div class="col-sm-8" style="height: 50px;"></div>
                                    <div class="col-sm-4">
                                        <input readonly="readonly" id="btao_relat" value="ir" class="fourth " style="height: 20px; font-size:1.2rem;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once 'bib/comum/rodape.php'; ?>
    <script src="bib/js/menu.js"></script>
    <script src="bib/js/Pesquisar.js"></script>

</body>

</html>