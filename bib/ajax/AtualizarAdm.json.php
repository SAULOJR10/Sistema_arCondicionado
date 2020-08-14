<?php
include_once "../comum/conf.ini.php";

$acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);

switch ($acao) {
    case 'Gerenciada':
        Gerenciada();
        break;
    case 'atualizarDadosAr':
        atualizarDadosAr();
        break;
    case 'ExcluirDadosAr':
        ExcluirDadosAr();
        break;
}

function Gerenciada()
{
    $resultado = "Atualizado com Sucesso";
    $gerenciadas = filter_input(INPUT_POST, 'gerenciadas', FILTER_SANITIZE_STRING);
    $explode = explode(';', $gerenciadas);
    $quant = count($explode);
    $quant = intval($quant) - 2;

    $conexao = new ConexaoCard();
    for ($i = 1; $i <= $quant; $i++) {
        $id = $explode[$i];
        $sql = "UPDATE public.uhs SET gerenciada = true WHERE id = $id";
        $conexao->execQuerry($sql);
    }
    $conexao->fecharConexao();


    $nao_gerenciadas = filter_input(INPUT_POST, 'naoGerenciadas', FILTER_SANITIZE_STRING);
    $nao_explode = explode(';', $nao_gerenciadas);
    $nao_quant = count($nao_explode);
    $nao_quant = intval($nao_quant) - 2;

    $conexao = new ConexaoCard();
    for ($i = 1; $i <= $nao_quant; $i++) {
        $id = $nao_explode[$i];
        $sql = "UPDATE public.uhs SET gerenciada = false WHERE id = $id";
        $conexao->execQuerry($sql);
    }
    $conexao->fecharConexao();

    echo json_encode($resultado);
}

function atualizarDadosAr()
{
    $tabela = filter_input(INPUT_POST, 'tabela', FILTER_SANITIZE_STRING);
    $resultado = "Dados de $tabela atualizado com sucesso !!!";
    $nomeAntigo = filter_input(INPUT_POST, 'nomeAntigo', FILTER_SANITIZE_STRING);
    $novoNome = filter_input(INPUT_POST, 'novoNome', FILTER_SANITIZE_STRING);
    $conexao = new ConexaoCard();
    $sql = "UPDATE $tabela SET nome = '$novoNome' WHERE nome = '$nomeAntigo'";
    $conexao->execQuerry($sql);
    $conexao->fecharConexao();

    echo json_encode($resultado);
}

function ExcluirDadosAr(){
    $tabela = filter_input(INPUT_POST, 'tabela', FILTER_SANITIZE_STRING);
    $nomeAntigo = filter_input(INPUT_POST, 'nomeAntigo', FILTER_SANITIZE_STRING);
    $resultado = "$nomeAntigo excluido com sucesso";
    $conexao = new ConexaoCard();
    $sql = "DELETE FROM $tabela WHERE nome = '$nomeAntigo'";
    $conexao->execQuerry($sql);
    $conexao->fecharConexao();

    echo json_encode($resultado);
}