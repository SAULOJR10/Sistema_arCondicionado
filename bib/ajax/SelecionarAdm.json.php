<?php
include_once "../comum/conexao.php";

$acao = $_POST['acao'];

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
    $idEnt = $_POST['idEnt'];

    $sql = "SELECT bloco.id AS id_bloco, uhs.nome AS nome, prefixo, uhs.andar, tipo_local, bloco.nome AS bloconome, quant_andar, quant_subsolo FROM uhs 
    INNER JOIN bloco ON fk_bloco = bloco.id
    WHERE fk_entidade = '$idEnt' and status = true and gerenciada = true
    ORDER BY bloconome, nome";
    $exe = pg_query($GLOBALS['con'], $sql);

    $sql2 = "SELECT * FROM bloco WHERE fk_entidade = $idEnt ORDER BY nome";
    $exe2 = pg_query($GLOBALS['con'], $sql2);

    $bloco = array();
    $HTMLbloco = '';
    $espaco = '';
    $vetaux = array();

    while ($result2 = pg_fetch_assoc($exe2)) {
        $vetaux[$result2['id']]['quant'] = $result2['quant_andar'] + 1;
        $vetaux[$result2['id']]['nome'] =  $result2['nome'];
        $vetaux[$result2['id']]['quant_subsolo'] =  $result2['quant_subsolo'];
        if (!isset($bloco[$result2['id']])) {
            $bloco[$result2['id']] = array();
        }
        if (!isset($bloco[$result2['id']][''])) {
            $bloco[$result2['id']][''] = array();
        }
        if (!isset($bloco[$result2['id']][''][''])) {
            $bloco[$result2['id']][''][''] = "";
        }
    }

    while ($result = pg_fetch_assoc($exe)) {
        $andar = $result['andar'];
        $tipo_local = trim($result['tipo_local']);
        if (!isset($bloco[$result['id_bloco']])) {
            $bloco[$result['id_bloco']] = array();
        }
        if (!isset($bloco[$result['id_bloco']][$andar])) {
            $bloco[$result['id_bloco']][$andar] = array();
        }
        if (!isset($bloco[$result['id_bloco']][$andar][$tipo_local])) {
            $bloco[$result['id_bloco']][$andar][$tipo_local] = "";
        }
        if ($result['prefixo'] != '' && $result['prefixo'] != null) {
            $bloco[$result['id_bloco']][$andar][$tipo_local] .= " " . $result['prefixo'] . "-" . $result['nome'];
        } else {
            $bloco[$result['id_bloco']][$andar][$tipo_local] .= " " . $result['nome'];
        }
    }

    $i = 0;
    foreach ($bloco as $key => $value) {
        $i = $i + 1;
        $num1 = intval($vetaux[$key]["quant"]);
        $num2 = intval($vetaux[$key]["quant_subsolo"]);
        $teste = count($bloco);
        if ($num2 != 0 && $num2 != null) {
            $num3 =  $num1 + $num2;
            $auxb = "$espaco<tr> <td rowspan='" . $num3 . "'>" . $vetaux[$key]["nome"] . "</td>";
        } else {
            $auxb = "$espaco<tr> <td rowspan='" . $num1 . "'>" . $vetaux[$key]["nome"] . "</td>";
        }
        if (isset($vetaux[$key]["quant"])) {
            for ($index = -$vetaux[$key]["quant_subsolo"]; $index < $vetaux[$key]["quant"]; $index++) {
                if (isset($value[$index]['Sala']) && !isset($value[$index]['apartamento'])) {
                    $sala = $value[$index]['Sala'];
                    if ($index < 0) {
                        $HTMLbloco .= $auxb . "<td>Sub-Solo ($index)</td> <td></td> <td>$sala</td>";
                    } else if ($index == 0) {
                        $HTMLbloco .= $auxb . "<td>Térreo</td> <td></td> <td>$sala</td>";
                    } else {
                        $HTMLbloco .= $auxb . "<td>Andar $index</td> <td></td> <td>$sala</td>";
                    }
                } else if (isset($value[$index]['apartamento']) && !isset($value[$index]['Sala'])) {
                    $uh = $value[$index]['apartamento'];
                    if ($index < 0) {
                        $HTMLbloco .= $auxb . "<td>Sub-Solo ($index)</td> <td>$uh</td> <td></td>";
                    } else if ($index == 0) {
                        $HTMLbloco .= $auxb . "<td>Térreo</td> <td>$uh</td> <td></td>";
                    } else {
                        $HTMLbloco .= $auxb . "<td>Andar $index</td> <td>$uh</td> <td></td>";
                    }
                } else if (!isset($value[$index]['apartamento']) &&  !isset($value[$index]['Sala'])) {
                    if ($index < 0) {
                        $HTMLbloco .= $auxb . "<td>Sub-Solo ($index)</td> <td></td> <td></td>";
                    } else if ($index == 0) {
                        $HTMLbloco .= $auxb . "<td>Térreo</td> <td></td> <td></td>";
                    } else {
                        $HTMLbloco .= $auxb . "<td>Andar $index</td> <td></td> <td></td>";
                    }
                } else if (isset($value[$index]['apartamento']) &&  isset($value[$index]['apartamento'])) {
                    $uh = $value[$index]['apartamento'];
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
    $idLogin = $_POST['idUsuario'];

    $sql2 = "SELECT dados_entidade.id AS ident, nome_fantasia FROM dados_entidade
             INNER JOIN entidade_login on fk_entidade = dados_entidade.id
             Where fk_login = $idLogin and nome_fantasia != ''";
    $exe2 = pg_query($GLOBALS['con'], $sql2);

    $option = '<option value="">Selecione</option>";';
    while ($result2 = pg_fetch_assoc($exe2)) {
        $valor = $result2['nome_fantasia'];
        $id = $result2['ident'];
        $option .= "<option value='$id' id='optionEnt$id'>$valor</option>";
    }
    $select = "<div class='form-group'><select id='EntidadeGer' style='border-radius:10px;' class='form-control' onchange='EntSelected(\"normal\")'>$option</select></div>";
    echo json_encode($select);
}

function selectQuant()
{
    $idEnt = $_POST['idEnt'];
    $sql1 = "SELECT COUNT(uhs.nome) AS uhs FROM uhs
            INNER JOIN bloco ON fk_bloco = bloco.id
            WHERE fk_entidade = '$idEnt' and tipo_local = 'apartamento' and status = true and gerenciada = true";
    $exe1 = pg_query($sql1);
    $result1 = pg_fetch_assoc($exe1);
    $sql2 = "SELECT COUNT(uhs) AS salas FROM uhs
             INNER JOIN bloco ON fk_bloco = bloco.id
             WHERE fk_entidade = '$idEnt' and tipo_local = 'Sala' and status = true and gerenciada = true";
    $exe2 = pg_query($sql2);
    $result2 = pg_fetch_assoc($exe2);
    $sql3 = "SELECT COUNT(equipamento.id) AS ar_cond FROM equipamento
             INNER JOIN uhs ON uh = uhs.id
             INNER JOIN bloco ON fk_bloco = bloco.id
             WHERE fk_entidade = $idEnt and gerenciada = true";
    $exe3 = pg_query($sql3);
    $result3 = pg_fetch_assoc($exe3);
    $echo = $result1['uhs'] . ";" . $result3['ar_cond'] . ";" . $result2['salas'];
    echo json_encode($echo);
}

function MontarGerUH()
{
    $htmlUH = "<h5><b style='color:red'>Sem UH(s) nesse andar</b></h5>";
    $htmlSala = "<h5><b style='color:red'>Sem Sala(s) nesse andar</b></h5>";
    $teste = 0;
    $bloco = $_POST['bloco'];
    $andar = $_POST['andar'];
    $sql = "SELECT * FROM uhs WHERE fk_bloco = $bloco and andar = $andar and status = true and tipo_local = 'apartamento' ORDER BY nome";
    $exe = pg_query($GLOBALS['con'], $sql);
    $quant = pg_numrows($exe);

    $nomeUH = '';
    $idUH = '';
    $gerenciada = '';
    while ($result = pg_fetch_assoc($exe)) {
        if ($teste == 0) {
            $htmlUH = '';
            $teste = 1;
        }
        $nomeUH .= ';' . $result['nome'];
        $idUH .= ';' . $result['id'];
        $gerenciada .= ';' . $result['gerenciada'];
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
    $exe2 = pg_query($GLOBALS['con'], $sql2);
    $quant2 = pg_numrows($exe2);

    $nomeSala = '';
    $idSala = '';
    $salaGerenciada = '';
    while ($result2 = pg_fetch_assoc($exe2)) {
        if ($teste == 0) {
            $htmlSala = '';
            $teste = 1;
        }
        $nomeSala .= ';' . $result2['nome'];
        $idSala .= ';' . $result2['id'];
        $salaGerenciada .= ';' . $result2['gerenciada'];
    }

    $explodeSala = explode(';', $nomeSala);
    $explodeIdSala = explode(';', $idSala);
    $explodeSalaGer = explode(';', $salaGerenciada);
    $antes = $i;
    for ($i = $antes; $i < $quant2 + $antes; $i++) {
        if($i != 1){
            $o = $i - $antes;
        }else{
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
    $idEnt = $_POST['idEnt'];
    $sql = "SELECT * FROM bloco WHERE fk_entidade = $idEnt";
    $exe = pg_query($GLOBALS['con'], $sql);
    $option = '<option value="">Selecione</option>';
    while ($result = pg_fetch_assoc($exe)) {
        $Bloco = $result['nome'];
        $id = $result['id'];
        $option .= "<option value='$id'> $Bloco </option>";
    }

    echo json_encode($option);
}

function selectAndar()
{
    $idEnt = $_POST['idEnt'];
    $bloco = $_POST['idBloco'];
    $option = '<option value="">Selecione</option>';
    $sql = "SELECT * FROM bloco WHERE bloco.id = $bloco and fk_entidade = $idEnt";
    $exe = pg_query($GLOBALS['con'], $sql) or die("DEU RUIM !!!");
    $result = pg_fetch_assoc($exe);

    $quantAndar = $result['quant_andar'];
    $quantSubSolo = $result['quant_subsolo'];
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

function Selects(){
    $sql1 = "SELECT * FROM localizacao";
    $exe1 = pg_query($GLOBALS['con'], $sql1);
    $option = ';<option value="">Selecione</option>';
    while($result1 = pg_fetch_assoc($exe1)){
        $loc = $result1['nome'];
        $option .= "<option value='$loc'>$loc</option>" ;
    }
    $sql2 = "SELECT * FROM marca";
    $exe2 = pg_query($GLOBALS['con'], $sql2);
    $option .= ';<option value="">Selecione</option>';
    while($result2 = pg_fetch_assoc($exe2)){
        $marc = $result2['nome'];
        $option .= "<option value='$marc'>$marc</option>" ;
    }
    $sql3 = "SELECT * FROM modelo";
    $exe3 = pg_query($GLOBALS['con'], $sql3);
    $option .= ';<option value="">Selecione</option>';
    while($result3 = pg_fetch_assoc($exe3)){
        $mod = $result3['nome'];
        $option .= "<option value='$mod'>$mod</option>" ;
    }
    $sql4 = "SELECT * FROM potencia";
    $exe4 = pg_query($GLOBALS['con'], $sql4);
    $option .= ';<option value="">Selecione</option>';
    while($result4 = pg_fetch_assoc($exe4)){
        $pot = $result4['nome'];
        $option .= "<option value='$pot'>$pot</option>" ;
    }
    echo json_encode($option);
}