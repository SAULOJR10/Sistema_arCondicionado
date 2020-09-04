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
    <link rel="stylesheet" type="text/css" href="bib/css/SistemaArCondicionado.css">
    <link rel="stylesheet" type="text/css" href="bib/css/tabelas.css">
</head>

<body class="mybody" style="background-color: white;">
<input type="hidden" id="idLogin" value="<?php echo $idLogin ?>">
    <?php include_once 'bib/comum/menu_bar.php'; ?>
    <div class="row">
        <div class="col-xs-3 infmenuslider inf_alt">
            <?php include_once 'bib/comum/menu.php'; ?>
        </div>
        <div class="col-xs-9 infcorpo inf_alt">
            <div class="limiter">
                <div class="container-table100">
                    <div class="col-sm-12" style="display: inline-block; position: relative; height: 600px; background-repeat: no-repeat; background-size: 100%; color:rgb(0, 0, 128); text-align: center;">
                    <img src="bib/img/rotsprings.jpg" style="width: 100%; height: 100%; filter: brightness(50%);" >
                    <span style="position: absolute; top: 145px; right: 20px; color: white; font-size: 40px; text-shadow: 0px 0px 5px black; padding: 0% 20% 0% 20%;">
                        <h2><b>SEJA MUITO BEM VINDO !!!</b></h2>
                        <h3 style="margin-bottom: 0%;">Este sistema irá automatizar o seu PMOC</h3>
                        <h3 style="margin: 0%;">com varias funcionalidades vamos facilitar a visualização e fiscalização dos equipamentos de seus clientes</h3>
                        <h3><b>InfoSoft Tecnologia e segurança</b></h3>
                        <h5><b>Contato: infosoftTecnologia@gmail.com</b></h5>
                    </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once 'bib/comum/rodape.php'; ?>
    <script src="bib/js/menu.js"></script>
    <script src="bib/js/SistemaArCondicionado.js"></script>

</body>

</html>