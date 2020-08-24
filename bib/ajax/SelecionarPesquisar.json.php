<?php
include_once "../comum/conf.ini.php";
$acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);

switch ($acao) {
    case 'UH':
        Pesquisar($acao);
        break;
    case 'Ar':
        PesquisarAr();
        break;
}

function Pesquisar()
{
}

function PesquisarAr()
{
    $pesquisa = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
    $sql = "SELECT $pesquisa FROM equipamento ORDER BY $pesquisa";
    $conexao = new ConexaoCard();
    $result = $conexao->execQuerry($sql);
    $conexao->fecharConexao();
    $quant1 = count($result) - 1;
    $anterior = '';
    $data = '';
    $quant2 = 1;
    for ($i = 0; $i <= $quant1; $i++) {
        $resultado = $result[$i]["$pesquisa"];
        if ($resultado != $anterior) {
            $quant2 = 1;
            $data .= ";['$resultado', $quant2],";
        } else {
            $quant2 = $quant2 + 1;
            $explode2 = explode(';', $data);
            $remove = count($explode2) - 1;
            unset($explode2[$remove]);
            $data = implode(";", $explode2);
            $data .= ";['$resultado', $quant2],";
        }
        $anterior = $resultado;
    }
    echo json_encode($data);
}
