<?php
include_once "../comum/conexao.php";

$acao = $_POST['acao'];

switch ($acao) {
    case 'Gerenciada':
        Gerenciada();
        break;
}

function Gerenciada(){
    $resultado = "Atualizado com Sucesso";
    $gerenciadas = $_POST['gerenciadas'];
    $explode = explode(';', $gerenciadas);
    $quant = count($explode); 
    $quant = intval($quant) - 2;
    
    for($i = 1; $i <= $quant; $i++){
        $id = $explode[$i];
        $sql = "UPDATE public.uhs SET gerenciada = true WHERE id = $id";
        pg_query($GLOBALS['con'], $sql)or die($resultado = "Algo deu errado ao adicionar UHs ao gerenciamento");
    }



    $nao_gerenciadas = $_POST['naoGerenciadas'];
    $nao_explode = explode(';', $nao_gerenciadas);
    $nao_quant = count($nao_explode); 
    $nao_quant = intval($nao_quant) - 2;

    for($i = 1; $i <= $nao_quant; $i++){
        $id = $nao_explode[$i];
        $sql = "UPDATE public.uhs SET gerenciada = false WHERE id = $id";
        pg_query($GLOBALS['con'], $sql)or die($resultado = "Algo deu errado ao adicionar UHs ao gerenciamento");
    }

    echo json_encode($resultado);
}
?>