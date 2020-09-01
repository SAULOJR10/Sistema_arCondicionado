<?php
include_once "../comum/conf.ini.php";
$acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);

switch ($acao) {
    case 'GraficosRosca':
        MontarGraficos();
        break;
    case 'GraficosTorres':
        MontarTorres();
        break;
    case 'QualEnt':
        selectEnt();
        break;
    case 'selectEnt':
        selectEnt();
        break;
}

function SelectEnt()
{
    $idLogin = filter_input(INPUT_POST, 'idUsuario', FILTER_SANITIZE_STRING);
    $conexao = new ConexaoCard();
    $sql = "SELECT dados_entidade.id AS ident, nome_fantasia FROM dados_entidade
             INNER JOIN entidade_login on fk_entidade = dados_entidade.id
             Where fk_login = $idLogin and nome_fantasia != ''
             ORDER BY nome_fantasia";
    $result = $conexao->execQuerry($sql);
    $conexao->fecharConexao();

    $quant = count($result) - 1;
    $option = '<option value="">Selecione</option>";';
    for ($i = 0; $i <= $quant; $i++) {
        $valor = $result[$i]['nome_fantasia'];
        $id = $result[$i]['ident'];
        $option .= "<option value='$id' id='optionEnt$id'>$valor</option>";
    }
    $select = "<div class='form-group'><select id='EntidadeGer' style='border-radius:10px;' class='form-control' onchange='EntSelected(\"normal\")'>$option</select></div>";
    echo json_encode($select);
}

function MontarGraficos()
{
    $idEnt = filter_input(INPUT_POST, 'idEnt', FILTER_SANITIZE_STRING);

    $hj = date('Y/m/d');
    $TotalUHS = "SELECT * FROM equipamento
                 INNER JOIN uhs ON uh = uhs.id
                 INNER JOIN bloco ON fk_bloco = bloco.id
                 WHERE fk_entidade = $idEnt and gerenciada = true";
    $conexao = new ConexaoCard();
    $result = $conexao->execQuerry($TotalUHS);
    $quantTotal = count($result);

    $sqlCheck_list = "SELECT check_list.status FROM check_list
    INNER JOIN bloco ON fk_bloco = bloco.id
    WHERE periodo = 'Quinzenal' and vencimento >= '$hj' and fk_entidade = $idEnt";
    $result2 = $conexao->execQuerry($sqlCheck_list);
    $quant = count($result2) - 1;
    $quantFinalizadas = 0;
    $quantNaoFinalizadas = 0;
    $resultado = '';
    for ($i = 0; $i <= $quant; $i++) {
        if ($result2[$i]['status'] == 1) {
            $quantFinalizadas = $quantFinalizadas + 1;
        } else {
            $quantNaoFinalizadas = $quantNaoFinalizadas + 1;
        }
    }
    $naoRealizadas = $quantTotal - $quantFinalizadas - $quantNaoFinalizadas;
    $resultado .= $quantFinalizadas . ',' . $quantNaoFinalizadas . ',' . $naoRealizadas . '&';

    $sqlCheck_list = "SELECT check_list.status FROM check_list
    INNER JOIN bloco ON fk_bloco = bloco.id
    WHERE periodo = 'Mensal' and vencimento >= '$hj' and fk_entidade = $idEnt";
    $result2 = $conexao->execQuerry($sqlCheck_list);
    $quant = count($result2) - 1;
    $quantFinalizadas = 0;
    $quantNaoFinalizadas = 0;
    for ($i = 0; $i <= $quant; $i++) {
        if ($result2[$i]['status'] == 1) {
            $quantFinalizadas = $quantFinalizadas + 1;
        } else {
            $quantNaoFinalizadas = $quantNaoFinalizadas + 1;
        }
    }
    $naoRealizadas = $quantTotal - $quantFinalizadas - $quantNaoFinalizadas;
    $resultado .= $quantFinalizadas . ',' . $quantNaoFinalizadas . ',' . $naoRealizadas . '&';

    $sqlCheck_list = "SELECT check_list.status FROM check_list
    INNER JOIN bloco ON fk_bloco = bloco.id
    WHERE periodo = 'Trimestral' and vencimento >= '$hj' and fk_entidade = $idEnt";
    $result2 = $conexao->execQuerry($sqlCheck_list);
    $quant = count($result2) - 1;
    $quantFinalizadas = 0;
    $quantNaoFinalizadas = 0;
    for ($i = 0; $i <= $quant; $i++) {
        if ($result2[$i]['status'] == 1) {
            $quantFinalizadas = $quantFinalizadas + 1;
        } else {
            $quantNaoFinalizadas = $quantNaoFinalizadas + 1;
        }
    }
    $naoRealizadas = $quantTotal - $quantFinalizadas - $quantNaoFinalizadas;
    $resultado .= $quantFinalizadas . ',' . $quantNaoFinalizadas . ',' . $naoRealizadas . '&';

    $sqlCheck_list = "SELECT check_list.status FROM check_list
    INNER JOIN bloco ON fk_bloco = bloco.id
    WHERE periodo = 'Anual' and vencimento >= '$hj' and fk_entidade = $idEnt";
    $result2 = $conexao->execQuerry($sqlCheck_list);
    $quant = count($result2) - 1;
    $quantFinalizadas = 0;
    $quantNaoFinalizadas = 0;
    for ($i = 0; $i <= $quant; $i++) {
        if ($result2[$i]['status'] == 1) {
            $quantFinalizadas = $quantFinalizadas + 1;
        } else {
            $quantNaoFinalizadas = $quantNaoFinalizadas + 1;
        }
    }
    $naoRealizadas = $quantTotal - $quantFinalizadas - $quantNaoFinalizadas;
    $resultado .= $quantFinalizadas . ',' . $quantNaoFinalizadas . ',' . $naoRealizadas;

    echo json_encode($resultado);
}


function MontarTorres()
{
    $fk_entidade = filter_input(INPUT_POST, 'idEnt', FILTER_SANITIZE_STRING);
    $sql = "SELECT count(equipamento.id) AS quantequip FROM equipamento
            INNER JOIN uhs ON uh = uhs.id
            INNER JOIN bloco ON fk_bloco = bloco.id
            WHERE fk_entidade = $fk_entidade and gerenciada = true";
    $conexao = new ConexaoCard();
    $quantTotal = $conexao->execQuerry($sql)[0]['quantequip'];

    $umanoatras = date('Y/m/d', strtotime('-365 days'));
    $sql2 = "SELECT extract(month FROM data_check) AS mes, status FROM check_list
             INNER JOIN bloco ON fk_bloco = bloco.id
             WHERE fk_entidade = $fk_entidade and data_check >= '$umanoatras' ORDER BY data_check";
    $result = $conexao->execQuerry($sql2);
    $conexao->fecharConexao();

    $quant = count($result) - 1;
    $anterior = 0;
    $dados = array();
    $quantFinalizados = 0;
    $quantNaoFinalizados = 0;
    for ($i = 0; $i <= $quant; $i++) {
        $mes = $result[$i]['mes'];
        if ($mes != $anterior && $anterior != 0) {
            switch ($mes) {
                case 1:
                    $mesText = 'Janeiro';
                    break;
                case 2:
                    $mesText = 'Fevereiro';
                    break;
                case 3:
                    $mesText = 'Março';
                    break;
                case 4:
                    $mesText = 'Abril';
                    break;
                case 5:
                    $mesText = 'Maio';
                    break;
                case 6:
                    $mesText = 'Junho';
                    break;
                case 7:
                    $mesText = 'Julho';
                    break;
                case 8:
                    $mesText = 'Agosto';
                    break;
                case 9:
                    $mesText = 'Setembro';
                    break;
                case 10:
                    $mesText = 'Outubro';
                    break;
                case 11:
                    $mesText = 'Novembro';
                    break;
                case 12:
                    $mesText = 'Dezembro';
                    break;
            }
            $quantNaoRealizado = $quantTotal - $quantFinalizados - $quantNaoFinalizados;
            $dados[] = [array("$mesText", $quantFinalizados, $quantNaoFinalizados, $quantNaoRealizado)];
        } else {
            $status = $result[$i]['status'];
            if ($status == 1) {
                $quantFinalizados = $quantFinalizados + 1;
            } else {
                $quantNaoFinalizados = $quantNaoFinalizados + 1;
            }
        }
        $anterior = $mes;
    }
    // ['Janeiro', 4, 6, 1],
    // ['Fevereiro', 8, 7, 5],
    // ['Março', 5, 7, 5],
    // ['Abril', 8, 6, 7],
    // ['Maio', 3, 4, 8],
    // ['Junho', 6, 7, 3],
    // ['Julho', 2, 9, 6],
    // ['Agosto', 5, 8, 3],
    // ['Setembro', 7, 7, 1],
    // ['Outubro', 4, 9, 5],
    // ['Novembro', 6, 4, 3],
    // ['Dezembro', 9, 5, 7],
    $retorno['dados'] = $dados;
    var_dump($retorno);
}
