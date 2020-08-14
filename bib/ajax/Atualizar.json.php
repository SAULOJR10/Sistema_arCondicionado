<?php
include_once "../comum/conf.ini.php";

$acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);

switch ($acao) {
    case 'updateBloco':
        updateBloco();
        break;
    case 'recuperarUH':
        EditUH($acao);
    break;
    case 'ExcluirSala':
        EditUH($acao);
    break;
    case 'EditSala':
        EditUH($acao);
    break;
    case 'excluirUH':
        EditUH($acao);
        break;
    case 'editarUH':
        EditUH($acao);
        break;
}

function UpdateBloco()
{
    $resultado = "Bloco atualiazado com sucesso";
    $idEnt = filter_input(INPUT_POST, 'idEnt', FILTER_SANITIZE_STRING);
    $nome = filter_input(INPUT_POST, 'nomeBloco', FILTER_SANITIZE_STRING);
    $idBloco = filter_input(INPUT_POST, 'idBlocoEdit', FILTER_SANITIZE_STRING);
    $quantAndar = filter_input(INPUT_POST, 'quantAndar', FILTER_SANITIZE_STRING);
    $quantSubSolo = filter_input(INPUT_POST, 'quantSubSolo', FILTER_SANITIZE_STRING);
    $prefixo = filter_input(INPUT_POST, 'idApart', FILTER_SANITIZE_STRING);

    $conexao = new ConexaoCard();
    $sql1 = "UPDATE public.bloco
             SET nome = '$nome', fk_entidade = $idEnt, quant_andar = $quantAndar, quant_subsolo = $quantSubSolo
             WHERE id = $idBloco";
    $conexao->execQuerry($sql1);

    $sql2 = "UPDATE public.uhs SET prefixo = '$prefixo'
            WHERE fk_bloco = $idBloco";
    $conexao->execQuerry($sql2);
    $conexao->fecharConexao();

    echo json_encode($resultado);
}


function EditUH($acao){
    $idApart = filter_input(INPUT_POST, 'idApart', FILTER_SANITIZE_STRING);
    if($acao == 'recuperarUH'){
        $resultado = "UH recuperada com sucesso";
        $conexao = new ConexaoCard();
        $sql = "UPDATE public.uhs SET status=true WHERE id=$idApart";
        $conexao->execQuerry($sql);
        $conexao->fecharConexao();
        echo json_encode($resultado);
    }
    if($acao == 'ExcluirSala'){
        $resultado = "Sala excluida com sucesso";
        $conexao = new ConexaoCard();
        $sql = "UPDATE public.uhs SET status=false WHERE id=$idApart";
        $conexao->execQuerry($sql);
        $conexao->fecharConexao();
        echo json_encode($resultado);
    }
    if($acao == 'excluirUH'){
        $resultado = "UH excluida com sucesso";
        $conexao = new ConexaoCard();
        $sql = "UPDATE public.uhs SET status=false WHERE id=$idApart";
        $conexao->execQuerry($sql);
        $conexao->fecharConexao();
        echo json_encode($resultado);
    }
    if($acao == 'editarUH'){
        $resultado = "UH editada com sucesso";
        $novoLocal = filter_input(INPUT_POST, 'novoLocal', FILTER_SANITIZE_STRING);
        $novoNome = filter_input(INPUT_POST, 'novoNome', FILTER_SANITIZE_STRING);
        $conexao = new ConexaoCard();
        $sql = "UPDATE public.uhs SET nome='$novoNome', tipo_local='$novoLocal' WHERE id=$idApart";
        $conexao->execQuerry($sql);
        $conexao->fecharConexao();
        echo json_encode($resultado);
    }
    if($acao == 'EditSala'){
        $resultado = "Sala editada com sucesso";
        $novoNome = filter_input(INPUT_POST, 'novoNome', FILTER_SANITIZE_STRING);
        $idBloco = filter_input(INPUT_POST, 'idBloco', FILTER_SANITIZE_STRING);
        $idAndar = filter_input(INPUT_POST, 'idAndar', FILTER_SANITIZE_STRING);
        $idApart = filter_input(INPUT_POST, 'idApart', FILTER_SANITIZE_STRING);
        $conexao = new ConexaoCard();
        $sql = "UPDATE public.uhs SET nome='$novoNome', andar=$idAndar, fk_bloco = $idBloco WHERE id=$idApart";
        $conexao->execQuerry($sql);
        $conexao->fecharConexao();
        echo json_encode($resultado);
    }
}