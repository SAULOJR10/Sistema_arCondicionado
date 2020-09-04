<?php
include_once "../comum/conf.ini.php";

$acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);
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
    $idUsuario = filter_input(INPUT_POST, 'idUsuario', FILTER_SANITIZE_STRING);
    $razaoSocial = filter_input(INPUT_POST, 'razaoSocial', FILTER_SANITIZE_STRING);
    $nomeFantasia = filter_input(INPUT_POST, 'nomeFantasia', FILTER_SANITIZE_STRING);
    $CNPJEnt = filter_input(INPUT_POST, 'CNPJEnt', FILTER_SANITIZE_STRING);
    $telefoneEnt = filter_input(INPUT_POST, 'telefoneEnt', FILTER_SANITIZE_STRING);
    $estadoEnt = filter_input(INPUT_POST, 'EstadoEnt', FILTER_SANITIZE_STRING);
    $cidadeEnt = filter_input(INPUT_POST, 'cidadeEnt', FILTER_SANITIZE_STRING);
    $cepEnt = filter_input(INPUT_POST, 'cepEnt', FILTER_SANITIZE_STRING);
    $enderecoEnt = filter_input(INPUT_POST, 'enderecoEnt', FILTER_SANITIZE_STRING);
    $conexao = new ConexaoCard();
    $sql1 = "INSERT INTO public.dados_entidade(razao_social, nome_fantasia, cnpj, telefone, estado, cidade, cep, endereco, data_cadatro, data_alteracao)
             VALUES ('$razaoSocial', '$nomeFantasia', '$CNPJEnt', '$telefoneEnt', '$estadoEnt', '$cidadeEnt', '$cepEnt', '$enderecoEnt', now(), now())  RETURNING id";
    $query = $conexao->execQuerry($sql1);
    if (is_array($query)) {
        $idEnt = $query[0]['id'] ;
    }

    $sql2 = "INSERT INTO entidade_login (fk_login, fk_entidade)
             VALUES ('$idUsuario', '$idEnt')";
    $conexao->execQuerry($sql2);
    $conexao->fecharConexao();

    echo json_encode($resultado);
}

function cadEng()
{
    $filename = $_FILES['campArquivo']['name'];
    $imageFileType = pathinfo($filename, PATHINFO_EXTENSION);

    /* Verifica extensao do arquivo */
    if (!in_array(strtolower($imageFileType), array("jpg", "jpeg", "png"))) {
        $return['erro'] = 'Arquivo não é JPG ou PNG';
        $uploadOk = 0;
    }
    // verifica para carregar arquivo menor que 1 MB
    if ($_FILES["campArquivo"]["size"] > (1024 * 1025)) {
        $return['erro'] .= ' Arquivo é muito grande.' . $_FILES["campArquivo"]["size"];
        $uploadOk = 0;
    }
    $location = getNomeArquivo($imageFileType);
    if(move_uploaded_file($_FILES['campArquivo']['tmp_name'], '../' . $location)){
        $resultado = "Engenheiro cadastrado com sucesso";
        $idEnt = filter_input(INPUT_POST, 'idEnt', FILTER_SANITIZE_STRING);
        $nomeEng = filter_input(INPUT_POST, 'nomeEng', FILTER_SANITIZE_STRING);
        $CREA = filter_input(INPUT_POST, 'CREA', FILTER_SANITIZE_STRING);
        $CPF = filter_input(INPUT_POST, 'CPF', FILTER_SANITIZE_STRING);
        $CEP = filter_input(INPUT_POST, 'cepEng', FILTER_SANITIZE_STRING);
        $telefoneEng = filter_input(INPUT_POST, 'telefoneEng', FILTER_SANITIZE_STRING);
        $emailEng = filter_input(INPUT_POST, 'emailEng', FILTER_SANITIZE_STRING);
        $estadoEng = filter_input(INPUT_POST, 'estadoEng', FILTER_SANITIZE_STRING);
        $cidadeEng = filter_input(INPUT_POST, 'cidadeEng', FILTER_SANITIZE_STRING);
        $enderecoEng = filter_input(INPUT_POST, 'enderecoEng', FILTER_SANITIZE_STRING);
        $conexao = new ConexaoCard();
        $sql1 = "INSERT INTO public.dados_engenheiro(nome, crea, telefone, email, estado, cidade, endereco, assinatura, data_cadatro, data_alteracao, status, fk_entidade, cpf, cep)
                VALUES ('$nomeEng', '$CREA', '$telefoneEng', '$emailEng', '$estadoEng', '$cidadeEng', '$enderecoEng', 'bib/$location', now(), now(), true, '$idEnt', '$CPF', '$CEP')";
        $conexao->execQuerry($sql1);
        $conexao->fecharConexao();
    }
    

    echo json_encode($resultado);
}

function getNomeArquivo($extensao) {
    $valor = random_int(100, 100000);
    $val = 0;
    while (file_exists("../imgAss/assinatura$valor.$extensao")) {
        $valor = random_int(100, 100000);
        $val++;
        if ($val > 1000) {
            $valor = 'extra';
            break;
        }
    }
    return "imgAss/assinatura$valor.$extensao";
}

function cadBloco()
{
    $resultado = "Bloco e Uhs cadastraos com sucesso";
    $idEnt = filter_input(INPUT_POST, 'idEnt', FILTER_SANITIZE_STRING);
    $nome = filter_input(INPUT_POST, 'nomeBloco', FILTER_SANITIZE_STRING);
    $quantAndar = intval(filter_input(INPUT_POST, 'quantAndar', FILTER_SANITIZE_STRING));
    $quantSubSolo = filter_input(INPUT_POST, 'quantSubSolo', FILTER_SANITIZE_STRING);
    $idApart = strtoupper(filter_input(INPUT_POST, 'idApart', FILTER_SANITIZE_STRING));
    $explode = filter_input(INPUT_POST, 'quantApart', FILTER_SANITIZE_STRING);
    $quantApart = explode(',', $explode);
    $Values = '';
    $conexao = new ConexaoCard();
    $sql1 = "INSERT INTO bloco (nome, fk_entidade, quant_andar, quant_subsolo)
             VALUES ('$nome', '$idEnt', $quantAndar, '$quantSubSolo') RETURNING id";
    $result = $conexao->execQuerry($sql1);
    
    $idBloco = $result[0]['id'] ;

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
    $conexao->execQuerry($sql2);
    $conexao->fecharConexao();

    echo json_encode($resultado);
}

function cadSala($acao)
{
    if ($acao == 'cadSala') {
        $resultado = "Sala(s) cadastrada(s) com sucesso";
        $idBloco = filter_input(INPUT_POST, 'idBloco', FILTER_SANITIZE_STRING);
        $explodenome = explode(",", filter_input(INPUT_POST, 'nomeSala', FILTER_SANITIZE_STRING));
        $explodeandar = explode(",", filter_input(INPUT_POST, 'andar', FILTER_SANITIZE_STRING));
        $quantSala = filter_input(INPUT_POST, 'quantSala', FILTER_SANITIZE_STRING);

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
        $conexao = new ConexaoCard();
        $sql = "INSERT INTO public.uhs(nome, andar, fk_bloco, proprietario, tipo_local, status, prefixo, gerenciada, tipo_proprietario)
                VALUES $values;";
        $conexao->execQuerry($sql);
        $conexao->fecharConexao();

        echo json_encode($resultado);
    }
    if ($acao == 'cadBloco') {
        $resultado = "Bloco adicionado com sucesso;";
        $idEnt = filter_input(INPUT_POST, 'idEnt', FILTER_SANITIZE_STRING);
        $nomeBloco = filter_input(INPUT_POST, 'idBloco', FILTER_SANITIZE_STRING);
        $quantAndar = filter_input(INPUT_POST, 'quantAndar', FILTER_SANITIZE_STRING);
        $quantSubSolo = filter_input(INPUT_POST, 'quantSubSolo', FILTER_SANITIZE_STRING);
        $conexao = new ConexaoCard();
        $sql1 = "INSERT INTO public.bloco(nome, fk_entidade, quant_andar, quant_subsolo)
            VALUES ('$nomeBloco', '$idEnt', '$quantAndar', '$quantSubSolo') RETURNING id";
        $result = $conexao->execQuerry($sql1);
        $conexao->fecharConexao();
        $idBloco = $result[0]['id'] ;

        echo json_encode($resultado . $idBloco);
    }
}

function AddUH()
{
    $resultado = "UH(s) adicionadas com sucesso";
    $quant = filter_input(INPUT_POST, 'quant', FILTER_SANITIZE_STRING);
    $idBloco = filter_input(INPUT_POST, 'idbloco', FILTER_SANITIZE_STRING);
    $andar = filter_input(INPUT_POST, 'andar', FILTER_SANITIZE_STRING);
    $conexao = new ConexaoCard();
    $sql1 = "SELECT * FROM uhs WHERE fk_bloco = $idBloco and andar = $andar and tipo_local = 'UH' and status = true";
    $result1 = $conexao->execQuerry($sql1);
    $sql2 = "SELECT * FROM uhs WHERE fk_bloco = $idBloco and tipo_local = 'UH' and status = true";
    $result2 = $conexao->execQuerry($sql2);
    $quantExiste = count($result1);
    if(is_array($result2)){
        $prefixo = $result2[0]['prefixo'];
    }
    $values = '';
    $zero = 0;
    $teste = $quant + $quantExiste;
    for ($i = $quantExiste + 1; $i <= $teste; $i++) {
        if ($i > 9) {
            $zero = '';
        }
        if ($i == $teste) {
            $values .= "('$andar$zero$i', $andar, $idBloco, 1, 'UH', true, '$prefixo', false, 'Sem Proprietário')";
        } else {
            $values .= "('$andar$zero$i', $andar, $idBloco, 1, 'UH', true, '$prefixo', false, 'Sem Proprietário'),";
        }
    }

    $sql3 = "INSERT INTO public.uhs (nome, andar, fk_bloco, proprietario, tipo_local, status, prefixo, gerenciada, tipo_proprietario)
    VALUES $values";
    $conexao->execQuerry($sql3);
    $conexao->fecharConexao();

    echo json_encode($resultado);
}
