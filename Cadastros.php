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
                    <div class="row" style="width: 100%;">
                        <div class="col-sm-12" style="background-color: white; margin-bottom:2%; height:100px; padding:0%;">
                            <div class="col-sm-12 button" id="Ordem" style="margin-bottom: 20px; background-color: white ; height:80%;border: none;" align="center">
                                <h3 style="font-size: 4rem;">
                                    <i class="fas fa-user-plus" style="font-size: 3rem; margin-right: 8px;"></i>
                                    Cadastro de usuário
                                </h3>
                                <hr>
                            </div>
                            <div class="col-sm-12">
                                <div class="col-sm-4">
                                    <div class="numeracao" style="padding-top: 1.5%;">1</div>
                                    <h4 style="margin-bottom: 20px;">Dados usuário:</h4>
                                    <h5 style="margin: 1% 0% 1% 0%;"><b>Tipo de usuário:</b></h5>
                                    <div class="form_group" style="margin-bottom: 10px;">
                                        <select>
                                            <option>Selecione</option>
                                            <option value="adm">Administrador</option>
                                            <option value="eng">Engenheiro</option>
                                            <option value="manutencionista">Manutencionista</option>
                                        </select>
                                        <h6 style="margin: 0%;">Engenheiro deve ser cadastro primeiro</h6>
                                    </div>
                                    <h5 style="margin: 1% 0% 1% 0%;"><b>Usuário:</b></h5>
                                    <div class="form_group" style="margin-bottom: 30px;">
                                        <input type="text" class="form_control">
                                        <h6 style="margin: 0%;"><i>apenas primeiro nome</i></h6>
                                    </div>
                                    <h5 style="margin: 1% 0% 1% 0%;"><b>Senha:</b></h5>
                                    <div class="form_group" style="margin-bottom: 10px;">
                                        <input type="text" class="form_control">
                                    </div>
                                    <h5 style="margin: 1% 0% 1% 0%;"><b>Confirmar senha:</b></h5>
                                    <div class="form_group">
                                        <input type="text" class="form_control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="numeracao">2</div>
                                    <h4>Entidade(s):<h4>
                                    <div class=""></div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="numeracao" style="padding-top: 5%;">3</div>
                                    <h4>Salvar:</h4>
                                    <div style="margin: 20% 0% 0% 20%; width: 40%; border-radius: 50px; text-align: center; background-color: #add8e666;">
                                        <i class="far fa-save" style="font-size: 3.5rem; margin: 20%"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="bib/js/menu.js"></script>
</body>

</html>