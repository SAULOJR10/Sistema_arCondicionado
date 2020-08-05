<?php
include_once "bib/comum/conexao.php";

session_start();
$idLogin = $_SESSION['idUsuario'];

if (isset($_GET['Ent'])) {
    $Entidade = $_GET['Ent'];
} else {
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
    <!-- <link rel="stylesheet" type="text/css" href="bib/css/checkList.css"> -->
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
                        <div class="col-sm-2"></div>
                        <div class="col-sm-8" style="background-color: rgb(243,246,251);">
                            <div class="col-sm-12" style="border-bottom: solid white 5px;">
                                <div class="col-sm-4">
                                    <img src="bib/img/15.png" style="width: 100%; height: 110px;">
                                </div>
                                <div class="col-sm-6">
                                    <h4 style="text-align: center;">Check-List Quinzenal</h4>
                                    <h3 style="text-align: center;">UH: 303</h3>
                                    <img src="bib/img/Engenheiro.png" style="width: 25px; height: 25px; margin: -9px 2px 0px 15%; float: left;">
                                    <p style="float: left;">Antonio Galdinho da Silva</p>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="numeracao">1</div><h5><b>Bandejas</b></h5>
                                <h5 style="margin-top: 30px;"><b>Verificar a operação de drenagem do condensador da bandeja</b></h5>
                                <div class="col-xs-3 " style="float: right; padding-right: 0px; padding-left:0px;">
                                    <input id="ch_UH2" name="allUHS" class="switch switch--shadow" type="checkbox" checked="">
                                    <label style="float:right; min-width: 40px;" for="ch_UH2"></label>
                                </div>
                                <h5>Validado: <span style="color: lightblue;">21/12/2019 - Antonio Galdinho da Silva &nbsp;&nbsp;&nbsp;</span><img src="bib/img/agendaEdit.png" style="width: 25px; margin-top: -10px; height: 25px;"></h5>
                                <h4 style="text-align:center; background-color: white;">Bandeja trocada por uma usada</h4>
                            </div>
                        </div>
                        <div class="col-sm-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once 'bib/comum/rodape.php'; ?>
    <script src="bib/js/menu.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="bib/js/Check-List.js"></script>
</body>

</html>