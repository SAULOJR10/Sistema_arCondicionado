<?php
include_once "../comum/conexao.php";

$acao = $_POST['acao'];

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
    $idEnt = $_POST['idEnt'];
    $nome = $_POST['nomeBloco'];
    $idBloco = $_POST['idBlocoEdit'];
    $quantAndar = $_POST['quantAndar'];
    $quantSubSolo = $_POST['quantSubSolo'];
    $prefixo = $_POST['idApart'];

    $sql1 = "UPDATE public.bloco
             SET nome = '$nome', fk_entidade = $idEnt, quant_andar = $quantAndar, quant_subsolo = $quantSubSolo
             WHERE id = $idBloco";
    pg_query($GLOBALS['con'], $sql1)or die(pg_errormessage("Algo deu errado ao atualizar bloco, recarregue a pagina e tente novamente"));

    $sql2 = "UPDATE public.uhs SET prefixo = '$prefixo'
            WHERE fk_bloco = $idBloco";
    pg_query($GLOBALS['con'], $sql2);

    echo json_encode($resultado);
}


function EditUH($acao){
    $idApart = $_POST['idApart'];
    if($acao == 'recuperarUH'){
        $resultado = "UH recuperada com sucesso";
        $sql = "UPDATE public.uhs SET status=true WHERE id=$idApart";
        pg_query($GLOBALS['con'], $sql);
        echo json_encode($resultado);
    }
    if($acao == 'ExcluirSala'){
        $resultado = "Sala excluida com sucesso";
        $sql = "UPDATE public.uhs SET status=false WHERE id=$idApart";
        pg_query($GLOBALS['con'], $sql);
        echo json_encode($resultado);
    }
    if($acao == 'excluirUH'){
        $resultado = "UH excluida com sucesso";
        $sql = "UPDATE public.uhs SET status=false WHERE id=$idApart";
        pg_query($GLOBALS['con'], $sql);
        echo json_encode($resultado);
    }
    if($acao == 'editarUH'){
        $resultado = "UH editada com sucesso";
        $novoLocal = $_POST['novoLocal'];
        $novoNome = $_POST['novoNome'];
        $sql = "UPDATE public.uhs SET nome='$novoNome', tipo_local='$novoLocal' WHERE id=$idApart";
        pg_query($GLOBALS['con'], $sql);
        echo json_encode($resultado);
    }
    if($acao == 'EditSala'){
        $resultado = "Sala editada com sucesso";
        $novoNome = $_POST['novoNome'];
        $idBloco = $_POST['idBloco'];
        $idAndar = $_POST['idAndar'];
        $idApart = $_POST['idApart'];
        $sql = "UPDATE public.uhs SET nome='$novoNome', andar=$idAndar, fk_bloco = $idBloco WHERE id=$idApart";
        pg_query($GLOBALS['con'], $sql);
        echo json_encode($resultado);
    }
}