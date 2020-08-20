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
            <span id="IDUH"></span>
        </div>
        <div class="col-sm-1"></div>
    </div>
    <!----------------------------------------------------------------Modal-------------------------------------------------------------------------->
    <div class="modal fade" id="Selecao" data-backdrop='static' tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style=" overflow:auto;">
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
    <!----------------------------------------------------------------------------------------------------------------------------------------------->
    <script src="bib/js/menu.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="bib/js/RT.js"></script>
</body>

</html>