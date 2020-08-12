<?php
error_reporting(0);

include_once "../comum/conexao.php";
$acao = $_POST['acao'];

switch ($acao) {
    case 'CheckList':
        CheckList();
        break;
    case 'Avisar':
        Avisar();
        break;
}

function CheckList()
{
    $resultado = "Check-List enviado com sucessso !!!";
    $funcionario = $_POST['funcionario'];
    $idUH = $_POST['idUH'];
    $idAr = $_POST['idAr'];
    $statusCheck = $_POST['statusCheck'];
    $finalizados = explode(';', $_POST['finalizados']);
    $naoFinalizados = explode(';', $_POST['naoFinalizados']);
    $statusFinalizados = explode(';', $_POST['statusFinalizados']);
    $statusNaoFinalizados = explode(';', $_POST['statusNaoFinalizados']);
    $FinalizadosOBS = explode(';', $_POST['FinalizadosOBS']);
    $NaoFinalizadosOBS = explode(';', $_POST['NaoFinalizadosOBS']);
    $periodo = $_POST['periodo'];
    $quantFinalizados = COUNT($finalizados) - 2;
    $quantNaoFinalizados = COUNT($naoFinalizados) - 2;
    $hj = date('Y/m/d');
    $sqlUH = "SELECT * FROM uhs WHERE id = $idUH";
    $exeUH = pg_query($GLOBALS['con'], $sqlUH);
    $resultUH = pg_fetch_assoc($exeUH);
    $andar = $resultUH['andar'];
    $Bloco = $resultUH['fk_bloco'];
    switch ($periodo) {
        case 'Quinzenal':
            $vencimento = date('Y-m-d', strtotime('+15 days', strtotime('now')));
            break;
        case 'Mensal':
            $vencimento = date('Y-m-d', strtotime('+30 days', strtotime('now')));
            break;
        case 'Trimestral':
            $vencimento = date('Y-m-d', strtotime('+90 days', strtotime('now')));
            break;
        case 'Anual':
            $vencimento = date('Y-m-d', strtotime('+365 days', strtotime('now')));
            break;
    }
    $teste = "SELECT * FROM check_list
              WHERE fk_uh = $idUH and periodo = '$periodo' and fk_equipamento = $idAr and vencimento >= '$hj'";
    $resultadoTeste = pg_query($GLOBALS['con'], $teste);
    $testeFinal = pg_fetch_assoc($resultadoTeste)['id'];

    if ($testeFinal == null) {
        $sql1 = "INSERT INTO public.check_list(data_check, funcionario, fk_uh, fk_andar, fk_bloco, fk_equipamento, fk_engenheiro, data_asssinatura, status, periodo, vencimento)
        VALUES (now(), '$funcionario', '$idUH', '$andar', '$Bloco', '$idAr', 1, null, $statusCheck, '$periodo', '$vencimento') RETURNING id";
        $exe1 = pg_query($GLOBALS['con'], $sql1) or die($resultado = "1 Algo deu errado ao salvar check-list, recarregue a pagina e tente novamente !!!");
        $idCheck = pg_fetch_array($exe1, 0)[0];
    } else {
        $idCheck = $testeFinal;
    }

    $quantFinalizados = COUNT($finalizados) - 2;
    $quantNaoFinalizados = COUNT($naoFinalizados) - 2;
    for ($i = 1; $i <= $quantFinalizados; $i++) {
        $fk_item = $finalizados[$i];
        $status = $statusFinalizados[$i];
        $OBS = $FinalizadosOBS[$i];
        $teste =  "SELECT * FROM item_check
        INNER JOIN check_list ON fk_check_list = check_list.id
        WHERE fk_item = $fk_item and vencimento >= '$hj' and fk_equipamento = $idAr";
        $resultadoTeste = pg_query($GLOBALS['con'], $teste);
        $testeFinal = pg_fetch_assoc($resultadoTeste)['id'];
        if ($testeFinal != null) {
            $up =  "UPDATE public.item_check
            SET data = now(), observacao='$OBS', status=$status
            FROM item_check A INNER JOIN check_list B ON A.fk_check_list = B.id
            WHERE item_check.fk_item = $fk_item and B.fk_equipamento = $idAr";
            pg_query($GLOBALS['con'], $up) or die($resultado = "2 Algo deu errado ao salvar check-list, recarregue a pagina e tente novamente !!!");
        } else {
            $sql2 = "INSERT INTO public.item_check(fk_item, fk_check_list, data, observacao, status)
                     VALUES ($fk_item, $idCheck, now(), '$OBS', $status);";
            pg_query($GLOBALS['con'], $sql2) or die($resultado = "3 Algo deu errado ao salvar check-list, recarregue a pagina e tente novamente !!!");
        }
    }
    for ($o = 1; $o <= $quantNaoFinalizados; $o++) {
        $fk_item = $naoFinalizados[$o];
        $status = $statusNaoFinalizados[$o];
        $OBS = $NaoFinalizadosOBS[$i];
        $teste =  "SELECT * FROM item_check
        INNER JOIN check_list ON fk_check_list = check_list.id
        WHERE fk_item = $fk_item and vencimento >= '$hj' and fk_equipamento = $idAr";
        $resultadoTeste = pg_query($GLOBALS['con'], $teste);
        $teste = pg_fetch_assoc($resultadoTeste)['id'];
        if ($teste != null) {
            $up =  "UPDATE public.item_check
            SET data = now(), observacao='$OBS', status=$status
            FROM item_check A INNER JOIN check_list B ON A.fk_check_list = B.id
            WHERE item_check.fk_item = $fk_item and B.fk_equipamento = $idAr";
            pg_query($GLOBALS['con'], $up) or die($resultado = "4 Algo deu errado ao salvar check-list, recarregue a pagina e tente novamente !!!");
        } else {
            $sql2 = "INSERT INTO public.item_check(fk_item, fk_check_list, data, observacao, status)
                     VALUES ($fk_item, $idCheck, now(), '$OBS', $status);";
            pg_query($GLOBALS['con'], $sql2) or die($resultado = "5 Algo deu errado ao salvar check-list, recarregue a pagina e tente novamente !!!");
        }
    }
    echo json_encode($resultado);
}

function Avisar()
{
    $resultado = "Agedamento salvo com sucesso !!!";
    $idUH = $_POST['idUH'];
    $data = $_POST['data'];
    $obs = $_POST['obs'];

    $sql = "INSERT INTO public.agendamentos (data, observacao, fk_uh)
            VALUES  ('$data', '$obs', $idUH)";
    pg_query($GLOBALS['con'], $sql) or die($resultado =  "Algo deu errado ao cadastrar agendamento, recarregue a pagina e tente novamente");

    echo json_encode($resultado);
}
