<?php
include_once "../comum/conf.ini.php";
$acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);

switch ($acao) {
    case 'UH':
        Pesquisar($acao);
        break;
    case 'Prop':
        Pesquisar($acao);
        break;
    case 'Ar':
        PesquisarAr();
        break;
    case 'Bloco':
        SelectBloco();
        break;
    case 'SelectUH':
        SelectUH();
        break;
    case 'selectEnt':
        SelectEnt('selectEnt');
        break;
    case 'AutoCompleta':
        AutoCompleta();
        break;
}

function SelectUH()
{
    $bloco = filter_input(INPUT_POST, 'idBloco', FILTER_SANITIZE_STRING);
    $conexao = new ConexaoCard();
    $sql = "SELECT uhs.nome, uhs.id, equipamento.id AS equipamento FROM uhs
                INNER JOIN equipamento ON uh = uhs.id
                WHERE fk_bloco = $bloco and status = true ORDER BY nome";
    $result = $conexao->execQuerry($sql);
    $conexao->fecharConexao();

    $quant = count($result) - 1;
    $option = '<option value="">Selecione</option>';
    for ($i = 0; $i <= $quant; $i++) {
        if ($i != 0) {
            $o = $i - 1;
        } else {
            $o = 1;
        }
        $UH = $result[$i]['nome'];
        $id = $result[$i]['id'];
        $equip = $result[$i]['equipamento'];
        if ($equip != '' && $equip != null && $UH != $result[$o]['nome']) {
            $option .= "<option value='$id'> $UH </option>";
        } else if ($o == 0 || !isset($o)) {
            $option .= "<option value='$id'> $UH </option>";
        }
    }
    $html = "<p'>Selecione UH:</p><select class='form-control' id='UHGer' style='border-radius:5px;'> $option </select>";
    echo json_encode($html);
}

function SelectEnt($acao)
{
    if ($acao == 'selectEnt') {
        $idLogin = filter_input(INPUT_POST, 'idUsuario', FILTER_SANITIZE_STRING);
        $conexao = new ConexaoCard();
        $sql = "SELECT dados_entidade.id AS ident, nome_fantasia FROM dados_entidade
                 INNER JOIN entidade_login on fk_entidade = dados_entidade.id
                 Where fk_login = $idLogin and nome_fantasia != ''";
        $result = $conexao->execQuerry($sql);
        $conexao->fecharConexao();

        $quant = count($result) - 1;
        $option = '<option value="">Selecione</option>";';
        for ($i = 0; $i <= $quant; $i++) {
            $valor = $result[$i]['nome_fantasia'];
            $id = $result[$i]['ident'];
            $option .= "<option value='$id' id='optionEnt$id'>$valor</option>";
        }
        $select = "<div class='form-group'><select id='EntidadeGer' style='border-radius:10px;' class='form-control' onchange='EntSelected()'>$option</select></div>";
        echo json_encode($select);
    }
}

function SelectBloco()
{
    $idEnt = filter_input(INPUT_POST, 'idEnt', FILTER_SANITIZE_STRING);
    $conexao = new ConexaoCard();
    $sql = "SELECT bloco.id, bloco.nome FROM bloco
            WHERE fk_entidade = $idEnt ORDER BY bloco.nome";
    $result = $conexao->execQuerry($sql);
    $conexao->fecharConexao();

    $quant = count($result) - 1;
    $option = '<option value="">Selecione</option>';
    for ($i = 0; $i <= $quant; $i++) {
        if ($i != 0) {
            $o = $i - 1;
        } else {
            $o = 1;
        }
        $Bloco = $result[$i]['nome'];
        $id = $result[$i]['id'];
        $option .= "<option value='$id'> $Bloco </option>";
    }
    $html = "<p>Selecione o Bloco:</p><select style='border-radius:5px; width: 100%;' id='Bloco' class='form-control' onchange=\"SelectUH()\">$option</select>";
    echo json_encode($html);
}

function Pesquisar($acao)
{
    if ($acao == 'UH') {
        $pesquisa = $_POST['pesquisa'];
        $sql = "SELECT proprietarios.nome AS nomeprop, endereco, telefone, marca, modelo, potencia, localizacao FROM uhs
                INNER JOIN proprietarios ON proprietario = proprietarios.id
                INNER JOIN equipamento ON uh = uhs.id
                WHERE uhs.id = $pesquisa and gerenciada = true";
        $conexao = new ConexaoCard();
        $result = $conexao->execQuerry($sql);
        $conexao->fecharConexao();

        $nomeProp = $result[0]['nomeprop'];
        $endereco = $result[0]['endereco'];
        $telefoneProp = $result[0]['telefone'];
        $html = "<div class='row'>
                    <h4 style='text-align:center'><b>Proprietario(s):</b></h4>
                    <h5 style='text-align:center'>$nomeProp</h5>
                    <h5 style='text-align:center'>$endereco</h5>
                    <h5 style='text-align:center'>Telefone: $telefoneProp</h5>
                    <hr>
                    <h4 style='text-align:center'><b>Equipamento(s):</b></h4>";

        $quant = count($result) - 1;
        for ($i = 0; $i <= $quant; $i++) {
            $num = $i + 1;
            $marca = $result[$i]['marca'];
            $modelo = $result[$i]['modelo'];
            $potencia = $result[$i]['potencia'];
            $localizacao = $result[$i]['localizacao'];
            $html .= "<h5 style='text-align:center'><b>Ar Condicionado 0$num:</b></h5>
                      <h5 style='text-align:center'>Marca: $marca</h5>
                      <h5 style='text-align:center'>Modelo: $modelo</h5>
                      <h5 style='text-align:center'>Potência: $potencia</h5>
                      <h5 style='text-align:center'>Localização: $localizacao</h5>
                      <br>";
        }
        $html .= "</div>";
        echo json_encode($html);
    }
    if ($acao == 'Prop') {
        $pesquisa = filter_input(INPUT_POST, 'pesquisa', FILTER_SANITIZE_STRING);
        $nome = explode(' - ', $pesquisa)[0];
        $documento = explode(' - ', $pesquisa)[1];

        $sql = "SELECT proprietarios.nome AS nomeprop, bloco.nome AS nomebloco, uhs.nome AS nomeuh, tipo_local, andar, gerenciada, documento, endereco, telefone, email, estado, cidade, tipo_pessoa FROM uhs
                INNER JOIN proprietarios ON proprietario = proprietarios.id
                INNER JOIN bloco ON fk_bloco = bloco.id
                WHERE proprietarios.nome = '$nome' and documento = '$documento' and gerenciada = true";
        $conexao = new ConexaoCard();
        $result = $conexao->execQuerry($sql);
        $conexao->fecharConexao();

        $nomeProp = $result[0]['nomeprop'];
        $tipo_pessoa = $result[0]['tipo_pessoa'];
        if ($tipo_pessoa == 'Fisica') {
            $documento = "CPF: " . $result[0]['documento'];
        } else {
            $documento = "CNPJ: " . $result[0]['documento'];
        }
        $email = $result[0]['email'];
        $telefone = $result[0]['telefone'];
        $estado = $result[0]['estado'];
        $cidade = $result[0]['cidade'];
        $endereco = $result[0]['endereco'];
        $html = "<div class='row'>
                    <h4 style='text-align:center'><b>Proprietario:</b></h4>
                    <h5 style='text-align:center'>$nomeProp</h5>
                    <h5 style='text-align:center'>$endereco</h5>
                    <h5 style='text-align:center'>$cidade - $estado</h5>
                    <h5 style='text-align:center'>$documento</h5>
                    <h5 style='text-align:center'>E-mail: $email</h5>
                    <h5 style='text-align:center'>Telefone: $telefone</h5>
                    <hr>
                    <h4 style='text-align:center'><b>Propriedade(s):</b></h4>";

        $quant = count($result) - 1;
        for ($i = 0; $i <= $quant; $i++) {
            $nomeBloco = $result[$i]['nomebloco'];
            if ($result[$i]['andar'] > 0) {
                $andar = 'Andar ' . $result[$i]['andar'];
            }
            if ($result[$i]['andar'] == 0) {
                $andar = 'Térreo';
            }
            if ($result[$i]['andar'] < 0) {
                $andar = 'Sub-Solo(' . $result[$i]['andar'] . ')';
            }
            if ($result[$i]['tipo_local'] == 'UH') {
                $nomeUH = 'UH:' . $result[$i]['nomeuh'];
            } else {
                $nomeUH = 'Sala:' . $result[$i]['nomeuh'];
            }
            $html .= "<h5 style='text-align:center'>$nomeBloco</h5>
                      <h5 style='text-align:center'>$andar</h5>
                      <h5 style='text-align:center'>$nomeUH</h5>
                      <br>";
        }
        echo json_encode($html);
    }
}

function PesquisarAr()
{
    $pesquisa = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
    $idEnt = filter_input(INPUT_POST, 'idEnt', FILTER_SANITIZE_STRING);
    $sql = "SELECT $pesquisa FROM equipamento
            INNER JOIN uhs ON uh = uhs.id
            INNER JOIN bloco ON fk_bloco = bloco.id
            WHERE fk_entidade = $idEnt and gerenciada = true ORDER BY $pesquisa";
    $conexao = new ConexaoCard();
    $result = $conexao->execQuerry($sql);
    $conexao->fecharConexao();
    $quant1 = count($result) - 1;
    $anterior = '';
    $data = [array("Titulo", "Quantidade")];
    $quant2 = 0;
    for ($i = 0; $i <= $quant1; $i++) {
        $resultado = $result[$i]["$pesquisa"];
        if ($resultado != $anterior && $anterior != '' || $i == $quant1) {
            if ($i == $quant1) {
                if ($quant2 == 1) {
                    $quant2 = 1;
                }else{
                    $quant2++;
                }
                $data[] = array("$anterior", $quant2);
                $data[] = array("$resultado", 1);
                $quant2 = 1;
            } else {
                $data[] = array("$anterior", $quant2);
                $quant2 = 1;
            }
        } else {
            $quant2 = $quant2 + 1;
        }
        $anterior = $resultado;
    }
    $retorno['dado'] = $data;

    echo json_encode($retorno);
}

function AutoCompleta()
{
    $auto = filter_input(INPUT_POST, 'auto', FILTER_SANITIZE_STRING);
    $sql = "SELECT nome, documento FROM proprietarios
            WHERE nome LIKE '$auto%'";
    $conexao = new ConexaoCard();
    $result = $conexao->execQuerry($sql);
    $conexao->fecharConexao();

    $quant = count($result) - 1;
    $resposta = array();
    for ($i = 0; $i <= $quant; $i++) {
        $nome = $result[$i]['nome'];
        $documento = $result[$i]['documento'];
        $resposta[] = $nome . " - " . $documento;
    }
    echo json_encode($resposta);
}
