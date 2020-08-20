<?php
include_once "bib/comum/conexao.php";

session_start();

if (isset($_POST['login']) && isset($_POST['senha'])) {
    $usr = $_POST['login'];
    $psw = $_POST['senha'];
    $sql1 = "select * from login where usuario = '$usr' and senha = '$psw'";
    $q1 =  pg_query($con, $sql1);
    $res = pg_fetch_assoc($q1);
    if ($psw == $res['senha']) {
        $num = rand(100000, 900000);
        $_SESSION['numLogin'] = $num;
        if ($res['tipo_usuario'] == "adm" && $res['status'] == true) {
            $_SESSION['idUsuario'] = $res['id'];
            $_SESSION['usuario'] = $res['usuario'];
            $_SESSION['arquivo'] = $res['arquivo'];
            header("Location:SistemaArCondicionado.php?num1=$num");
        }else if ($res['tipo_usuario'] == "manutencionista" && $res['status'] == true) {
            $_SESSION['idUsuario'] = $res['id'];
            $_SESSION['usuario'] = $res['usuario'];
            $_SESSION['arquivo'] = $res['arquivo'];
            header("Location:TelaManutencionista.php?num1=$num");
        }else if ($res['tipo_usuario'] == "eng" && $res['status'] == true) {
            $_SESSION['idUsuario'] = $res['id'];
            $_SESSION['usuario'] = $res['usuario'];
            $_SESSION['arquivo'] = $res['arquivo'];
            header("Location:RT.php?num1=$num");
        } 
    }
}
?>

<!doctype html>
<html lang="pt-br">
<meta http-equiv="Content-Language" content="pt-br" />

<head>
    <meta charset="utf-8" />
    <link rel="SHORTCUT ICON" href="bib/img/i.png" />
    <title>Infosoft - Login</title>


    <script src="bib/js/jquery-3.4.1.js"></script>
    <script src="bib/js/jquery-1.12.1.ui.js"></script>


    <link rel="stylesheet" href="bib/css/jquery-ui.css">

    <script src="bib/js/geral.js"></script>
    <script type="text/javascript" src="bib/js/login.js"></script>

    <link href="bib/css/default.css" rel="stylesheet" type="text/css" media="all" />
    <link href="bib/css/login.css" rel="stylesheet" />


</head>

<body>
    <div id="header-wrapper">
        <div id="header" styke="max_wigth=1000px; ">
            <div>
                <br>
                <center>
                    <img src="bib/img/logo2.png" onclick="location.href = 'https://infosoft.net.br'" style="width:380px;">
                </center>

            </div>
            <br>

        </div>
    </div>
    <br>
    <div class="login">
        <div id="partedologin2"><br />
            <form action="index.php" method="post" name="dados">
                <center>
                    <h1>
                        <font color="white" size="6"><b>Fa&ccedil;a seu login:</b></font>
                    </h1>
                    <br>
                </center>
                <div class="campologin">
                    <input type="text" class="configcampotext" name="login" placeholder=" Digite o seu login..." />
                </div>
                <div class="campologin">
                    <input type="password" class="configcampotext" name="senha" placeholder=" Digite a sua senha..." />
                    <br /><br />

                </div>
                <center><input type="submit">Acessar</center>
                <br />
                <center> <a href="recuperar_senha.php">
                        <font color="white"> Esqueci a minha senha!</font>
                    </a></center>
            </form>


        </div>
        <ul class="bg-bubbles">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>

    </div>

    <div id="banner-wrapper" style="margin-top: 500px;">
        <div id="banner" class="container">
            <a target="_blank" href="https://www.facebook.com/infosoft.tecnologia.wireless">https://www.facebook.com/infosoft.tecnologia.wireless</a><br />
            <a href="mailto:gerenciador.infosoft@gmail.com" target="_top"> gerenciador.infosoft@gmail.com</a>
        </div>
    </div>
</body>

</html>