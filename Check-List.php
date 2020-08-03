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

                        <div class="col-sm-12" style="background-color: white; margin-bottom:2%; height:100px; padding:0%;">

                            <div class="col-sm-12 button" id="Ordem" style="background-color: white ; height:80%;border: none;" align="center">
                                <i class="fas fa-map-marker-alt" style="font-size: 3rem; float:left; margin-left:20%; margin-top:1%;"></i>
                                <h3 style="font-size: 3rem; margin-top: 1%; margin-right:35%;">Check-List Ar Condicionado</h3>
                            </div>

                            <div style="background-color: rgb(243,246,251); padding-top:1%; border-right: solid white 10px;" class="col-sm-3 button " id="Ordem" align="center">
                                <img src="bib/img/15.png" style="width: 40%; height: 60px;">
                                <p style="margin-bottom:2px; margin-top: 5px; font-size: 1.6rem;" align="center"> Check-List quinzenal</p>
                                <p><b>UH:</b> 101</p>
                                <div class="col-sm-12" style="border: solid white 5px; margin-bottom: 5px;">
                                    <h5>Iniciado em <b style="color:red;">14-06-20</b></h5>
                                    <h5>Status: <b style="color: red;">atrasado</b></h5>
                                </div>
                                <div class="col-sm-12" style="padding:0%; border: solid white 5px; margin-bottom: 5px;">
                                    <div id="donutchart1" style="width:100%; height:200px; background-color: rgb(243,246,251);"></div> 
                                </div>
                            </div>
                            <div style="background-color: rgb(243,246,251); padding-top:1%; border-right: solid white 10px;" class="col-sm-3 button" align="center">
                                <img src="bib/img/30.png" style="width: 40%; height: 60px;">
                                <p style="margin-bottom:2px; margin-top: 5px; font-size: 1.6rem;" align="center"> Check-List quinzenal</p>
                                <p><b>UH:</b> 101</p>
                                <div class="col-sm-12" style="border: solid white 5px; margin-bottom: 5px;">
                                    <h5>Iniciado em <b style="color:red;">14-06-20</b></h5>
                                    <h5>Status: <b style="color: red;">atrasado</b></h5>
                                </div>
                                <div class="col-sm-12" style="padding:0%; border: solid white 5px; margin-bottom: 5px;">
                                    <div id="donutchart2" style="width:100%; height:200px; background-color: rgb(243,246,251);"></div> 
                                </div>
                            </div>

                            <div style="background-color: rgb(243,246,251); padding-top:1%; border-right: solid white 10px;" class="col-sm-3 button" align="center">
                                <img src="bib/img/90.png" style="width: 40%; height: 60px;">
                                <p style="margin-bottom:2px; margin-top: 5px; font-size: 1.6rem;" align="center"> Check-List quinzenal</p>
                                <p><b>UH:</b> 101</p>
                                <div class="col-sm-12" style="border: solid white 5px; margin-bottom: 5px;">
                                    <h5>Iniciado em <b style="color:red;">14-06-20</b></h5>
                                    <h5>Status: <b style="color: red;">atrasado</b></h5>
                                </div>
                                <div class="col-sm-12" style="padding:0%; border: solid white 5px; margin-bottom: 5px;">
                                    <div id="donutchart3" style="width:100%; height:200px; background-color: rgb(243,246,251);"></div> 
                                </div>
                            </div>

                            <div style="background-color: rgb(243,246,251); padding-top:1%; border-right: solid white 10px;" class="col-sm-3 button" align="center">
                                <img src="bib/img/365.png" style="width: 40%; height: 60px;">
                                <p style="margin-bottom:2px; margin-top: 5px; font-size: 1.6rem;" align="center"> Check-List quinzenal</p>
                                <p><b>UH:</b> 101</p>
                                <div class="col-sm-12" style="border: solid white 5px; margin-bottom: 5px;">
                                    <h5>Iniciado em <b style="color:red;">14-06-20</b></h5>
                                    <h5>Status: <b style="color: red;">atrasado</b></h5>
                                </div>
                                <div class="col-sm-12" style="padding:0%; border: solid white 5px; margin-bottom: 5px;">
                                    <div id="donutchart4" style="width:100%; height:200px; background-color: rgb(243,246,251);"></div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!----------------------------------------------------------------Modal-------------------------------------------------------------------------->
    <div class="modal fade" id="CadProp2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style=" overflow:auto;">
        <div class="modal-dialog" role="document" style="width: 50%;">
            <div class="modal-content" style="border-radius: 15px;">
                <div class="modal-header header">
                    <h3 class="modal-title" id="exampleModalLabel" style="float: left; margin-left:28%;">Cadastro de propriedade</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="font-size: 3rem;">X</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12" style="border-bottom: solid lightgray 1px;">
                            <img src="bib/img/arcondicionado.png" style="width: 4rem; float:left;">
                            <h3 style="font-size:1.8rem; margin-left:1%;margin-top: 1.7%; float:left;">Dados do Ar Condicionado</h3>
                            <div id="QualUHAr"></div>
                            <div onclick="AbrirModal('CadProp', 'CadProp2')">
                                <h3 style="font-size:1.8rem; margin-left:1%;margin-top: 1.7%; float:right; margin-bottom:20px;"><b>2° PASSO</b></h3>
                                <img src="bib/img/Seta2.png" style="width: 3rem; float:right;margin-top: 0.8%;">
                            </div>
                        </div>
                        <div class="col-sm-12" style="margin-bottom: 15px;">
                            <div class="numeracao" style="margin-top: 2%;">1</div>
                            <h5 style="margin-top: 3.5%; float:left;"><b>Dados do Ar Condicionado</b></h5>
                            <div class="col-sm-11" style="margin-left:30px; border-bottom:solid green 1px; padding:0%;">
                                <p>Quantidade:</p>
                                <input onkeyup="quantAr()" id="quantAr" type="number" style="margin-bottom:10px;" />
                            </div>
                            <div class="col-sm-11" style="margin-left:30px; padding:0%;" id="ArCond">
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <div id="dv_relat"><input readonly="readonly" onclick="ADDAR()" id="btao_relat" value="Gravar e Prosseguir" class="fourth " style="width: 40%; float:right;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!----------------------------------------------------------------------------------------------------------------------------------------------->
    <?php include_once 'bib/comum/rodape.php'; ?>
    <script src="bib/js/menu.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="bib/js/Check-List.js"></script>
</body>

</html>