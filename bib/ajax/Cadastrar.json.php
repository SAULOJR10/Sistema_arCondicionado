<?php
include_once "../comum/conexao.php";

$acao = $_POST['acao'];
$idEntidade = '';

switch ($acao) {
    case 'Bloco':
        cadBloco();
        break;
    case 'addUH':
        AddUH();
        break;
    case 'cadEnt':
        cadEnt();
        break;
    case 'cadEng':
        cadEng();
        break;
    case 'cadSala':
        cadSala('cadSala');
        break;
    case 'cadSalaBloco':
        cadSala('cadBloco');
        break;
}

function cadEnt()
{
    $resultado = "Entidade cadastrada com sucesso";
    $idUsuario = $_POST['idUsuario'];
    $razaoSocial = $_POST['razaoSocial'];
    $nomeFantasia = $_POST['nomeFantasia'];
    $CNPJEnt = $_POST['CNPJEnt'];
    $telefoneEnt = $_POST['telefoneEnt'];
    $estadoEnt = $_POST['EstadoEnt'];
    $cidadeEnt = $_POST['cidadeEnt'];
    $cepEnt = $_POST['cepEnt'];
    $enderecoEnt = $_POST['enderecoEnt'];

    $sql1 = "INSERT INTO public.dados_entidade(razao_social, nome_fantasia, cnpj, telefone, estado, cidade, cep, endereco, data_cadatro, data_alteracao)
             VALUES ('$razaoSocial', '$nomeFantasia', '$CNPJEnt', '$telefoneEnt', '$estadoEnt', '$cidadeEnt', '$cepEnt', '$enderecoEnt', now(), now())  RETURNING id";
    $exe1 = pg_query($GLOBALS['con'], $sql1)or die($resultado = "Algo deu errado ao cadastrar entidade, recarregue e tente novamente");
    $idEnt = pg_fetch_array($exe1, 0)[0];


    $sql2 = "INSERT INTO entidade_login (fk_login, fk_entidade)
             VALUES ('$idUsuario', '$idEnt')";
    pg_query($GLOBALS['con'], $sql2)or die($resultado = "Algo deu errado ao cadastrar entidade, recarregue e tente novamente");
    echo json_encode($resultado);
}

function cadEng()
{
    $resultado = "Engenheiro cadastrado com sucesso";
    $idEnt = $_POST['idEnt'];
    $nomeEng = $_POST['nomeEng'];
    $CREA = $_POST['CREA'];
    $CPF = $_POST['CPF'];
    $CEP = $_POST['cepEng'];
    $telefoneEng = $_POST['telefoneEng'];
    $emailEng = $_POST['emailEng'];
    $estadoEng = $_POST['estadoEng'];
    $cidadeEng = $_POST['cidadeEng'];
    $enderecoEng = $_POST['enderecoEng'];
    $assinatura = $_POST['assinatura'];

    $sql1 = "INSERT INTO public.dados_engenheiro(nome, crea, telefone, email, estado, cidade, endereco, assinatura, data_cadatro, data_alteracao, status, fk_entidade, cpf, cep)
             VALUES ('$nomeEng', '$CREA', '$telefoneEng', '$emailEng', '$estadoEng', '$cidadeEng', '$enderecoEng', '$assinatura', now(), now(), true, '$idEnt', '$CPF', '$CEP')";
    pg_query($GLOBALS['con'], $sql1)or die($resultado = "Algo deu errado ao cadastrar engenheiro, recarregue a pagina e tente novamente");

    echo json_encode($resultado);
}

function cadBloco()
{
    $resultado = "Bloco e Uhs cadastraos com sucesso";
    $idEnt = $_POST['idEnt'];
    $nome = $_POST['nomeBloco'];
    $quantAndar = intval($_POST['quantAndar']);
    $quantSubSolo = $_POST['quantSubSolo'];
    $idApart = strtoupper($_POST['idApart']);
    $explode = $_POST['quantApart'];
    $quantApart = explode(',', $explode);
    $Values = '';

    $sql1 = "INSERT INTO bloco (nome, fk_entidade, quant_andar, quant_subsolo)
             VALUES ('$nome', '$idEnt', $quantAndar, '$quantSubSolo') RETURNING id";
    $exe1 = pg_query($GLOBALS["con"], $sql1) or die($resultado = "Algo deu errado ao cadastrar Bloco");
    $idBloco = pg_fetch_array($exe1, 0)[0];

    for ($i = 0; $i <= $quantAndar; $i++) {
        $zero = 0;
        $andar = $i + 1;
        for ($o = 1; $o <= $quantApart[$andar]; $o++) {
            if ($o > 9) {
                $zero = '';
            }
            if ($o == $quantApart[$andar] && $i == $quantAndar) {
                $Values .= "('$i$zero$o', $i, $idBloco, 1, 'UH', true, '$idApart', false, 'Sem Proprietário')";
            } else {
                $Values .= "('$i$zero$o', $i, $idBloco, 1, 'UH', true, '$idApart', false, 'Sem Proprietário'),";
            }
        }
    }

    $sql2 = "INSERT INTO uhs (nome, andar, fk_bloco, proprietario, tipo_local, status, prefixo, gerenciada, tipo_proprietario) VALUES $Values";
    pg_query($GLOBALS["con"], $sql2)or die($resultado = "Algo deu errado ao cadastrar Uhs");

    echo json_encode($resultado);
}

function cadSala($acao)
{
    if ($acao == 'cadSala') {
        $resultado = "Sala(s) cadastrada(s) com sucesso";
        $idBloco = $_POST['idBloco'];
        $explodenome = explode(",", ($_POST['nomeSala']));
        $explodeandar = explode(",", ($_POST['andar']));
        $quantSala = $_POST['quantSala'];

        $values = '';
        for ($i = 1; $i <= $quantSala; $i++) {
            $andar = $explodeandar[$i];
            $nomeSala = $explodenome[$i];
            if ($i != $quantSala) {
                $values .= "('$nomeSala', '$andar', '$idBloco', '1', 'Sala', true, '', false, 'Sem Proprietário'),";
            } else {
                $values .= "('$nomeSala', '$andar', '$idBloco', '1', 'Sala', true, '', false, 'Sem Proprietário')";
            }
        }

        $sql = "INSERT INTO public.uhs(nome, andar, fk_bloco, proprietario, tipo_local, status, prefixo, gerenciada, tipo_proprietario)
	            VALUES $values;";
        pg_query($GLOBALS['con'], $sql)or die($resultado = "Erro ao cadastrar sala(s), tente recarregar a pagina");

        echo json_encode($resultado);
    }
    if ($acao == 'cadBloco') {
        $resultado = "Bloco adicionado com sucesso;";
        $idEnt = $_POST['idEnt'];
        $nomeBloco = $_POST['idBloco'];
        $quantAndar = $_POST['quantAndar'];
        $quantSubSolo = $_POST['quantSubSolo'];

        $sql1 = "INSERT INTO public.bloco(nome, fk_entidade, quant_andar, quant_subsolo)
            VALUES ('$nomeBloco', '$idEnt', '$quantAndar', '$quantSubSolo') RETURNING id";
        $exe1 = pg_query($GLOBALS["con"], $sql1) or die($resultado = "Erro ao adicionar Bloco, recarregue a pagina e tente novamente");
        $idBloco = pg_fetch_array($exe1, 0)[0];

        echo json_encode($resultado.$idBloco);
    }
}

function AddUH()
{
    $resultado = "UH(s) adicionadas com sucesso";
    $quant = $_POST['quant'];
    $idBloco = $_POST['idbloco'];
    $andar = $_POST['andar'];

    $sql1 = "SELECT * FROM uhs WHERE fk_bloco = $idBloco and andar = $andar and tipo_local = 'UH' and status = true";
    $exe1 = pg_query($GLOBALS['con'], $sql1);
    $sql2 = "SELECT * FROM uhs WHERE fk_bloco = $idBloco and tipo_local = 'UH' and status = true";
    $exe2 = pg_query($GLOBALS['con'], $sql2);
    $quantExiste = pg_numrows($exe1);
    $prefixo = pg_fetch_assoc($exe2)['prefixo'];
    $values = '';
    $zero = 0;
    $teste = $quant + $quantExiste;
    for ($i = $quantExiste+1; $i <= $teste; $i++) {
        if ($i > 9) {
            $zero = '';
        }
        if ($i == $teste) {
            $values .= "('$andar$zero$i', $andar, $idBloco, 1, 'UH', true, '$prefixo', false, 'Sem Proprietário')";
        } else {
            $values .= "('$andar$zero$i', $andar, $idBloco, 1, 'UH', true, '$prefixo', false, 'Sem Proprietário'),";
        }
    }

    $sql2 = "INSERT INTO public.uhs (nome, andar, fk_bloco, proprietario, tipo_local, status, prefixo, gerenciada, tipo_proprietário)
    VALUES $values";
    pg_query($GLOBALS['con'], $sql2)or die($resultado = "Algo deu errado ao adicionar UH(s), recarregue a pagina e tente novamente");

    echo json_encode($resultado);
}