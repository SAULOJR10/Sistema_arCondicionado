<?php
include_once "../comum/conf.ini.php";
$acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);

switch ($acao) {
    case 'GraficosRosca':
        MontarGraficos();
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
    $TotalUHS = "SELECT * FROM uhs
                 INNER JOIN bloco ON fk_bloco = bloco.id
                 WHERE gerenciada = true and fk_entidade = $idEnt";
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
