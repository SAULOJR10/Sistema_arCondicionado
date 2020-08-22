<?php
include_once "bib/comum/conexao.php";

session_start();
$idLogin = $_SESSION['idUsuario'];
$Entidade = '';

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
</head>

<body class="mybody" style="background-color: white;">
    <?php include_once 'bib/comum/menu_bar.php'; ?>
    <div class="row">
        <div class="col-xs-3 infmenuslider inf_alt">
            <?php include_once 'bib/comum/menu.php'; ?>
        </div>
        <input type="hidden" id="idLogin" value="<?php echo $idLogin ?>">
        <input type="hidden" id="num" value="<?php echo $n1 ?>">
        <span id="nome_cliente" style="display: none;"></span>
        <span id="IDUH"></span>
        <div class="col-xs-9 infcorpo inf_alt">
            <div class="limiter">
                <div class="container-table100">
                    <div class="row">

                        <div class="col-sm-12" style="background-color: white; margin-bottom:2%; height:100px; padding:0%;">

                            <div class="col-sm-12 button" id="Ordem" style="background-color: white ; height:80%;border: none;" align="center">
                                <h3 style="font-size: 4rem;">
                                    <i class="fas fa-map-marker-alt" style="font-size: 3rem; margin-right: 8px;"></i>
                                    Impressão Relatorio
                                </h3>
                            </div>
                            <div class="col-sm-3">
                                <div class="numeracao" style="padding-top: 2.5%; margin-bottom: 20px;">1</div>
                                <h5><b id="TitleSelectEnt"></b></h5>
                                <div id="SelectEnt"></div>
                            </div>
                            <div class="col-sm-3">
                                <div class="numeracao" style="padding-top: 2.5%; margin-bottom: 20px;">2</div>
                                <h5><b id="TitleSelectBloco"></b></h5>
                                <div id="SelectBloco"></div>
                            </div>
                            <div class="col-sm-3">
                                <div class="numeracao" style="padding-top: 2.5%; margin-bottom: 20px;">3</div>
                                <h5><b id="TitleSelectUH"></b></h5>
                                <div id="SelectUH"></div>
                            </div>
                            <div class="col-sm-3">
                                <div class="numeracao" style="padding-top: 2.5%; margin-bottom: 20px;">4</div>
                                <h5><b id="TitleSelectEnt">Enviar:</b></h5>
                                <div id="dv_relat"><input readonly="readonly" id="btao_relat" value="Prosseguir" class="fourth " style="width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once 'bib/comum/rodape.php'; ?>
    <script src="bib/js/menu.js"></script>
    <script src="bib/js/RT.js"></script>
</body>

</html>