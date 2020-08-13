<?php
include_once '../comum/conf.ini.php';

$acao = $_POST['acao'];

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
    $UH = $_POST['UH'];
    $nomeProp = $_POST['nomeProp'];
    $razaoSocial = $_POST['razaoSocial'];
    $documentoProp = $_POST['documento'];
    $telefoneProp = $_POST['telefoneProp'];
    $emailProp = $_POST['emailProp'];
    $CEPProp = $_POST['CEPProp'];
    $EstadoProp = $_POST['EstadoProp'];
    $CidadeProp = $_POST['CidadeProp'];
    $tipoPropriedade = $_POST['tipoPropriedade'];
    $tipoPessoa = $_POST['tipoPessoa'];
    $EnderecoProp = $_POST['enderecoProp'];
    $conexao = new ConexaoCard();
    $sql1 = "INSERT INTO public.proprietarios(nome, documento, email, telefone, estado, cidade, cep, endereco, razao_social, data_cadastro, data_alteracao, tipo_pessoa)
    VALUES ('$nomeProp', '$documentoProp', '$emailProp', '$telefoneProp', '$EstadoProp', '$CidadeProp', '$CEPProp', '$EnderecoProp', '$razaoSocial', now(), now(), '$tipoPessoa') RETURNING id;";
    $result = $conexao->execQuerry($sql1);
    if (is_array($result)) {
        $idProp = $result[0]['id'];
    }

    $sql2 = "UPDATE public.uhs SET proprietario=$idProp, tipo_proprietario='$tipoPropriedade' WHERE id=$UH";
    $conexao->execQuerry($sql2);
    $conexao->fecharConexao();
    echo json_encode($resultado);
}

function ADDAR()
{
    $resultado = "Ar Condicionado(s) inseridos com sucesso !!!";
    $quant = $_POST['quant'];
    $UH = $_POST['UH'];
    $localizacao = explode(';', $_POST['localizacao']);
    $marca = explode(';', $_POST['marca']);
    $modelo = explode(';', $_POST['modelo']);
    $potencia = explode(';', $_POST['potencia']);
    $observacao = explode(';', $_POST['observacao']);
    $tempo_uso = explode(';', $_POST['tempo_uso']);

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
    $nome = $_POST['nome'];

    $conexao = new ConexaoCard();
    $sql = "INSERT INTO public.$tabela (nome) values ('$nome')";
    $conexao->execQuerry($sql);
    $conexao->fecharConexao();

    echo json_encode($resultado);
}