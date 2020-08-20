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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar</title>
    <link rel="stylesheet" type="text/css" href="bib/css/SistemaArCondicionado.css">
    <?php include_once 'bib/comum/bibi.php'; ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="bib/js/grafico.js"></script>

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
                    <div class="titleDashbord"><span>Dashbord</span></div>
                    <div class="title">Apartamentos</div>
                    <div class="Apartamento">
                        <div class="um">
                            <p>Total</p>
                            <div class="total">100</div>
                        </div>
                        <div class="dois">
                            <p>Completos</p>
                            <div class="completos">30</div>
                        </div>
                        <div class="tres">
                            <p>Incompletos</p>
                            <div class="imcompletos">40</div>
                        </div>
                        <div class="quatro">
                            <p>Não realizado</p>
                            <div class="naorealizados">30</div>
                        </div>
                    </div>
                    <div class="graficoRosca">
                        <div id="donutchart1" style="width: 100%; height: 100%;"></div>
                    </div>
                    <div class="title">Equipamentos (Ar condicionado)</div>
                    <div class="Equipamento">
                        <div class="um">
                            <p>Total</p>
                            <div class="total">100</div>
                        </div>
                        <div class="dois">
                            <p>Completos</p>
                            <div class="completos">30</div>
                        </div>
                        <div class="tres">
                            <p>Incompletos</p>
                            <div class="imcompletos">40</div>
                        </div>
                        <div class="quatro">
                            <p>Não realizado</p>
                            <div class="naorealizados">30</div>
                        </div>
                    </div>
                    <div class="graficoRosca">
                        <div id="donutchart2" style="width: 100%; height: 100%;"></div>
                    </div>

                    <div class="graficoTorres">
                        <div id="chart_div"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="bib/js/menu.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
</body>

</html>