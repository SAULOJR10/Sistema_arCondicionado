<?php
include_once "../comum/conf.ini.php";

$acao = $_POST['acao'];

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
    $gerenciadas = $_POST['gerenciadas'];
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


    $nao_gerenciadas = $_POST['naoGerenciadas'];
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
    $tabela = $_POST['tabela'];
    $resultado = "Dados de $tabela atualizado com sucesso !!!";
    $nomeAntigo = $_POST['nomeAntigo'];
    $novoNome = $_POST['novoNome'];
    $conexao = new ConexaoCard();
    $sql = "UPDATE $tabela SET nome = '$novoNome' WHERE nome = '$nomeAntigo'";
    $conexao->execQuerry($sql);
    $conexao->fecharConexao();

    echo json_encode($resultado);
}

function ExcluirDadosAr(){
    $tabela = $_POST['tabela'];
    $nomeAntigo = $_POST['nomeAntigo'];
    $resultado = "$nomeAntigo excluido com sucesso";
    $conexao = new ConexaoCard();
    $sql = "DELETE FROM $tabela WHERE nome = '$nomeAntigo'";
    $conexao->execQuerry($sql);
    $conexao->fecharConexao();

    echo json_encode($resultado);
}