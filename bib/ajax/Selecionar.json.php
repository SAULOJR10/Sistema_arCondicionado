<?php
include_once "../comum/conexao.php";

// error_reporting(0);

$acao = $_POST['acao'];

switch ($acao) {
    case 'tabela':
        tabela();
        break;
    case 'montarEditSala':
        montarEditSala();
        break;
    case 'MontarEditUH':
        MontarEditUH();
        break;
    case 'addUHS':
        ADDUHS();
        break;
    case 'edit':
        Edit();
        break;
    case 'selectEnt':
        selectEnt('selectEnt');
        break;
    case 'SelectBlocos':
        selectBlocos();
        break;
    case 'SelectAndar':
        selectAndar();
        break;
    case 'ultimaEnt':
        selectEnt('ultimaEnt');
        break;
    case 'selecttabela':
        selectEnt('ultimaEnt');
        break;
    case 'SoUma':
        selectEnt('SoUma');
        break;
    case 'SoUma3':
        selectEnt('SoUma');
        break;
    case 'infoTela':
        selectQuant();
        break;
    case 'cad':
        CadSala();
        break;
    case 'tutorialParte1':
        Tutorial('Parte1');
        break;
    case 'tutorialParte2':
        Tutorial('Parte2');
        break;
    case 'tutorialParte3':
        Tutorial('Parte3');
        break;
}
function CadSala()
{
    $idEnt = $_POST['idEnt'];
    $sql = "SELECT COUNT(*) AS quantbloco FROM bloco
            WHERE fk_entidade = $idEnt";
    $exe = pg_query($GLOBALS['con'], $sql);
    $quant = pg_fetch_assoc($exe)['quantbloco'];
    // $quant = intval($quant);

    $proximo = $quant + 1;

    echo json_encode($proximo);
}

function selectQuant()
{
    $idEnt = $_POST['idEnt'];
    $sql1 = "SELECT COUNT(bloco) AS bloco FROM bloco
    WHERE fk_entidade = '$idEnt'";
    $exe1 = pg_query($sql1);
    $result1 = pg_fetch_assoc($exe1);
    $sql2 = "SELECT SUM(quant_andar) AS andar FROM bloco
    WHERE fk_entidade = '$idEnt'";
    $exe2 = pg_query($sql2);
    $result2 = pg_fetch_assoc($exe2);
    if ($result2['andar'] == null) {
        $andar = 0;
    } else {
        $andar = $result2['andar'];
    }
    $sql3 = "SELECT COUNT(uhs.nome) AS uhs FROM uhs
            INNER JOIN bloco ON fk_bloco = bloco.id
            WHERE fk_entidade = '$idEnt' and tipo_local = 'apartamento' and status = true";
    $exe3 = pg_query($sql3);
    $result3 = pg_fetch_assoc($exe3);
    $sql4 = "SELECT COUNT(uhs) AS salas FROM uhs
             INNER JOIN bloco ON fk_bloco = bloco.id
             WHERE fk_entidade = '$idEnt' and tipo_local = 'Sala' and status = true";
    $exe4 = pg_query($sql4);
    $result4 = pg_fetch_assoc($exe4);
    $sql5 = "SELECT COUNT(id) AS eng FROM dados_engenheiro
             WHERE fk_entidade = '$idEnt'";
    $exe5 = pg_query($sql5);
    $result5 = pg_fetch_assoc($exe5);
    $echo = $result1['bloco'] . ";" . $andar . ";" . $result3['uhs'] . ";" . $result4['salas'] . ";" . $result5['eng'];
    echo json_encode($echo);
}

function SelectEnt($acao)
{
    if ($acao == 'selectEnt') {
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
    } else if ($acao == 'ultimaEnt') {
        $sql = "SELECT * FROM dados_entidade ORDER BY id DESC limit 1";
        $exe = pg_query($GLOBALS['con'], $sql);
        $result = pg_fetch_assoc($exe);
        $idEnt = $result['id'];
        $nomeEnt = $result['nome_fantasia'];
        $html = "<input type='hidden' id='idEnt' value='$idEnt'>$nomeEnt";
        echo json_encode($html);
    } else if ($acao == 'SoUma') {
        $idLogin = $_POST['idUsuario'];
        $sql = "SELECT dados_entidade.id, dados_entidade.nome_fantasia FROM dados_entidade
                 INNER JOIN entidade_login ON fk_entidade = dados_entidade.id
                 WHERE fk_login = $idLogin";
        $exe = pg_query($GLOBALS['con'], $sql);
        $result = pg_fetch_assoc($exe);

        $nome = $result['nome_fantasia'];
        $id = $result['id'];

        $html = "<input type='hidden' id='idEnt' value='$id'/>$nome";

        echo json_encode($html);
    }
}

function selectBlocos()
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
    $html = "<h5>Selecione o bloco:</h5><select id='blocoSala' onchange='limpar()' style='width:80%;'>$option</select>";

    echo json_encode($html);
}

function selectAndar()
{
    $idEnt = $_POST['idEnt'];
    $bloco = $_POST['bloco'];
    $option = '<option value="">Selecione</option>';
    $sql2 = "SELECT * FROM bloco
             INNER JOIN dados_entidade ON fk_entidade = dados_entidade.id
             WHERE bloco.id = $bloco and fk_entidade = $idEnt";
    $exe2 = pg_query($GLOBALS['con'], $sql2) or die("DEU RUIM !!!");
    $result2 = pg_fetch_assoc($exe2);

    $quantAndar = $result2['quant_andar'];
    $quantSubSolo = $result2['quant_subsolo'];
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
    echo json_encode($option);
}

function tabela()
{
    $idEnt = $_POST['idEnt'];

    $sql = "SELECT bloco.id AS id_bloco, uhs.nome AS nome, prefixo, uhs.andar, tipo_local, bloco.nome AS bloconome, quant_andar, quant_subsolo FROM uhs 
    INNER JOIN bloco ON fk_bloco = bloco.id
    WHERE fk_entidade = '$idEnt' and status = true
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
            $auxb = "$espaco<tr> <td rowspan='" . $num3 . "'><i class='fas fa-pen' onclick='Edit($key,$i)' style='font-size: 1.2rem;'>&nbsp;&nbsp;</i>" . $vetaux[$key]["nome"] . "</td>";
        } else {
            $auxb = "$espaco<tr> <td rowspan='" . $num1 . "'><i class='fas fa-pen' onclick='Edit($key,$i)' style='font-size: 1.2rem;'>&nbsp;&nbsp;</i>" . $vetaux[$key]["nome"] . "</td>";
        }
        if (isset($vetaux[$key]["quant"])) {
            for ($index = -$vetaux[$key]["quant_subsolo"]; $index < $vetaux[$key]["quant"]; $index++) {
                if (isset($value[$index]['Sala']) && !isset($value[$index]['apartamento'])) {
                    $sala = $value[$index]['Sala'];
                    if ($index < 0) {
                        $HTMLbloco .= $auxb . "<td>Sub-Solo ($index)</td> <td></td> <td><i class='fas fa-pen' onclick='MontarUpdateSala($key, $index)' style='font-size: 1.2rem;'></i>&nbsp;&nbsp;$sala</td>";
                    } else if ($index == 0) {
                        $HTMLbloco .= $auxb . "<td>Térreo</td> <td></td> <td><i class='fas fa-pen' onclick='MontarUpdateSala($key, $index)' style='font-size: 1.2rem;'></i>&nbsp;&nbsp;$sala</td>";
                    } else {
                        $HTMLbloco .= $auxb . "<td>Andar $index</td> <td></td> <td><i class='fas fa-pen' onclick='MontarUpdateSala($key, $index)' style='font-size: 1.2rem;'></i>&nbsp;&nbsp;$sala</td>";
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
                        $HTMLbloco .= $auxb . "<td>Sub-Solo ($index)</td> <td>$uh</td> <td><i class='fas fa-pen' onclick='MontarUpdateSala($key, $index)' style='font-size: 1.2rem;'></i>&nbsp;&nbsp;$sala</td>";
                    } else if ($index == 0) {
                        $HTMLbloco .= $auxb . "<td>Térreo</td> <td>$uh</td> <td><i class='fas fa-pen' onclick='MontarUpdateSala($key, $index)' style='font-size: 1.2rem;'></i>&nbsp;&nbsp;$sala</td>";
                    } else {
                        $HTMLbloco .= $auxb . "<td>Andar $index</td> <td>$uh</td> <td><i class='fas fa-pen' onclick='MontarUpdateSala($key, $index)' style='font-size: 1.2rem;'></i>&nbsp;&nbsp;$sala</td>";
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

function Tutorial($parte)
{
    $html = '';
    switch ($parte) {
        case 'Parte1':
            $idLogin = $_POST['idLogin'];
            $sql = "SELECT * FROM entidade_login WHERE fk_login = $idLogin";
            $exe = pg_query($GLOBALS['con'], $sql);
            $result = pg_fetch_assoc($exe);
            if ($result['id'] == '') {
                $html = "<div style='margin-left:38%'>
                            <h3 style='margin-top: 5%;'>Seja bem vindo!</h3>
                            <h3 style='float: left; margin-top:0%;'>Comece por aqui</h3>
                            <img src='bib/img/setaVermelha.png' style='height:100px; margin-top: -70px; margin-left:2%;'>
                        </div>";
                echo json_encode($html);
            }else{
                $html = "0";
                echo json_encode($html);
            }
            break;
        case 'Parte2':
            $idLogin = $_POST['idLogin'];
            $sql = "SELECT * FROM dados_engenheiro
            INNER JOIN dados_entidade ON dados_engenheiro.fk_entidade = dados_entidade.id
            INNER JOIN entidade_login ON entidade_login.fk_entidade = dados_entidade.id
            WHERE fk_login = $idLogin";
            $exe = pg_query($GLOBALS['con'], $sql);
            $result = pg_fetch_assoc($exe);

            $sql2 = "SELECT COUNT(id) AS quant FROM entidade_login WHERE fk_login = $idLogin";
            $exe2 = pg_query($GLOBALS['con'], $sql2);
            $result2 = pg_fetch_assoc($exe2)['quant'];

            $sql3 = "SELECT COUNT(dados_engenheiro.id) AS quant FROM dados_engenheiro
            INNER JOIN dados_entidade ON dados_engenheiro.fk_entidade = dados_entidade.id
            INNER JOIN entidade_login ON entidade_login.fk_entidade = dados_entidade.id
            WHERE fk_login = $idLogin";
            $exe3 = pg_query($GLOBALS['con'], $sql3);
            $result3 = pg_fetch_assoc($exe3)['quant'];

            $html = 0;

            if ($result['id'] == '' && $result2 == 1 && $result3 == 0) {
                $html = "<div style='margin-left:34%'>
                            <h3 style='margin-top: 5%;'>Entidade cadastrada!</h3>
                            <h3 style='margin-top: 0%;'>Vamos Continuar ???</h3>
                            <h3 style='float: left; margin-top:0%;'>Cadastre o(s) Engenheiro(s)</h3>
                            <img src='bib/img/setaVermelha.png' style='height:100px; margin-top: -100px; margin-left:2%;'>
                        </div>";
                echo json_encode($html);
            } else {
                echo json_encode($html);
            }
            break;
        case 'Parte3':
            $idEnt = $_POST['idEnt'];
            $sql = "SELECT * FROM bloco WHERE fk_entidade = $idEnt";
            $exe = pg_query($GLOBALS['con'], $sql);
            $result = pg_fetch_assoc($exe);
            $html = 0;
            if ($result['id'] == '') {
                $html = "<div style='margin-left:46%;'>
                                <h3 style='margin-top: 10%;'>Agora só falta as estruturas...</h3>
                                <h3 style='margin: 0%;float:left;'>escolha por onde continuar</h3>
                                <img src='bib/img/setaVermelha.png' style='height:100px; margin-top:-80px; margin-left:2%;'>
                            </div>";
                echo json_encode($html);
            } else {
                echo json_encode($html);
            }
            break;
    }
}

function Edit()
{
    $idEnt = $_POST['idEnt'];
    $idBloco = $_POST['idBloco'];

    $sql = "SELECT * FROM bloco WHERE fk_entidade = $idEnt and bloco.id = $idBloco";
    $exe = pg_query($GLOBALS['con'], $sql);
    $result = pg_fetch_assoc($exe);

    $sql2 = "SELECT * FROM uhs WHERE fk_bloco = $idBloco";
    $exe2 = pg_query($GLOBALS['con'], $sql2);
    $result2 = pg_fetch_assoc($exe2);
    $idApart = $result2['prefixo'];

    $quant_andar = $result['quant_andar'];
    $quantSub = $result['quant_subsolo'];
    $HTMLandar = '';
    $nome = $result['nome'];
    for ($i = -$quantSub; $i <= $quant_andar; $i++) {

        if ($i == 0) {
            $HTMLandar .= "<div class='col-sm-3' style='margin-bottom: 1%;'>"
                . "<h5 style='margin:0%;'>Térreo: &nbsp</h5>"
                . "<div id='dv_grafic'>"
                . "<button style='padding:5px; text-align:right; margin-bottom:3%; margin-top:0%; width:88%; height:25px; font-size:1.2rem;' readonly='readonly' onclick='MontarEditUH($idEnt, $idBloco, $i)' class='fourth'>"
                . "<i class='fas fa-pen' style='font-size: 1.2rem;'>&nbsp;</i>Editar UHs"
                . "</button>"
                . "<button style='padding:5px; text-align:right; margin-bottom:3%; margin-top:0%; width:88%; height:25px; font-size:1.2rem;' readonly='readonly' onclick='MontarAddUH($idEnt, $idBloco, $i)' class='fourth'>"
                . "<i class='fas fa-plus' style='font-size: 1.2rem;'>&nbsp;</i>Adicionar UHs"
                . "</button>"
                . "</div>"
                . "</div>";
        } else if ($i > 0) {
            $HTMLandar .= "<div class='col-sm-3' style='margin-bottom: 1%;'>"
                . "<h5 style='margin:0%;'>Andar $i:</h5>"
                . "<div id='dv_grafic'>"
                . "<button style='padding:5px; text-align:right; margin-bottom:3%; margin-top:0%; width:88%; height:25px; font-size:1.2rem;' readonly='readonly' onclick='MontarEditUH($idEnt, $idBloco, $i)' class='fourth'>"
                . "<i class='fas fa-pen' style='font-size: 1.2rem;'>&nbsp;</i>Editar UHS"
                . "</button>"
                . "<button style='padding:5px; text-align:right; margin-bottom:3%; margin-top:0%; width:88%; height:25px; font-size:1.2rem;' readonly='readonly' onclick='MontarAddUH($idEnt, $idBloco, $i)' class='fourth'>"
                . "<i class='fas fa-plus' style='font-size: 1.2rem;'>&nbsp;</i>Adicionar UHs"
                . "</button>"
                . "</div>"
                . "</div>";
        }
    }

    $umSub = '';
    $doisSub = '';
    if ($quantSub == 1) {
        $umSub = 'checked';
    }
    if ($quantSub == 2) {
        $umSub = 'checked';
        $doisSub = 'checked';
    }

    $html = "<div class='row'>
                <div class='col-sm-12 cadastro' style='padding:0%; padding-left:2%;'>
                    <h4><b>Edite $nome</b></h4>
                    <input type='hidden' id='idBlocoEdit' value='$idBloco'>
                </div>
            </div>
            <div class='row cadastro' style='margin-bottom:10px;'>

                <div class='col-sm-3'>
                    <div class='numeracao' style='padding-top: 2.5%;'>1</div>
                    <h5 style='margin-top: 5%;'><b>Nome e Andar</b></h5>
                    <div class='col-sm-12' style='padding:0%;'>
                        <p style='background-color: rgb(194,228,255, 0.56); font-size:16px; text-align:center; margin-top: 10px; width:74%; padding-top:5px; padding-bottom:5px;'><b>$nome</b></p><br>
                        <input type='hidden' id='nomePadraoEdit' value='$nome'>
                        <h5 style='margin: 0%;'>Nome (opcional):</h5>
                        <input type='text' id='nomeEdit' value='$nome' style='margin-top: 2px; border:solid lightgray 1px;  width:74%; margin-bottom: 5%;'>
                        <h5 style='margin: 0%;'>Quantidade de andares:</h5>
                        <input type='number' min='0' value='$quant_andar' id='quantAndarEdit' style='margin-top: 2px; border:solid lightgray 1px;  width:74%;'>
                        <div class='col-sm-6' style='padding: 0%;'>
                            <p>SubSolo (-1)</p>
                        </div>
                        <div class='col-sm-6'>
                            <div class='col-xs-3' style='padding-right: 0px; padding-left:0px; margin:2% 5% 0% 20%;'>
                                <input id='ch_SubEdit01' onclick='SubSolo(\"SubEdit01\")' name='SubSoloEdit' class='switch switch--shadow' type='checkbox' $umSub>
                                <label style='float:right; min-width: 40px;' for='ch_SubEdit01'></label>
                            </div>
                        </div>
                        <div class='col-sm-6' style='padding: 0%;'>
                            <p>SubSolo (-2)</p>
                        </div>
                        <div class='col-sm-6'>
                            <div class='col-xs-3' style='padding-right: 0px; padding-left:0px; margin:2% 5% 0% 20%;'>
                                <input id='ch_SubEdit02' onclick='SubSolo(\"SubEdit02\")' name='SubSoloEdit' class='switch switch--shadow' type='checkbox' $doisSub>
                                <label style='float:right; min-width: 40px;' for='ch_SubEdit02'></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='col-sm-8'>
                    <div class='numeracao'>2</div>
                    <h5 style='margin-top: 1.7%;'><b>Quantidade de UH(s) por andar:</b></h5>
                        <div class='col-sm-12'>
                        <div class='form-group' style='float: right;'>
                        <h5 style='margin-left:15%; margin-top: 4px;'>prefixo antes do numero do apartamento:</h5>
                        <input type='text' style='height: 20px; font-size: 12px; text-align: left; width: 15%; padding: 1%;' value='$idApart' class='form-control' id='prefixoUHEdit' maxlength='1' placeholder='ex: A-101'>
                    </div>
                </div>
                    <div id='AndarEdit'>
                        $HTMLandar
                    </div>
                </div>
                <div class='col-sm-1' onclick='updateBloco()' style='background-color:white;'>
                    <h5 style='margin-top: 25%;margin-bottom: 6%; margin-left:11%;'><b>Gravar</b></h5>
                    <i class='far fa-save' style='font-size: 3.5rem;margin-left:22.5%; margin-bottom:25%;'></i>
                </div>
            </div>";

    echo json_encode($html);
}

function MontarEditUH()
{
    $idEnt = $_POST['idEnt'];
    $idBloco = $_POST['idBloco'];
    $Andar = $_POST['Andar'];

    $sql1 = "SELECT uhs.id FROM uhs
            INNER JOIN bloco ON fk_bloco = bloco.id
            WHERE fk_entidade = $idEnt and fk_bloco = $idBloco and andar = $Andar and tipo_local = 'apartamento'
            ORDER BY uhs.id";
    $exe1 = pg_query($GLOBALS['con'], $sql1);
    $quantApart = pg_numrows($exe1);

    $UH = '';
    $HTMLuh = '';
    while ($result1 = pg_fetch_assoc($exe1)) {
        $UH .= ',' . $result1['id'];
    }

    $nome = '';
    for ($i = 1; $i <= $quantApart; $i++) {
        $explode = explode(',', $UH)[$i];
        $sql2 = "SELECT * FROM uhs WHERE id = $explode";
        $exe2 = pg_query($GLOBALS['con'], $sql2);
        $result2 = pg_fetch_assoc($exe2);
        $nome = $result2['nome'];
        $tipo_local = trim($result2['tipo_local']);
        $id = $result2['id'];
        $status = $result2['status'];

        $Sala = '';
        $apart = '';
        $opaco = '';
        if ($tipo_local == 'Sala') {
            $Sala = 'selected';
        }
        if ($tipo_local == 'apartamento') {
            $apart = 'selected';
        }
        if ($status == 'f') {
            $opaco = 'style="opacity:0.5;"';
            $mudarStatus = "<div class='col-sm-3' style='padding:0%; text-align:center;'><label onclick='updateUH(\"recuperarUH\", $id)'>Recuperar <i class='fas fa-check-circle' style='color:green; margin-top:20px;'></i></label></div>";
        }
        if ($status == 't') {
            $mudarStatus = "<div class='col-sm-3' style='padding:0%; text-align:center;'><label onclick='updateUH(\"excluirUH\", $id)'>Excluir <i class='fas fa-times-circle' style='color:red; margin-top:20px;'></i></label></div>";
        }

        $HTMLuh .= "<div class='row'>"
            . "<div class=\"col-sm-12 $status\" $opaco>"
            . "<div class='col-sm-2'><h4 style='margin-top:20px;'>$nome</h4></div>"
            . "<div class='col-sm-3'><input style='margin-top: 15px;' type='text' id='EditUH$id' value='$nome'/></div>"
            . "<div class='col-sm-3'><select style='margin-top: 15px;' id='EditLocal$id'>"
            . "<option value='Sala' $Sala>Sala</option>"
            . "<option value='apartamento' $apart>Apartamento</option>"
            . "</select>"
            . "</div>"
            . $mudarStatus
            . "<div class='col-sm-1' onclick='updateUH(\"editarUH\", $id)' style='background-color:white; margin-top:-10px; padding:0px 45px 0px 0px;'>"
            . "<i class='far fa-save' style='font-size: 2.5rem; margin-top: 20px;'></i>"
            . "</div>"
            . "</div>"
            . "</div>";
    }

    $sql3 = "SELECT nome, id FROM bloco WHERE id = $idBloco and fk_entidade = $idEnt";
    $exe3 = pg_query($GLOBALS['con'], $sql3);
    $result = pg_fetch_assoc($exe3);
    $nomeBloco = $result['nome'];
    $idBloco = $result['id'];

    $HTML = 'Sem';
    if ($nome != '') {
        $HTML = "<h4 style='text-align: center;'><b>Editando &nbsp;&nbsp; $nomeBloco &nbsp;&nbsp; Andar $Andar</b>
                    <input type='hidden' value='$idBloco' id='blocoEditUH'></h4>
                    <input type='hidden' value='$Andar' id='andarEditUH'></h4>
            <hr>
            <div class='col-sm-2'><h5 style='text-align: center;'><b>UHs:</b></h5></div>
            <div class='col-sm-3'><h5 style='text-align: center;'><b>Mudar nome:</b></h5></div>
            <div class='col-sm-3'><h5 style='text-align: center;'><b>Mudar tipo Local:</b></h5></div>
            <div class='col-sm-3' style='padding:0% 4% 0% 0%;'><h5 style='text-align: center;'><b>Status:</b></h5></div>
            <div class='col-sm-1' style='padding-left: 0%;'><h5 style='margin-left: -30px; text-align: center;'><b>Gravar:</b></h5></div>
            $HTMLuh";
    }

    echo json_encode($HTML);
}

function ADDUHS()
{
    $idEnt = $_POST['idEnt'];
    $idBloco = $_POST['idBloco'];
    $Andar = $_POST['Andar'];

    $sql = "SELECT nome, id FROM bloco WHERE id = $idBloco and fk_entidade = $idEnt";
    $exe = pg_query($GLOBALS['con'], $sql);
    $result = pg_fetch_assoc($exe);
    $nomeBloco = $result['nome'];
    $id = $result['id'];

    $HTML = "<h4 style='text-align: center;'><b>Editando &nbsp;&nbsp; $nomeBloco &nbsp;&nbsp; Andar $Andar</b></h4>
            <input type='hidden' value='$id' id='blocoADDuh'>
            <input type='hidden' value='$Andar' id='andarADDuh'>
            <hr>
            <div class='row'>
                <div class='col-sm-3'></div>
                <div class='col-sm-6'>
                    <h5 style='margin: 0%;'>Quantas UHs quer adicionar:</h5>
                    <input type='text' id='quantUHadd' value='' style='margin-top: 2px; border:solid lightgray 1px;  width:100%; margin-bottom: 5%;'>
                </div>
                <div class='col-sm-3'></div>
            </div>
            <hr>
            <div class='row'>
                <div class='col-sm-12'>
                <input readonly='readonly' id='Entidade' onclick='AddUH()' value='Salvar e Finalizar' class='fourth '>
                </div>
            </div>";

    echo json_encode($HTML);
}

function montarEditSala()
{
    $idEnt = $_POST['idEnt'];
    $idBloco = $_POST['idBloco'];
    $andar = $_POST['andar'];

    $sql = "SELECT uhs.nome AS nomeuh, bloco.nome AS nomebloco, andar, uhs.id AS iduh FROM uhs
            INNER JOIN bloco ON fk_bloco = bloco.id
            WHERE bloco.id = $idBloco and fk_bloco = $idBloco and status = true and andar = $andar and tipo_local = 'Sala'";
    $exe = pg_query($GLOBALS['con'], $sql);
    $quantSalas = pg_numrows($exe);

    $explodeNome = '';
    $explodeAndar = '';
    $explodeIdUH = '';
    while ($result = pg_fetch_assoc($exe)) {
        $explodeNome .= ',' . $result['nomeuh'];
        $explodeAndar .= ',' . $result['andar'];
        $explodeIdUH .= ',' . $result['iduh'];
    }

    $HTMLsala = '';
    $nome = explode(',', $explodeNome);
    $Andar = explode(',', $explodeAndar);
    $idUH = explode(',', $explodeIdUH);
    for ($i = 1; $i <= $quantSalas; $i++) {
        $sql2 = "SELECT nome, quant_andar, quant_subsolo FROM bloco WHERE id = $idBloco";
        $exe2 = pg_query($GLOBALS['con'], $sql2);
        $result2 = pg_fetch_assoc($exe2);
        $quant_andar = $result2['quant_andar'];
        $quant_subsolo = $result2['quant_subsolo'];
        $nomeBloco = $result2['nome'];
        $optionAndar = '';
        $selecionada = '';
        for ($o = -$quant_subsolo; $o <= $quant_andar; $o++) {
            if ($o == $Andar[$i]) {
                $selecionada = 'selected';
            }
            if ($o < 0) {
                $optionAndar .= "<option value='$o' $selecionada>SubSolo ($o) </option>";
            }
            if ($o == 0) {
                $optionAndar .= "<option value='$o' $selecionada>Térreo</option>";
            }
            if ($o > 0) {
                $optionAndar .= "<option value='$o' $selecionada>Andar $o</option>";
            }
            $selecionada = '';
        }

        $sql3 = "SELECT id, nome FROM bloco WHERE fk_entidade = $idEnt ORDER BY nome";
        $exe3 = pg_query($GLOBALS['con'], $sql3);

        $optionBloco = '';
        while ($result3 = pg_fetch_assoc($exe3)) {
            $idblocoSelect = $result3['id'];
            $nomeblocoSelect = $result3['nome'];
            $selectBloco = '';
            if ($idblocoSelect == $idBloco) {
                $selectBloco = 'selected';
            }
            $optionBloco .= "<option value='$idblocoSelect' $selectBloco>$nomeblocoSelect</option>";
        }

        $nomeSala = $nome[$i];
        $IdUH = $idUH[$i];
        $HTMLsala .= "<div class='col-sm-3' id='Sala1' style='padding: 20px; border: solid 5px white; margin-right:53px;'>
                        <div class='col-sm-12' style='padding: 0%;'>
                            <h5 style='float: left; margin:0%;'>Sala</h5>
                            <i class='fas fa-trash' onclick=\"UpdateSala('ExcluirSala', $i)\" style='float: right;'></i>
                            <i class='far fa-save' onclick=\"UpdateSala('EditSala', $i)\" style='float: right; margin-right:10px; font-size: 1.6rem;'></i>
                        </div><div class='col-sm-12' style='padding: 8% 0% 0% 0%;'>
                        <div class='form-group' style='margin:0%;'>
                            <input type='text' value='$nomeSala' id='novoNomeSala$i' name='' class='form-control' style='height: 25px; border: solid lightgray 1px; font-weight: 100;' placeholder='Nome'></div>
                            <input type='hidden' value='$IdUH' id='UHEditApart$i'/>
                            <h5 style='margin-top: 1%;'>Bloco</h5>
                                <select id='BlocoEditSala$i'>
                                    <option value=''>Selecione</option>
                                    $optionBloco
                                </select>
                                <h5 style='margin-top: 1%;'>Andar</h5>
                                <select id='AndarEditSala$i'>
                                    <option value=''>Selecione</option>
                                    $optionAndar
                                </select>
                        </div>
                    </div>";
    }
    if ($quantSalas != 0) {
        $HTML = "<div class='row'>
                <div class='col-sm-12 cadastro' style='padding:0%; padding-left:2%;'>
                    <h4><b>Editar Sala</b></h4>
                </div>
            </div>
            <div class='row cadastro' style='margin-bottom:10px;'>
                <div class='col-sm-3'>
                    <div class='numeracao' style='padding-top: 2.5%;'>1</div>
                    <h5 style='margin-top: 5%;'><b>Editando:</b></h5>
                    <div class='col-sm-12' style='padding: 25% 0% 0% 0%; height:215px; background-color:white;'>
                        
                        <h3 style='text-align:center;'><b>$nomeBloco</b></h3>
                        <h4 style='text-align:center;'><b>Andar $andar</b></h4>
                        <input type='hidden' id='antigoBlocoSala' value='$idBloco'>
                        <input type='hidden' id='antigoAndarSala' value='$andar'>
                        <input type='number' style='opacity:0; height:1px;' id='top'>
                    </div>
                </div>
                <div class='col-sm-8'>
                    <div class='numeracao'>2</div>
                    <h5 style='margin-top: 1.7%;'><b>Edição de sala:<b></h5>
                    <div id='SalaCad'>
                    $HTMLsala
                    </div>
                </div>
            </div>";
        echo json_encode($HTML);
    }
    echo '';
}
