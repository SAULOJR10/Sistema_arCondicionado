<?php
include_once "../comum/conf.ini.php";

$acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);

switch ($acao) {
    case 'tabela':
        tabela();
        break;
    case 'selectEnt':
        selectEnt();
        break;
    case 'infoTela':
        selectQuant();
        break;
    case 'SelectBloco':
        SelectBloco();
        break;
    case 'SelectAndar':
        SelectAndar();
        break;
    case 'MontarGerUH':
        MontarGerUH();
        break;
    case 'selects':
        Selects();
        break;
}

function tabela()
{
    $idEnt = filter_input(INPUT_POST, 'idEnt', FILTER_SANITIZE_STRING);
    $conexao = new ConexaoCard();
    $sql = "SELECT bloco.id AS id_bloco, uhs.nome AS nome, prefixo, uhs.andar, tipo_local, bloco.nome AS bloconome, quant_andar, quant_subsolo FROM uhs 
            INNER JOIN bloco ON fk_bloco = bloco.id
            WHERE fk_entidade = '$idEnt' and status = true and gerenciada = true
            ORDER BY bloconome, nome";
    $result = $conexao->execQuerry($sql);

    $sql2 = "SELECT * FROM bloco WHERE fk_entidade = $idEnt ORDER BY nome";
    $result2 = $conexao->execQuerry($sql2);
    $conexao->fecharConexao();

    $bloco = array();
    $HTMLbloco = '';
    $espaco = '';
    $vetaux = array();

    $quant = count($result2) -1;
    for ($i = 0; $i <= $quant; $i++) {
        $vetaux[$result2[$i]['id']]['quant'] = $result2[$i]['quant_andar'] + 1;
        $vetaux[$result2[$i]['id']]['nome'] =  $result2[$i]['nome'];
        $vetaux[$result2[$i]['id']]['quant_subsolo'] =  $result2[$i]['quant_subsolo'];
        if (!isset($bloco[$result2[$i]['id']])) {
            $bloco[$result2[$i]['id']] = array();
        }
        if (!isset($bloco[$result2[$i]['id']][''])) {
            $bloco[$result2[$i]['id']][''] = array();
        }
        if (!isset($bloco[$result2[$i]['id']][''][''])) {
            $bloco[$result2[$i]['id']][''][''] = "";
        }
    }

    $quant2 = count($result) -1;
    for($i = 0; $i <= $quant2; $i++) {
        $andar = $result[$i]['andar'];
        $tipo_local = trim($result[$i]['tipo_local']);
        if (!isset($bloco[$result[$i]['id_bloco']])) {
            $bloco[$result[$i]['id_bloco']] = array();
        }
        if (!isset($bloco[$result[$i]['id_bloco']][$andar])) {
            $bloco[$result[$i]['id_bloco']][$andar] = array();
        }
        if (!isset($bloco[$result[$i]['id_bloco']][$andar][$tipo_local])) {
            $bloco[$result[$i]['id_bloco']][$andar][$tipo_local] = "";
        }
        if ($result[$i]['prefixo'] != '' && $result[$i]['prefixo'] != null) {
            $bloco[$result[$i]['id_bloco']][$andar][$tipo_local] .= " " . $result[$i]['prefixo'] . "-" . $result[$i]['nome'];
        } else {
            $bloco[$result[$i]['id_bloco']][$andar][$tipo_local] .= " " . $result[$i]['nome'];
        }
    }

    $i = 0;
    foreach ($bloco as $key => $value) {
        $i = $i + 1;
        $num1 = intval($vetaux[$key]["quant"]);
        $num2 = intval($vetaux[$key]["quant_subsolo"]);
        if ($num2 != 0 && $num2 != null) {
            $num3 =  $num1 + $num2;
            $auxb = "$espaco<tr> <td rowspan='" . $num3 . "'>" . $vetaux[$key]["nome"] . "</td>";
        } else {
            $auxb = "$espaco<tr> <td rowspan='" . $num1 . "'>" . $vetaux[$key]["nome"] . "</td>";
        }
        if (isset($vetaux[$key]["quant"])) {
            for ($index = -$vetaux[$key]["quant_subsolo"]; $index < $vetaux[$key]["quant"]; $index++) {
                if (isset($value[$index]['Sala']) && !isset($value[$index]['UH'])) {
                    $sala = $value[$index]['Sala'];
                    if ($index < 0) {
                        $HTMLbloco .= $auxb . "<td>Sub-Solo ($index)</td> <td></td> <td>$sala</td>";
                    } else if ($index == 0) {
                        $HTMLbloco .= $auxb . "<td>Térreo</td> <td></td> <td>$sala</td>";
                    } else {
                        $HTMLbloco .= $auxb . "<td>Andar $index</td> <td></td> <td>$sala</td>";
                    }
                } else if (isset($value[$index]['UH']) && !isset($value[$index]['Sala'])) {
                    $uh = $value[$index]['UH'];
                    if ($index < 0) {
                        $HTMLbloco .= $auxb . "<td>Sub-Solo ($index)</td> <td>$uh</td> <td></td>";
                    } else if ($index == 0) {
                        $HTMLbloco .= $auxb . "<td>Térreo</td> <td>$uh</td> <td></td>";
                    } else {
                        $HTMLbloco .= $auxb . "<td>Andar $index</td> <td>$uh</td> <td></td>";
                    }
                } else if (!isset($value[$index]['UH']) &&  !isset($value[$index]['Sala'])) {
                    if ($index < 0) {
                        $HTMLbloco .= $auxb . "<td>Sub-Solo ($index)</td> <td></td> <td></td>";
                    } else if ($index == 0) {
                        $HTMLbloco .= $auxb . "<td>Térreo</td> <td></td> <td></td>";
                    } else {
                        $HTMLbloco .= $auxb . "<td>Andar $index</td> <td></td> <td></td>";
                    }
                } else if (isset($value[$index]['UH']) &&  isset($value[$index]['UH'])) {
                    $uh = $value[$index]['UH'];
                    $sala = $value[$index]['Sala'];
                    if ($index < 0) {
                        $HTMLbloco .= $auxb . "<td>Sub-Solo ($index)</td> <td>$uh</td> <td>$sala</td>";
                    } else if ($index == 0) {
                        $HTMLbloco .= $auxb . "<td>Térreo</td> <td>$uh</td> <td>$sala</td>";
                    } else {
                        $HTMLbloco .= $auxb . "<td>Andar $index</td> <td>$uh</td> <td>$sala</td>";
                    }
                }
                $auxb = "<tr>";
            }
        }
        $espaco = "<tr style='background-color:white;'>
                        <td style='border-right: 0px;'></td>
                        <td style='border-right: 0px;'></td>
                        <td style='border-right: 0px;'></td>
                        <td></td>
                   </tr>";
    }

    if ($HTMLbloco != ' ') {
        $HTMLbloco = "<table id='demo-table'>
                    <thead>
                        <tr class='head'>
                            <th style='width:150px;'>Blocos</th>
                            <th style='width:200px;'>Andares</th>
                            <th style='width:500px;'>Apartamentos</th>
                            <th style='width:300px;'>Salas</th>
                        </tr>
                    </thead>
                    <tbody>
                    $HTMLbloco
                    </tbody>
                </table>";
        echo json_encode($HTMLbloco);
    }
}

function SelectEnt()
{
    $idLogin = filter_input(INPUT_POST, 'idUsuario', FILTER_SANITIZE_STRING);
    $conexao = new ConexaoCard();
    $sql = "SELECT dados_entidade.id AS ident, nome_fantasia FROM dados_entidade
             INNER JOIN entidade_login on fk_entidade = dados_entidade.id
             Where fk_login = $idLogin and nome_fantasia != ''";
    $result = $conexao->execQuerry($sql);
    $conexao->fecharConexao();

    $quant = count($result) -1;
    $option = '<option value="">Selecione</option>";';
    for ($i = 0; $i <= $quant; $i++) {
        $valor = $result[$i]['nome_fantasia'];
        $id = $result[$i]['ident'];
        $option .= "<option value='$id' id='optionEnt$id'>$valor</option>";
    }
    $select = "<div class='form-group'><select id='EntidadeGer' style='border-radius:10px;' class='form-control' onchange='EntSelected(\"normal\")'>$option</select></div>";
    echo json_encode($select);
}

function selectQuant()
{
    $idEnt = filter_input(INPUT_POST, 'idEnt', FILTER_SANITIZE_STRING);
    $conexao = new ConexaoCard();
    $sql1 ="SELECT COUNT(uhs.nome) AS uhs FROM uhs
            INNER JOIN bloco ON fk_bloco = bloco.id
            WHERE fk_entidade = '$idEnt' and tipo_local = 'UH' and status = true and gerenciada = true";
    $result1 = $conexao->execQuerry($sql1);

    if ($result1 == null) {
        $uhs = 0;
    } else {
        $uhs = $result1[0]['uhs'];
    }

    $sql2 = "SELECT COUNT(uhs) AS salas FROM uhs
             INNER JOIN bloco ON fk_bloco = bloco.id
             WHERE fk_entidade = '$idEnt' and tipo_local = 'Sala' and status = true and gerenciada = true";
    $result2 = $conexao->execQuerry($sql2);

    if ($result1 == null) {
        $salas = 0;
    } else {
        $salas = $result2[0]['salas'];
    }

    $sql3 = "SELECT COUNT(equipamento.id) AS ar_cond FROM equipamento
             INNER JOIN uhs ON uh = uhs.id
             INNER JOIN bloco ON fk_bloco = bloco.id
             WHERE fk_entidade = $idEnt and gerenciada = true";
    $result3 = $conexao->execQuerry($sql3);
    $conexao->fecharConexao();
    if ($result1 == null) {
        $ar_cond = 0;
    } else {
        $ar_cond = $result3[0]['ar_cond'];
    }

    $echo = $uhs . ";" . $ar_cond . ";" . $salas;
    echo json_encode($echo);
}

function MontarGerUH()
{
    $htmlUH = "<h5><b style='color:red'>Sem UH(s) nesse andar</b></h5>";
    $htmlSala = "<h5><b style='color:red'>Sem Sala(s) nesse andar</b></h5>";
    $teste = 0;
    $bloco = filter_input(INPUT_POST, 'bloco', FILTER_SANITIZE_STRING);
    $andar = filter_input(INPUT_POST, 'andar', FILTER_SANITIZE_STRING);
    $conexao = new ConexaoCard();
    $sql = "SELECT * FROM uhs WHERE fk_bloco = $bloco and andar = $andar and status = true and tipo_local = 'UH' ORDER BY nome";
    $result1 = $conexao->execQuerry($sql);
    
    $quant = count($result1) -1;
    $nomeUH = '';
    $idUH = '';
    $gerenciada = '';
    for ($i = 0; $i <= $quant; $i++) {
        if ($teste == 0) {
            $htmlUH = '';
            $teste = 1;
        }
        $nomeUH .= ';' . $result1[$i]['nome'];
        $idUH .= ';' . $result1[$i]['id'];
        $gerenciada .= ';' . $result1[$i]['gerenciada'];
    }
    $teste = 0;

    $explodeUH = explode(';', $nomeUH);
    $explodeIdUH = explode(';', $idUH);
    $explodeGer = explode(';', $gerenciada);
    for ($i = 1; $i <= $quant; $i++) {
        $uh = $explodeUH[$i];
        $iduh = $explodeIdUH[$i];
        $ger = $explodeGer[$i];
        if ($ger == 't') {
            $selected = "checked";
        } else {
            $selected = "";
        }
        $htmlUH .= "<div class='col-sm-3' style='padding:0%;'>
                                <h5 style='float: left;'>UH $uh</h5>
                                <div class='col-xs-3 ' style='padding-right: 0px; padding-left:0px; margin:3% 0% 0% 3%;'>
                                    <input type='hidden' value='$iduh'  id='gerenciada$i'>
                                    <input id='ch_UH$i' name='allUHS' class='switch switch--shadow' type='checkbox' $selected>
                                    <label style='float:right; min-width: 40px;' for='ch_UH$i'></label>
                                </div>
                                <i class='fas fa-pencil-alt' style='margin-top:5%; margin-left:3%;' onclick='AbrirModal(\"CadProp\", \"$uh\", \"$iduh\")'></i>
                            </div>";
    }

    $sql2 = "SELECT * FROM uhs WHERE fk_bloco = $bloco and andar = $andar and status = true and tipo_local = 'Sala' ORDER BY nome";
    $result2 = $conexao->execQuerry($sql2);
    $conexao->fecharConexao();

    $quant2 = count($result2) -1;
    $nomeSala = '';
    $idSala = '';
    $salaGerenciada = '';
    for ($i = 0; $i <= $quant2; $i++) {
        if ($teste == 0) {
            $htmlSala = '';
            $teste = 1;
        }
        $nomeSala .= ';' . $result2[$i]['nome'];
        $idSala .= ';' . $result2[$i]['id'];
        $salaGerenciada .= ';' . $result2[$i]['gerenciada'];
    }

    $explodeSala = explode(';', $nomeSala);
    $explodeIdSala = explode(';', $idSala);
    $explodeSalaGer = explode(';', $salaGerenciada);
    $antes = $i;
    for ($i = $antes; $i < $quant2 + $antes; $i++) {
        if ($i != 1) {
            $o = $i - $antes;
        } else {
            $o = $i;
        }
        $sala = $explodeSala[$o];
        $idsala = $explodeIdSala[$o];
        $salaGer = $explodeSalaGer[$o];
        if ($salaGer == 't') {
            $selected = "checked";
        } else {
            $selected = "";
        }
        $htmlSala .= "<div class='col-sm-3' style='padding:0%;'>
                    <h5 style='float: left;'>Sala $sala</h5>
                    <div class='col-xs-3 ' style='padding-right: 0px; padding-left:0px; margin:3% 0% 0% 3%;'>
                        <input type='hidden' value='$idsala'  id='gerenciada$i'>
                        <input id='ch_UH$i' name='allUHS' class='switch switch--shadow' type='checkbox' $selected>
                        <label style='float:right; min-width: 40px;' for='ch_UH$i'></label>
                    </div>
                    <i class='fas fa-pencil-alt' style='margin-top:5%; margin-left:3%;' onclick='AbrirModal(\"CadProp\", \"$sala\", \"$idsala\")'></i>
                </div>";
    }

    $html = "<div class='row'>
                <div class='col-sm-12' style='border-bottom:solid white 10px;'>
                <h5><b>UH(s):</b></h5>
                   $htmlUH
                </div>
                <div class='col-sm-12' style='border-bottom:solid white 10px;'>
                <h5><b>Sala(s):</b></h5>
                   $htmlSala
                </div>
              </div>";
    echo json_encode($html);
}

function SelectBloco()
{
    $idEnt = filter_input(INPUT_POST, 'idEnt', FILTER_SANITIZE_STRING);
    $conexao = new ConexaoCard();
    $sql1 = "SELECT * FROM bloco WHERE fk_entidade = $idEnt";
    $result1 = $conexao->execQuerry($sql1);
    $conexao->fecharConexao();

    $quant = count($result1) -1;
    $option = '<option value="">Selecione</option>';
    for ($i = 0; $i <= $quant; $i++) {
        $Bloco = $result1[$i]['nome'];
        $id = $result1[$i]['id'];
        $option .= "<option value='$id'> $Bloco </option>";
    }
    echo json_encode($option);
}

function selectAndar()
{
    $idEnt = filter_input(INPUT_POST, 'idEnt', FILTER_SANITIZE_STRING);
    $bloco = filter_input(INPUT_POST, 'idBloco', FILTER_SANITIZE_STRING);
    $option = '<option value="">Selecione</option>';
    $conexao = new ConexaoCard();
    $sql = "SELECT * FROM bloco WHERE bloco.id = $bloco and fk_entidade = $idEnt";
    $result = $conexao->execQuerry($sql);
    $conexao->fecharConexao();

    $quantAndar = $result[0]['quant_andar'];
    $quantSubSolo = $result[0]['quant_subsolo'];
    if ($quantSubSolo != 0) {
        for ($i = 1; $i <= $quantSubSolo; $i++) {
            $SubSolo = '-' . $i;
            $option .= "<option value='$SubSolo'>SubSolo ($SubSolo) </option>";
        }
    }
    for ($i = 0; $i <= $quantAndar; $i++) {
        if ($i == 0) {
            $option .= "<option value='$i'>Térreo</option>";
        } else {
            $option .= "<option value='$i'>Andar $i</option>";
        }
    }
    $html = "<h5 style='margin: 0%'>Andar:</h5><select id='andarGer' onchange='MontarGerUH($bloco)' style='height:30px; border:solid lightgray 1px; width:100%; margin-top:2.2%;'> $option </select>";
    echo json_encode($html);
}

function Selects()
{
    $conexao = new ConexaoCard();
    $sql1 = "SELECT * FROM localizacao";
    $result1 = $conexao->execQuerry($sql1);
    
    $quant1 =  count($result1) -1;
    $option = ';<option value="">Selecione</option>';
    for ($i = 0; $i <= $quant1; $i++) {
        $loc = $result1[$i]['nome'];
        $option .= "<option value='$loc'>$loc</option>";
    }

    $sql2 = "SELECT * FROM marca";
    $result2 = $conexao->execQuerry($sql2);

    $quant2 = count($result2) -1;
    $option .= ';<option value="">Selecione</option>';
    for ($i = 0; $i <= $quant2; $i++) {
        $marc = $result2[$i]['nome'];
        $option .= "<option value='$marc'>$marc</option>";
    }
    
    $sql3 = "SELECT * FROM modelo";
    $result3 = $conexao->execQuerry($sql3);
    
    $quant3 = count($result3) -1;
    $option .= ';<option value="">Selecione</option>';
    for ($i = 0; $i <= $quant3; $i++) {
        $mod = $result3[$i]['nome'];
        $option .= "<option value='$mod'>$mod</option>";
    }

    $sql4 = "SELECT * FROM potencia";
    $result4 = $conexao->execQuerry($sql4);
    $conexao->fecharConexao();

    $quant4 = count($result4) -1;
    $option .= ';<option value="">Selecione</option>';
    for ($i = 0; $i <= $quant4; $i++) {
        $pot = $result4[$i]['nome'];
        $option .= "<option value='$pot'>$pot</option>";
    }
    echo json_encode($option);
}
