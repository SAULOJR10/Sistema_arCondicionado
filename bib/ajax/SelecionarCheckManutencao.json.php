<?php
include_once "../comum/conf.ini.php";
$acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);

switch ($acao) {
    case 'MontarCheckList':
        $Periodo = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
        MontarCheckList($Periodo);
        break;
    case 'selectBloco':
        Selects('Bloco');
        break;
    case 'Quinzenal':
        MontarGraficos('Quinzenal');
        break;
    case 'Mensal':
        MontarGraficos('Mensal');
        break;
    case 'Trimestral':
        MontarGraficos('Trimestral');
        break;
    case 'Anual':
        MontarGraficos('Anual');
        break;
    case 'Andar':
        Selects('Andar');
        break;
    case 'UH':
        Selects('UH');
        break;
    case 'Ar':
        Selects('Ar');
        break;
    case 'QualEnt':
        selectEnt();
        break;
    case 'MontarTela':
        MontarTela();
        break;
}

function SelectEnt()
{
    $idLogin = filter_input(INPUT_POST, 'idUsuario', FILTER_SANITIZE_STRING);
    $conexao = new ConexaoCard();
    $sql = "SELECT dados_entidade.id AS ident, nome_fantasia FROM dados_entidade
             INNER JOIN entidade_login on fk_entidade = dados_entidade.id
             Where fk_login = $idLogin and nome_fantasia != ''
             ORDER BY nome_fantasia";
    $result = $conexao->execQuerry($sql);
    $conexao->fecharConexao();

    $quant = count($result) - 1;
    $option = '<option value="">Selecione</option>";';
    for ($i = 0; $i <= $quant; $i++) {
        $valor = $result[$i]['nome_fantasia'];
        $id = $result[$i]['ident'];
        $option .= "<option value='$id' id='optionEnt$id'>$valor</option>";
    }
    $select = "<div class='form-group'><select id='EntidadeGer' style='border-radius:10px;' class='form-control' onchange='EntSelected(\"normal\")'>$option</select></div>";
    echo json_encode($select);
}

function Selects($acao)
{
    $idEnt = filter_input(INPUT_POST, 'idEnt', FILTER_SANITIZE_STRING);
    if ($acao == 'Bloco') {
        $conexao = new ConexaoCard();
        $sql = "SELECT bloco.id, bloco.nome, equipamento.id AS equipamento FROM bloco
                INNER JOIN uhs ON fk_bloco = bloco.id
                INNER JOIN equipamento ON uh = uhs.id
                WHERE fk_entidade = $idEnt and fk_bloco = bloco.id and uh = uhs.id GROUP BY equipamento, bloco.nome, bloco.id ORDER BY bloco.nome";
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
            $equip = $result[$i]['equipamento'];
            if ($equip != '' && $equip != null && $Bloco != $result[$o]['nome']) {
                $option .= "<option value='$id'> $Bloco </option>";
            } else if ($o == 0 || !isset($o)) {
                $option .= "<option value='$id'> $Bloco </option>";
            }
        }
        $html = "<h4 style='text-align:center;'>Selecione o Bloco:</h4><select style='border-radius:10px;' id='Bloco' class='form-control' onchange=\"MontarQualUH('Andar')\">$option</select>";
        echo json_encode($html);
    }
    if ($acao == 'Andar') {
        $bloco = filter_input(INPUT_POST, 'idBloco', FILTER_SANITIZE_STRING);
        $option = '<option value="">Selecione</option>';
        $conexao = new ConexaoCard();
        $sql = "SELECT andar, equipamento.id FROM uhs
                INNER JOIN equipamento ON uh = uhs.id
                WHERE fk_bloco = $bloco GROUP BY equipamento.id, andar";
        $result = $conexao->execQuerry($sql);
        $conexao->fecharConexao();
        $quant = count($result) - 1;

        for ($i = 0; $i <= $quant; $i++) {
            if ($i != 0) {
                $o = $i - 1;
                $u = '';
            } else {
                $o = 0;
            }
            $andar = $result[$i]['andar'];
            $equip = $result[$i]['id'];
            if ($equip != '' && $equip != null && $andar != $result[$o]['andar']) {
                if ($andar == 0) {
                    $option .= "<option value='$andar'>Térreo</option>";
                }
                if ($andar > 0) {
                    $option .= "<option value='$andar'>Andar $andar</option>";
                }
                if ($andar < 0) {
                    $option .= "<option value='$andar'>Sub-Solo ($andar)</option>";
                }
            } else if (isset($u) && $o == 0) {
                if ($andar == 0) {
                    $option .= "<option value='$andar'>Térreo</option>";
                }
                if ($andar > 0) {
                    $option .= "<option value='$andar'>Andar $andar</option>";
                }
                if ($andar < 0) {
                    $option .= "<option value='$andar'>Sub-Solo ($andar)</option>";
                }
            }
        }
        $html = "<h4 style='text-align:center;'>Selecione andar:</h4><select class='form-control' id='andarGer' onchange='MontarQualUH(\"UH\")' style='border-radius:10px;'> $option </select>";
        echo json_encode($html);
    }
    if ($acao == 'UH') {
        $bloco = filter_input(INPUT_POST, 'idBloco', FILTER_SANITIZE_STRING);
        $andar = filter_input(INPUT_POST, 'andar', FILTER_SANITIZE_STRING);
        $conexao = new ConexaoCard();
        $sql = "SELECT uhs.nome, uhs.id, equipamento.id AS equipamento FROM uhs
                INNER JOIN equipamento ON uh = uhs.id
                WHERE fk_bloco = $bloco and andar = $andar and status = true ORDER BY nome";
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
            }else if ($o == 0 || !isset($o)) {
                $option .= "<option value='$id'> $UH </option>";
            }
        }
        $html = "<h4 style='text-align:center;'>Selecione local:</h4><select class='form-control' id='UHGer' onchange=\"MontarQualUH('Ar')\" style='border-radius:10px;'> $option </select>";
        echo json_encode($html);
    }
    if ($acao == 'Ar') {
        $idUH = filter_input(INPUT_POST, 'idUH', FILTER_SANITIZE_STRING);
        $conexao = new ConexaoCard();
        $sql = "SELECT * FROM equipamento WHERE uh = $idUH ORDER BY Marca";
        $result = $conexao->execQuerry($sql);
        $conexao->fecharConexao();

        $quant = count($result) - 1;
        $option = '<option value="">Selecione</option>';
        for ($i = 0; $i <= $quant; $i++) {
            $Marca = $result[$i]['marca'];
            $Local = $result[$i]['localizacao'];
            $id = $result[$i]['id'];
            $option .= "<option value='$id'> $Marca, $Local </option>";
        }
        $html = "<h4 style='text-align:center;'>Seleciona Ar Condicionado:</h4><select class='form-control' id='Ar' onchange=\"MontarQualUH('colocarButton')\" style='border-radius:10px;'> $option </select>";
        echo json_encode($html);
    }
}

function MontarTela()
{
    $uh = filter_input(INPUT_POST, 'uh', FILTER_SANITIZE_STRING);
    $conexao = new ConexaoCard();
    $sql1 = "SELECT * FROM uhs WHERE id = $uh";
    $result1 = $conexao->execQuerry($sql1);

    if (is_array($result1) && $result1 != null) {
        $tipo_local = $result1[0]['tipo_local'];
        $nomeUH = $result1[0]['nome'];
    }

    $idBloco = $result1[0]['fk_bloco'];
    $sql2 = "SELECT * FROM bloco WHERE id = $idBloco";
    $result2 = $conexao->execQuerry($sql2);
    $conexao->fecharConexao();

    if (is_array($result2) && $result2 != null) {
        $nomeBloco = $result2[0]['nome'];
    }

    $final  = ';' . $tipo_local . ': ' . $nomeUH . ';' . $nomeBloco;
    echo json_encode($final);
}

function MontarCheckList($Periodo)
{
    $idUH = filter_input(INPUT_POST, 'uh', FILTER_SANITIZE_STRING);
    $idLogin = filter_input(INPUT_POST, 'idLogin', FILTER_SANITIZE_STRING);
    $idAr = filter_input(INPUT_POST, 'idAr', FILTER_SANITIZE_STRING);
    $conexao = new ConexaoCard();
    $sqlUH = "SELECT * FROM uhs WHERE id = $idUH";
    $resultUH = $conexao->execQuerry($sqlUH);
    $UH = $resultUH[0]['nome'];
    $idBloco = $resultUH[0]['fk_bloco'];

    $sqlBloco = "SELECT * FROM bloco WHERE id = $idBloco";
    $resultBloco = $conexao->execQuerry($sqlBloco);
    $Bloco = $resultBloco[0]['nome'];

    $sqlUsu = "SELECT * FROM login WHERE id = $idLogin";
    $resultUsu = $conexao->execQuerry($sqlUsu);
    $Usuario = $resultUsu[0]['usuario'];

    $sql = "SELECT * FROM item WHERE tipo_equipamento = 1 and periodo = '$Periodo' ORDER BY periodo, titulo";
    $result = $conexao->execQuerry($sql);

    $htmlTitulo = '';
    $tituloAntigo = '';
    $num1 = 1;
    $num2 = 1;
    $fim = '';
    $quant = count($result) - 1;
    for ($i = 0; $i <= $quant; $i++) {
        $Periodo = $result[$i]['periodo'];
        $titulo = $result[$i]['titulo'];
        $descricao = $result[$i]['descricao'];
        $idItem = $result[$i]['id'];
        $hj = date('Y/m/d');
        $sql2 = "SELECT item_check.data, item_check.status, observacao, funcionario FROM item_check
                 INNER JOIN check_list ON fk_check_list = check_list.id
                 WHERE fk_item = $idItem and fk_equipamento = $idAr and vencimento >= '$hj'";
        $result2 = $conexao->execQuerry($sql2);
        if (is_array($result2) && $result2 != null) {
            $data =  $result2[0]['data'] . ' -';
            if ($result2[0]['observacao'] == '') {
                $obs = "<span style='color: red;'>Nenhuma observação</span>";
            } else {
                $obs =  '<span style="color: red;"><b>' . $result2[0]['observacao'] . '</b></span>';
            }
            $valueOBS = $result2[0]['observacao'];
            $idFun = $result2[0]['funcionario'];
            if ($result2[0]['status'] == 1) {
                $checked =  "checked";
            } else {
                $checked = '';
            }
        } else {
            $checked = '';
            $data = "<span style='color: red;'>Não Validado<span>";
            $obs = "<span style='color: red;'>Nenhuma observação</span>";
            $valueOBS = '';
            $idFun = '';
        }

        if ($idFun != '') {
            $sql3 = "SELECT * FROM login WHERE id = $idFun";
            $result3 = $conexao->execQuerry($sql3);
            $NomeFuncionario = $result3[0]['usuario'];
        } else {
            $NomeFuncionario = '';
        }
        if ($tituloAntigo != $titulo || $tituloAntigo == '') {
            $htmlTitulo .= "$fim<div style='border-bottom: solid black 3px; margin-right:40px;'><div class='numeracao'>$num1</div><h5 style='padding-top: 10px;'><b>$titulo</b></h5>";
            $num1++;
            $fim = "</div>";
        }
        $htmlTitulo .= "<div>
                            <h5 style='margin-top: 30px;'><b>$descricao</b></h5>
                            <div class='col-xs-3 ' style='float: right; padding-right: 0px; padding-left:0px;'>
                                <img src='bib/img/agendaEdit.png' onclick='ColocarOBS($num2)' style='width: 25px; margin-top: -10px; height: 25px;'>
                                <input id='ch_item$num2' value='$idItem' name='allitem' class='switch switch--shadow' type='checkbox' $checked>
                                <label style='float:right; min-width: 40px;' for='ch_item$num2'></label>
                            </div>
                            <h5>Validado: <span style='color: lightblue;'>$data $NomeFuncionario &nbsp;&nbsp;&nbsp;</span></h5>
                            <h5 style='text-align:center; background-color: white; margin-bottom: 10px;'><input type='text' value='$valueOBS' name='allobs' id='obs$num2' style='display:none;'><span id='tirar$num2'>observacao: $obs<span></h5>
                        </div>";

        $tituloAntigo = $titulo;
        $num2++;
    }
    $html = "<div class='col-sm-1'></div>
                <div class='col-sm-8' style='padding:0% 2% 0% 0%; background-color: rgb(243,246,251);'>
                    <div class='col-sm-12' style='padding:0%;background-color:#c4ced2; border-bottom: solid black 3px;'>
                        <div class='col-sm-4' style='text-align:center;'>
                            <img src='bib/img/$Periodo.png' onclick='VoltarTodos()' style='width: 30%; height: 60px; margin-top: 15px;'>
                        </div>
                        <div class='col-sm-6'>
                            <h5 style='text-align: center;'>Check-List $Periodo</h5>
                            <input type='hidden' id='periodo' value='$Periodo'>
                            <h4 style='text-align: center'>$Bloco</h4>
                            <h4 style='text-align: center; margin-top:5px;'>UH: $UH</h4>
                            <p style='text-align:center;'>
                            <img src='bib/img/Engenheiro.png' style='width: 25px; height: 25px; margin-top: -9px;'>
                            $Usuario</p>
                        </div>

                    </div>
                    <div class='col-sm-12' style='padding:1% 6% 1% 6%;'>
                        <div onclick='SalvaCheckList()' style='text-align:center; margin-top:15px; margin-left:78%; padding-top: 3%; position: fixed; height: 50px; width: 50px; background-color: rgb(50, 164, 250); border-radius: 30px;'>
                            <i class='fas fa-save' style='font-size: 2.5rem; color:white;'></i>
                        </div>
                        <div onclick='MarcarTodos()' style='text-align:center; margin-left:78%; margin-top:75px; padding-top: 3%; position: fixed; height: 50px; width: 50px; background-color: rgb(50, 164, 250); border-radius: 30px;'>
                            <i class='fas fa-check' style='font-size: 2.5rem; color:white;'></i>
                        </div>
                        <div onclick='abrirModal(\"agendar\")' style='text-align:center; margin-left:78%; margin-top:135px; padding-top: 3%; position: fixed; height: 50px; width: 50px; background-color: rgb(50, 164, 250); border-radius: 30px;'>
                            <i class='far fa-clock' style='font-size: 2.5rem; color:white;'></i>
                        </div>
                        <div onclick='OutroAr()' style='text-align:center; margin-left:78%; margin-top:195px; padding-top: 3%; position: fixed; height: 50px; width: 50px; background-color: rgb(50, 164, 250); border-radius: 30px;'>
                            <img src='bib/img/arcondicionadoIcon.png' style='width: 30px; height: 30px; color:white;'>  </i>
                        </div>
                        <div onclick='VoltarTodos()' style='text-align:center; margin-left:78%; margin-top:255px; padding-top: 3%; position: fixed; height: 50px; width: 50px; background-color: rgb(50, 164, 250); border-radius: 30px;'>
                            <i class='fas fa-chevron-circle-left' style='font-size: 2.5rem; color:white;'></i>
                        </div>
                        <div id='descer' onclick='descerScroll(100)' style='text-align:center; margin-left:78%; margin-top:315px; padding-top: 3%; position: fixed; height: 50px; width: 50px; background-color: rgb(50, 164, 250); border-radius: 30px;'>
                            <i class='fas fa-arrow-down' style='font-size: 2.5rem; color:white;'></i>
                        </div>
                        $htmlTitulo
                        
                    </div>
                </div>
            </div>
            <div class='col-sm-2'>
            </div>";

    echo json_encode($html);
}


function MontarGraficos($periodo)
{
    $idUH = filter_input(INPUT_POST, 'uh', FILTER_SANITIZE_STRING);
    $idAr = filter_input(INPUT_POST, 'idAr', FILTER_SANITIZE_STRING);
    $conexao = new ConexaoCard();
    $sqlTotal = "SELECT COUNT(item.id) AS total FROM item WHERE item.periodo = '$periodo' and tipo_equipamento = 1";
    $result = $conexao->execQuerry($sqlTotal);
    $quantTotal = $result[0]['total'];

    $hj = date('Y/m/d');
    $sqlFinalizados = "SELECT COUNT(check_list.id) AS finalizados FROM check_list
                       INNER JOIN item_check ON fk_check_list = check_list.id
                       WHERE fk_uh = $idUH and periodo = '$periodo' and vencimento >= '$hj' and item_check.status = true and fk_equipamento = $idAr";
    $result2 = $conexao->execQuerry($sqlFinalizados);
    $quantFinalizados = $result2[0]['finalizados'];

    $sqlNaoFinalizados = "SELECT COUNT(check_list.id) AS naofinalizados FROM check_list
                       INNER JOIN item_check ON fk_check_list = check_list.id
                       WHERE fk_uh = $idUH and periodo = '$periodo' and vencimento >= '$hj' and item_check.status = false and fk_equipamento = $idAr";
    $result3 = $conexao->execQuerry($sqlNaoFinalizados);
    $quantNaoFinalizados = $result3[0]['naofinalizados'];

    $sql = "SELECT data_check, check_list.status FROM check_list
            INNER JOIN item_check ON fk_check_list = check_list.id
            WHERE fk_uh = $idUH and periodo = '$periodo' and fk_equipamento = $idAr and vencimento >= '$hj'";
    $result = $conexao->execQuerry($sql);
    $conexao->fecharConexao();
    if (is_array($result) && $result != null) {
        $data = $result[0]['data_check'];
        $status = $result[0]['status'];
    } else {
        $data = "Não Inicializado";
        $status = "Não Inicializado";
    }
    if ($status == 0) {
        $status = 'Incompleto';
    }
    if ($status == 1) {
        $status = 'Completo';
    }

    $resultado = $quantTotal . ';' . $quantFinalizados . ';' . $quantNaoFinalizados . ';' . $data . ';' . $status;
    echo json_encode($resultado);
}
