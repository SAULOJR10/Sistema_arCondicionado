<?php
include_once '../comum/conf.ini.php';

$acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);

switch ($acao) {
    case 'ADDProp':
        ADDProp();
        break;
    case 'ADDAR':
        ADDAR();
        break;
    case 'InserirLocal':
        InserirDadosAr('localizacao');
        break;
    case 'InserirMarca':
        InserirDadosAr('marca');
        break;
    case 'InserirModelo':
        InserirDadosAr('modelo');
        break;
    case 'InserirPotencia':
        InserirDadosAr('potencia');
        break;
}

function ADDProp()
{
    $resultado = "Proprietário cadastrado com sucesso !!!";
    $UH = filter_input(INPUT_POST, 'UH', FILTER_SANITIZE_STRING);
    $nomeProp = filter_input(INPUT_POST, 'nomeProp', FILTER_SANITIZE_STRING);
    $razaoSocial = filter_input(INPUT_POST, 'razaoSocial', FILTER_SANITIZE_STRING);
    $documentoProp = filter_input(INPUT_POST, 'documento', FILTER_SANITIZE_STRING);
    $telefoneProp = filter_input(INPUT_POST, 'telefoneProp', FILTER_SANITIZE_STRING);
    $emailProp = filter_input(INPUT_POST, 'emailProp', FILTER_SANITIZE_STRING);
    $CEPProp = filter_input(INPUT_POST, 'CEPProp', FILTER_SANITIZE_STRING);
    $EstadoProp = filter_input(INPUT_POST, 'EstadoProp', FILTER_SANITIZE_STRING);
    $CidadeProp = filter_input(INPUT_POST, 'CidadeProp', FILTER_SANITIZE_STRING);
    $tipoPropriedade = filter_input(INPUT_POST, 'tipoPropriedade', FILTER_SANITIZE_STRING);
    $tipoPessoa = filter_input(INPUT_POST, 'tipoPessoa', FILTER_SANITIZE_STRING);
    $EnderecoProp = filter_input(INPUT_POST, 'enderecoProp', FILTER_SANITIZE_STRING);
    $conexao = new ConexaoCard();
    $sql1 = "INSERT INTO public.proprietarios(nome, documento, email, telefone, estado, cidade, cep, endereco, razao_social, data_cadastro, data_alteracao, tipo_pessoa)
    VALUES ('$nomeProp', '$documentoProp', '$emailProp', '$telefoneProp', '$EstadoProp', '$CidadeProp', '$CEPProp', '$EnderecoProp', '$razaoSocial', now(), now(), '$tipoPessoa') RETURNING id;";
    $result = $conexao->execQuerry($sql1);
    if (is_array($result)) {
        $idProp = $result[0]['id'] ;
    }

    $sql2 = "UPDATE public.uhs SET proprietario=$idProp, tipo_proprietario='$tipoPropriedade' WHERE id=$UH";
    $conexao->execQuerry($sql2);
    $conexao->fecharConexao();
    echo json_encode($resultado);
}

function ADDAR()
{
    $resultado = "Ar Condicionado(s) inseridos com sucesso !!!";
    $quant = filter_input(INPUT_POST, 'quant', FILTER_SANITIZE_STRING);
    $UH = filter_input(INPUT_POST, 'UH', FILTER_SANITIZE_STRING);
    $localizacao = explode(';', filter_input(INPUT_POST, 'localizacao', FILTER_SANITIZE_STRING));
    $marca = explode(';', filter_input(INPUT_POST, 'marca', FILTER_SANITIZE_STRING));
    $modelo = explode(';', filter_input(INPUT_POST, 'modelo', FILTER_SANITIZE_STRING));
    $potencia = explode(';', filter_input(INPUT_POST, 'potencia', FILTER_SANITIZE_STRING));
    $observacao = explode(';', filter_input(INPUT_POST, 'observacao', FILTER_SANITIZE_STRING));
    $tempo_uso = explode(';', filter_input(INPUT_POST, 'tempo_uso', FILTER_SANITIZE_STRING));

    for ($i = 0; $i < $quant; $i++) {
        $loc = $localizacao[$i];
        $marc = $marca[$i];
        $mod = $modelo[$i];
        $pot = $potencia[$i];
        $obs = $observacao[$i];
        $TU = $tempo_uso[$i];

        $conexao = new ConexaoCard();
        $sql = "INSERT INTO public.equipamento(localizacao, marca, modelo, potencia, tempo_de_uso, uh, tipo_equipamento, data_cadastro, data_alteracao, observacao)
                VALUES ('$loc', '$marc', '$mod', '$pot', '$TU', '$UH', '1', now(), now(), '$obs');";
        $conexao->execQuerry($sql);
        $conexao->fecharConexao();
    }
    echo json_encode($resultado);
}

function InserirDadosAr($tabela){
    $resultado = "$tabela inserida com sucesso !!!";
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);

    $conexao = new ConexaoCard();
    $sql = "INSERT INTO public.$tabela (nome) values ('$nome')";
    $conexao->execQuerry($sql);
    $conexao->fecharConexao();

    echo json_encode($resultado);
}