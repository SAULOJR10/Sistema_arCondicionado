<?php
error_reporting(0);

include_once "../comum/conexao.php";
$acao = $_POST['acao'];

switch ($acao) {
    case 'CheckList':
        CheckList();
        break;
}

function CheckList(){
    $resultado = "Check-List enviado com sucessso !!!";
    $funcionario = $_POST['funcionario'];
    $idUH = $_POST['idUH'];
    $idAr = $_POST['idAr'];
    $statusCheck = $_POST['statusCheck'];
    $finalizados = explode(';', $_POST['finalizados']);
    $naoFinalizados = explode(';', $_POST['naoFinalizados']);
    $statusItem = explode(';', $_POST['statusItem']);
    $periodo = $_POST['periodo'];
    
    $sqlUH = "SELECT * FROM uhs WHERE id = $idUH";
    $exeUH = pg_query($GLOBALS['con'], $sqlUH);
    $resultUH = pg_fetch_assoc($exeUH);
    $andar = $resultUH['andar'];
    $Bloco = $resultUH['fk_bloco'];

    $sql1 = "INSERT INTO public.check_list(data_check, funcionario, fk_uh, fk_andar, fk_bloco, fk_equipamento, fk_engenheiro, data_asssinatura, status, periodo)
    VALUES (now(), '$funcionario', '$idUH', '$andar', '$Bloco', '$idAr', 1, null, $statusCheck, '$periodo') RETURNING id";
    $exe1 = pg_query($GLOBALS['con'], $sql1)or die($resultado = "Algo deu errado ao enviar check-list, recarregue a pagina e tente novamente");
    $idCheck = pg_fetch_array($exe1, 0)[0];

    $quantFinalizados = COUNT($finalizados) - 2;
    $quantNaoFinalizados = COUNT($naoFinalizados) - 2;
    $teste = $quantFinalizados + $quantNaoFinalizados;
    for($i = 1; $i <= $teste; $i++){
        if($i <= $quantFinalizados){
            $fk_item = $finalizados[$i];
        }else{
            $fk_item = $naoFinalizados[$i];
        }
        $status = $statusItem[$i];
        $sql2 = "INSERT INTO public.item_check(fk_item, fk_check_list, data, observacao, status)
        VALUES ($fk_item, $idCheck, now(), '', $status);";
        pg_query($GLOBALS['con'], $sql2)or die($resultado = "Algo deu errado ao enviar check-list, recarregue a pagina e tente novamente");
    }
    echo json_encode($quantNaoFinalizados);
}