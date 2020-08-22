<?php
include_once "bib/comum/conexao.php";

session_start();
$idLogin = $_SESSION['idUsuario'];

if (isset($_GET['Ent'])) {
    $Entidade = $_GET['Ent'];
    if (isset($_GET['idUH'])) {
        $idUH = $_GET['idUH'];
        $idUH = "<input type='hidden' value='$idUH' id='idUH'/>";
    } else {
        $idUH = '';
    }
} else {
    $Entidade = 'Selecione';
    $idUH = '';
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
    <?php include_once 'bib/comum/bibi.php'; ?>
    <link rel="stylesheet" type="text/css" href="bib/css/tabelas.css">
    <link rel="stylesheet" type="text/css" href="bib/css/RT.css">
</head>

<body style="background-color: white;">
    <input type="hidden" id="idLogin" value="<?php echo $idLogin ?>">
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10" id="colocarRT">
            <span id="nome_cliente" style="display: none;"><?php echo $Entidade ?></span>
            <span id="IDUH"><?php echo $idUH ?></span>
        </div>
        <div class="col-sm-1"></div>
    </div>
    <script src="bib/js/menu.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="bib/js/RT.js"></script>
</body>

</html>