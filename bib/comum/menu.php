<?php
if (session_id() == '') {
    session_start();
}
?>
<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar " style="height: 100%;">
    <div style="width: 97%;height: 100%;  background: #FFF">
        <div class="profile-sidebar">
            <div class="profile-userpic">
                <img src="../sistema_arCondicionado/bib/img/i.png" class="img-responsive" alt="">
            </div>
            <div class="profile-usertitle">
                <div class="profile-usertitle-name"><?php echo $_SESSION["usuario"]; ?></div>
                <div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="divider"></div>
        <ul class="nav menu">
            <!------------------------------------------------------------------------------------------------------------->
            <li><a href="index.php">
                    <div class="row" style="width: 100%">
                        <div class="col-xs-2 p-l-0 p-r-0"><em class="fa fa-home p-l-0 p-r-0"></em> </div>
                        <div class="col-xs-10 p-l-0 p-r-0"> <b>Início</b></div>
                    </div>
                </a>
            </li>
            <!------------------------------------------------------------------------------------------------------------->
            <li><a onclick="ContinuarEntidade(<?php echo $n1?>, 'SistemaArCondicionado.php')">
                    <div class="row" style="width: 100%">
                        <div class="col-xs-2 p-l-0 p-r-0"><i class="fas fa-map-marker-alt" style="font-size: 1.8rem; float:left; margin-left:10%; margin-top:1%;"></i></div>
                        <div class="col-xs-10 p-l-0 p-r-0"> <b>Cadastro Predial</b></div>
                    </div>
                </a>
            </li>
            <!------------------------------------------------------------------------------------------------------------->
            <li><a onclick="ContinuarEntidade(<?php echo $n1?>, 'administracao.php')">
                    <div class="row" style="width: 100%">
                        <div class="col-xs-2 p-l-0 p-r-0"><i class="fas fa-users-cog" style="font-size: 1.8rem; float:left; margin-left:10%; margin-top:1%;"></i></div>
                        <div class="col-xs-10 p-l-0 p-r-0"> <b>Administracao</b></div>
                    </div>
                </a>
            </li>
            <!------------------------------------------------------------------------------------------------------------->
            <li><a onclick="ContinuarEntidade(<?php echo $n1?>, 'Check-List.php')">
                    <div class="row" style="width: 100%">
                        <div class="col-xs-2 p-l-0 p-r-0"><i class="fas fa-list-ol" style="font-size: 1.8rem; float:left; margin-left:10%; margin-top:1%;"></i></div>
                        <div class="col-xs-10 p-l-0 p-r-0"> <b>Check-List</b></div>
                    </div>
                </a>
            </li>
            <!------------------------------------------------------------------------------------------------------------->
            <li><a onclick="ContinuarEntidade(<?php echo $n1?>, 'RT.php')">
                    <div class="row" style="width: 100%">
                        <div class="col-xs-2 p-l-0 p-r-0"><i class="far fa-file-alt" style="font-size: 1.8rem; float:left; margin-left:10%; margin-top:1%;"></i></div>
                        <div class="col-xs-10 p-l-0 p-r-0"> <b>Impressão RT</b></div>
                    </div>
                </a>
            </li>
            <!------------------------------------------------------------------------------------------------------------->
            <li><a onclick="ContinuarEntidade(<?php echo $n1?>, 'Pesquisar.php')">
                    <div class="row" style="width: 100%">
                        <div class="col-xs-2 p-l-0 p-r-0"><i class="fas fa-search" style="font-size: 1.8rem; float:left; margin-left:10%; margin-top:1%;"></i></div>
                        <div class="col-xs-10 p-l-0 p-r-0"> <b>Pesquisar</b></div>
                    </div>
                </a>
            </li>
            <!------------------------------------------------------------------------------------------------------------->
            <li><a onclick="ContinuarEntidade(<?php echo $n1?>, 'Dashbord.php')">
                    <div class="row" style="width: 100%">
                        <div class="col-xs-2 p-l-0 p-r-0"><i class="fas fa-chart-bar" style="font-size: 1.8rem; float:left; margin-left:10%; margin-top:1%;"></i></div>
                        <div class="col-xs-10 p-l-0 p-r-0"> <b>Graficos</b></div>
                    </div>
                </a>
            </li>
    </div>
</div>
<!--/.sidebar-->