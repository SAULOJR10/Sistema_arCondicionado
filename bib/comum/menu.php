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
            <li><a onclick="ContinuarEntidade(<?php echo $n1 ?>, 'Inicio.php')">
                    <div class="row" style="width: 100%">
                        <div class="col-xs-2 p-l-0 p-r-0"><em class="fa fa-home p-l-0 p-r-0"></em> </div>
                        <div class="col-xs-10 p-l-0 p-r-0"> <b>Início</b></div>
                    </div>
                </a>
            </li>
            <!------------------------------------------------------------------------------------------------------------->
            <li><a onclick="ContinuarEntidade(<?php echo $n1 ?>, 'SistemaArCondicionado.php')">
                    <div class="row" style="width: 100%">
                        <div class="col-xs-2 p-l-0 p-r-0"><i class="fas fa-map-marker-alt" style="font-size: 1.8rem; float:left; margin-left:10%; margin-top:1%;"></i></div>
                        <div class="col-xs-10 p-l-0 p-r-0"> <b>Cadastro Predial</b></div>
                    </div>
                </a>
            </li>
            <!------------------------------------------------------------------------------------------------------------->
            <li><a onclick="ContinuarEntidade(<?php echo $n1 ?>, 'administracao.php')">
                    <div class="row" style="width: 100%">
                        <div class="col-xs-2 p-l-0 p-r-0"><i class="fas fa-users-cog" style="font-size: 1.8rem; float:left; margin-left:10%; margin-top:1%;"></i></div>
                        <div class="col-xs-10 p-l-0 p-r-0"> <b>Administracao</b></div>
                    </div>
                </a>
            </li>
            <!------------------------------------------------------------------------------------------------------------->
            <!-- <li class="mainmenu open" id="geral">
            <li><a>
                    <div class="row" style="width: 100%">
                        <div class="col-xs-2 p-l-0 p-r-0"><i class="fas fa-list-ol" style="font-size: 1.8rem; float:left; margin-left:10%; margin-top:1%;"></i></div>
                        <div class="col-xs-10 p-l-0 p-r-0"> <b>Check-List</b> <i class="icon-arrow" style="font-size: 1.8rem; float:right; margin-right:10%; margin-top:1%;"></i></div>
                    </div>
                </a>
                <ul id="menu_servidor" class="mainmenu-menu show">
                    <li class="mainmenu">
                        <a onclick="ContinuarEntidade(<?php echo $n1 ?>, 'Check-List.php')">
                            <em class="fas fa-angle-right p-l-0 p-r-0" style="float: left;"></em><i class="fas fa-desktop" style="font-size: 1.8rem; float:left; margin-left:10%; margin-top:1%;"></i>
                            <font class="p-l-10 p-r-0">Para computador</font>
                        </a>
                    </li>
                </ul>
                <ul id="menu_servidor" class="mainmenu-menu show">
                    <li class="mainmenu">
                        <a onclick="ContinuarEntidade(<?php echo $n1 ?>, 'TelaManutencionista.php')">
                            <em class="fas fa-angle-right p-l-0 p-r-0" style="float: left;"></em><i class="fas fa-mobile-alt" style="font-size: 1.8rem; float:left; margin-left:10%; margin-top:1%;"></i>
                            <font class="p-l-10 p-r-0">Para celular</font>
                        </a>
                    </li>
                </ul>
            </li> -->
            <li class="mainmenu open">
                <a data-toggle="dropdown" aria-expanded="true">
                    <div class="row" style="width: 100%">
                        <div class="col-xs-2 p-l-0 p-r-0"><i class="fas fa-list-ol" style="font-size: 1.8rem; float:left; margin-left:10%; margin-top:1%;"></i></div>
                        <div class="col-xs-10 p-l-0 p-r-0"> <b>Check-List</b> <i class="icon-arrow" style="margin-top: -7%;"></i></div>
                    </div>
                </a>
                <ul id="menu_gerenciar" class="mainmenu-menu submenu hide">
                    <li id="submenu_gerenciar_disp">
                        <a onclick="ContinuarEntidade(<?php echo $n1 ?>, 'Check-List.php')" style="padding-left: 20%">
                            <div class="col-xs-3" style="padding: 0%;">
                                <i class="fas fa-desktop" style="font-size: 1.8rem; float:left; margin-top:1%;"></i>
                            </div>
                            <div class="col-xs-9" style="padding: 0%;">Para computador</div>
                        </a>
                    </li>
                    <li id="submenu_gerenciar_port">
                        <a onclick="ContinuarEntidade(<?php echo $n1 ?>, 'TelaManutencionista.php')" style="padding-left: 20%">
                        <div class="col-xs-3" style="padding: 0%;">
                            <i class="fas fa-mobile-alt" style="font-size: 2rem; float:left; margin-left: 5%; margin-top:1%;"></i>
                        </div>
                        <div class="col-xs-9" style="padding: 0%;">Para celular</div>
                        </a>
                    </li>
                </ul>
            </li>
            <!------------------------------------------------------------------------------------------------------------->
            <li><a href="Relatorio.php?num1=<?php echo $n1 ?>">
                    <div class="row" style="width: 100%">
                        <div class="col-xs-2 p-l-0 p-r-0"><i class="far fa-file-alt" style="font-size: 1.8rem; float:left; margin-left:10%; margin-top:1%;"></i></div>
                        <div class="col-xs-10 p-l-0 p-r-0"> <b>Impressão RT</b></div>
                    </div>
                </a>
            </li>
            <!------------------------------------------------------------------------------------------------------------->
            <li><a onclick="ContinuarEntidade(<?php echo $n1 ?>, 'Pesquisar.php')">
                    <div class="row" style="width: 100%">
                        <div class="col-xs-2 p-l-0 p-r-0"><i class="fas fa-search" style="font-size: 1.8rem; float:left; margin-left:10%; margin-top:1%;"></i></div>
                        <div class="col-xs-10 p-l-0 p-r-0"> <b>Pesquisar</b></div>
                    </div>
                </a>
            </li>
            <!------------------------------------------------------------------------------------------------------------->
            <li><a onclick="ContinuarEntidade(<?php echo $n1 ?>, 'Graficos.php')">
                    <div class="row" style="width: 100%">
                        <div class="col-xs-2 p-l-0 p-r-0"><i class="fas fa-chart-bar" style="font-size: 1.8rem; float:left; margin-left:10%; margin-top:1%;"></i></div>
                        <div class="col-xs-10 p-l-0 p-r-0"> <b>Gráficos</b></div>
                    </div>
                </a>
            </li>
            <!------------------------------------------------------------------------------------------------------------->
            <li><a onclick="ContinuarEntidade(<?php echo $n1 ?>, 'Cadastros.php')">
                    <div class="row" style="width: 100%">
                        <div class="col-xs-2 p-l-0 p-r-0"><i class="fas fa-user-plus" style="font-size: 1.8rem; float:left; margin-left:10%; margin-top:1%;"></i></div>
                        <div class="col-xs-10 p-l-0 p-r-0"> <b>Cadastro de usuário</b></div>
                    </div>
                </a>
            </li>
            <!------------------------------------------------------------------------------------------------------------->
            <li><a onclick="ContinuarEntidade(<?php echo $n1 ?>, 'CadastrosEdit.php')">
                    <div class="row" style="width: 100%">
                        <div class="col-xs-2 p-l-0 p-r-0"><i class="fas fa-user-edit" style="font-size: 1.8rem; float:left; margin-left:10%; margin-top:1%;"></i></div>
                        <div class="col-xs-10 p-l-0 p-r-0"> <b>Edição de usuário</b></div>
                    </div>
                </a>
            </li>
            <!------------------------------------------------------------------------------------------------------------->
            <li><a href="Sair.php">
                    <div class="row" style="width: 100%">
                        <div class="col-xs-2 p-l-0 p-r-0"><i class="fas fa-sign-out-alt" style="font-size: 1.8rem; float:left; margin-left:10%; margin-top:1%;"></i></div>
                        <div class="col-xs-10 p-l-0 p-r-0"> <b>Sair</b></div>
                    </div>
                </a>
            </li>
    </div>
</div>
<!--/.sidebar-->