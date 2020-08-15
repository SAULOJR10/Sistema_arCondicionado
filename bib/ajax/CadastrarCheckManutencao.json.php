<?php
error_reporting(0);

include_once "../comum/conf.ini.php";
$acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);

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
    $funcionario = filter_input(INPUT_POST, 'funcionario', FILTER_SANITIZE_STRING);
    $idUH = filter_input(INPUT_POST, 'idUH', FILTER_SANITIZE_STRING);
    $idAr = filter_input(INPUT_POST, 'idAr', FILTER_SANITIZE_STRING);
    $statusCheck = filter_input(INPUT_POST, 'statusCheck', FILTER_SANITIZE_STRING);
    $finalizados = explode(';', filter_input(INPUT_POST, 'finalizados', FILTER_SANITIZE_STRING));
    $naoFinalizados = explode(';', filter_input(INPUT_POST, 'naoFinalizados', FILTER_SANITIZE_STRING));
    $statusFinalizados = explode(';', filter_input(INPUT_POST, 'statusFinalizados', FILTER_SANITIZE_STRING));
    $statusNaoFinalizados = explode(';', filter_input(INPUT_POST, 'statusNaoFinalizados', FILTER_SANITIZE_STRING));
    $FinalizadosOBS = explode(';', filter_input(INPUT_POST, 'FinalizadosOBS', FILTER_SANITIZE_STRING));
    $NaoFinalizadosOBS = explode(';', filter_input(INPUT_POST, 'NaoFinalizadosOBS', FILTER_SANITIZE_STRING));
    $periodo = filter_input(INPUT_POST, 'periodo', FILTER_SANITIZE_STRING);
    $quantFinalizados = COUNT($finalizados) - 2;
    $quantNaoFinalizados = COUNT($naoFinalizados) - 2;
    $hj = date('Y/m/d');
    $conexao = new ConexaoCard();
    $sqlUH = "SELECT * FROM uhs WHERE id = $idUH";
    $resultUH = $conexao->execQuerry($sqlUH);
    if (is_array($resultUH)) {
        $andar = $resultUH[0]['andar'];
        $Bloco = $resultUH[0]['fk_bloco'];
    }
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
    $resultadoTeste = $conexao->execQuerry($teste);
    $testeFinal = $resultadoTeste[0]['id'];

    if ($testeFinal == null) {
        $sql1 = "INSERT INTO public.check_list(data_check, funcionario, fk_uh, fk_andar, fk_bloco, fk_equipamento, fk_engenheiro, data_asssinatura, status, periodo, vencimento)
                 VALUES (now(), '$funcionario', '$idUH', '$andar', '$Bloco', '$idAr', 1, null, $statusCheck, '$periodo', '$vencimento') RETURNING id";
        $result1 = $conexao->execQuerry($sql1);
        $idCheck = $result1[0]['id'];
    } else {
        $idCheck = $testeFinal;
    }

    $quantFinalizados = COUNT($finalizados) - 2;
    $quantNaoFinalizados = COUNT($naoFinalizados) - 2;
    $statusCheck = true;
    for ($i = 1; $i <= $quantFinalizados; $i++) {
        $fk_item = $finalizados[$i];
        $status = $statusFinalizados[$i];
        $OBS = $FinalizadosOBS[$i];
        $teste =  "SELECT item_check.id, item_check.status FROM item_check
                   INNER JOIN check_list ON fk_check_list = check_list.id
                   WHERE fk_item = $fk_item and vencimento >= '$hj' and fk_equipamento = $idAr";
        $resultadoTeste = $conexao->execQuerry($teste);
        $testeFinal = $resultadoTeste[0]['id'];
        if ($resultadoTeste[0]['status'] == 0) {
            $statusCheck = false;
        }
        if ($testeFinal != null) {
            $up =  "UPDATE public.item_check
                    SET data = now(), observacao='$OBS', status=$status
                    FROM item_check A INNER JOIN check_list B ON A.fk_check_list = B.id
                    WHERE item_check.fk_item = $fk_item and B.fk_equipamento = $idAr";
            $conexao->execQuerry($up);
        } else {
            $sql2 = "INSERT INTO public.item_check(fk_item, fk_check_list, data, observacao, status)
                     VALUES ($fk_item, $idCheck, now(), '$OBS', $status);";
            $conexao->execQuerry($sql2);
        }
    }
        $sql = "UPDATE public.check_list
        SET status=$statusCheck
        WHERE id = $idCheck";
        $conexao->execQuerry($sql);
    for ($o = 1; $o <= $quantNaoFinalizados; $o++) {
        $fk_item = $naoFinalizados[$o];
        $status = $statusNaoFinalizados[$o];
        $OBS = $NaoFinalizadosOBS[$o];
        $teste =   "SELECT * FROM item_check
                    INNER JOIN check_list ON fk_check_list = check_list.id
                    WHERE fk_item = $fk_item and vencimento >= '$hj' and fk_equipamento = $idAr";
        $resultadoTeste = $conexao->execQuerry($teste);
        $teste = $resultadoTeste[0]['id'];
        if ($teste != null) {
            $up =  "UPDATE public.item_check
                    SET data = now(), observacao='$OBS', status=$status
                    FROM item_check A INNER JOIN check_list B ON A.fk_check_list = B.id
                    WHERE item_check.fk_item = $fk_item and B.fk_equipamento = $idAr";
            $conexao->execQuerry($up);
        } else {
            $sql2 = "INSERT INTO public.item_check(fk_item, fk_check_list, data, observacao, status)
                     VALUES ($fk_item, $idCheck, now(), '$OBS', $status);";
            $resultUH = $conexao->execQuerry($sql2);
        }
    }
    $conexao->fecharConexao();
    echo json_encode($resultado);
}

function Avisar()
{
    $resultado = "Agedamento salvo com sucesso !!!";
    $idUH = filter_input(INPUT_POST, 'idUH', FILTER_SANITIZE_STRING);
    $data = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_STRING);
    $obs = filter_input(INPUT_POST, 'obs', FILTER_SANITIZE_STRING);
    $conexao = new ConexaoCard();
    $sql = "INSERT INTO public.agendamentos (data, observacao, fk_uh)
            VALUES  ('$data', '$obs', $idUH)";
    $conexao->execQuerry($sql);

    echo json_encode($resultado);
}
