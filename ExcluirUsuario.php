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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar</title>
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
                    <div class="row">
                        <div class="col-sm-12 button" id="Ordem" style="margin-bottom: 20px; background-color: white ; height:80%;border: none;" align="center">
                            <h3 style="font-size: 4rem;">
                                <i class="fas fa-user-times" style="font-size: 3rem; margin-right: 8px;"></i>
                                Excluir usuários
                            </h3>
                            <hr>
                        </div>
                    </div>
                    <table id="demo-table">

                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="Avisos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style=" overflow:auto;">
        <div class="modal-dialog" role="document" style="width: 40%;">
            <div class="modal-content" style="border-radius: 15px;">
                <div class="modal-header header" id="cor" style="background-color: green;">
                    <h3 class="modal-title" id="tituloModal" style="text-align:center;">Sucesso !!!</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-6">
                            <div id="MSG"></div>
                        </div>
                        <div class="col-sm-3"></div>
                    </div>
                    <div class="footer">
                        <div id="dv_relat"><input data-dismiss="modal" onclick="window.location.reload()" readonly="readonly" id="btao_relat" value="ok" class="fourth " style="width: 40%; float:right;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="bib/js/menu.js"></script>
    <script src="bib/js/Excluir.js"></script>
</body>

</html>