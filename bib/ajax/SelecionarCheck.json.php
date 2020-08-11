<?php
include_once "../comum/conexao.php";
$acao = $_POST['acao'];

switch ($acao) {
    case 'MontarCheckList':
        $Periodo = $_POST['id'];
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
    $idLogin = $_POST['idUsuario'];

    $sql2 = "SELECT dados_entidade.id AS ident, nome_fantasia FROM dados_entidade
             INNER JOIN entidade_login on fk_entidade = dados_entidade.id
             Where fk_login = $idLogin and nome_fantasia != ''
             ORDER BY nome_fantasia";
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

function Selects($acao)
{
    $idEnt = $_POST['idEnt'];
    if ($acao == 'Bloco') {
        $sql = "SELECT * FROM bloco WHERE fk_entidade = $idEnt ORDER BY nome";
        $exe = pg_query($GLOBALS['con'], $sql);
        $option = '<option value="">Selecione</option>';
        while ($result = pg_fetch_assoc($exe)) {
            $Bloco = $result['nome'];
            $id = $result['id'];
            $option .= "<option value='$id'> $Bloco </option>";
        }
        $html = "<h4 style='text-align:center;'>Selecione o Bloco:</h4><select style='border-radius:10px;' id='Bloco' class='form-control' onchange=\"MontarQualUH('Andar')\">$option</select>";
        echo json_encode($html);
    }
    if ($acao == 'Andar') {
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
        $html = "<h4 style='text-align:center;'>Selecione andar:</h4><select class='form-control' id='andarGer' onchange='MontarQualUH(\"UH\")' style='border-radius:10px;'> $option </select>";
        echo json_encode($html);
    }
    if ($acao == 'UH') {
        $bloco = $_POST['idBloco'];
        $andar = $_POST['andar'];
        $sql = "SELECT * FROM uhs WHERE fk_bloco = $bloco and andar = $andar and status = true ORDER BY nome";
        $exe = pg_query($GLOBALS['con'], $sql);
        $option = '<option value="">Selecione</option>';
        while ($result = pg_fetch_assoc($exe)) {
            $UH = $result['nome'];
            $id = $result['id'];
            $option .= "<option value='$id'> $UH </option>";
        }
        $html = "<h4 style='text-align:center;'>Selecione local:</h4><select class='form-control' id='UHGer' onchange=\"MontarQualUH('Ar')\" style='border-radius:10px;'> $option </select>";
        echo json_encode($html);
    }
    if ($acao == 'Ar') {
        $idUH = $_POST['idUH'];
        $sql = "SELECT * FROM equipamento WHERE uh = $idUH ORDER BY Marca";
        $exe = pg_query($GLOBALS['con'], $sql);
        $option = '<option value="">Selecione</option>';
        while ($result = pg_fetch_assoc($exe)) {
            $Marca = $result['marca'];
            $Local = $result['localizacao'];
            $id = $result['id'];
            $option .= "<option value='$id'> $Marca, $Local </option>";
        }
        $html = "<h4 style='text-align:center;'>Seleciona Ar Condicionado:</h4><select class='form-control' id='Ar' onchange=\"MontarQualUH('colocarButton')\" style='border-radius:10px;'> $option </select>";
        echo json_encode($html);
    }
}

function MontarTela()
{
    $uh = $_POST['uh'];

    $sql1 = "SELECT * FROM uhs WHERE id = $uh";
    $exe1 = pg_query($GLOBALS['con'], $sql1);
    $result1 = pg_fetch_assoc($exe1);
    $idBloco = $result1['fk_bloco'];
    $sql2 = "SELECT * FROM bloco WHERE id = $idBloco";
    $exe2 = pg_query($GLOBALS['con'], $sql2);
    $result2 = pg_fetch_assoc($exe2);

    $final  = ';' . $result1['tipo_local'] . ': ' . $result1['nome'] . ';' . $result2['nome'];
    echo json_encode($final);
}

function MontarCheckList($Periodo)
{
    $idUH = $_POST['uh'];
    $idLogin = $_POST['idLogin'];
    $idAr = $_POST['idAr'];

    $sqlUH = "SELECT * FROM uhs WHERE id = $idUH";
    $exeUH = pg_query($GLOBALS['con'], $sqlUH);
    $resultUH = pg_fetch_assoc($exeUH);
    $UH = $resultUH['nome'];
    $idBloco = $resultUH['fk_bloco'];
    $sqlBloco = "SELECT * FROM bloco WHERE id = $idBloco";
    $exeBloco = pg_query($GLOBALS['con'], $sqlBloco);
    $Bloco = pg_fetch_assoc($exeBloco)['nome'];

    $sqlUsu = "SELECT * FROM login WHERE id = $idLogin";
    $exeUsu = pg_query($GLOBALS['con'], $sqlUsu);
    $Usuario = pg_fetch_assoc($exeUsu)['usuario'];

    $sql = "SELECT * FROM item WHERE tipo_equipamento = 1 and periodo = '$Periodo' ORDER BY periodo, titulo";
    $exe = pg_query($GLOBALS['con'], $sql);

    $htmlTitulo = '';
    $tituloAntigo = '';
    $num1 = 1;
    $num2 = 1;
    $fim = '';
    while ($result = pg_fetch_assoc($exe)) {
        $Periodo = $result['periodo'];
        $titulo = $result['titulo'];
        $descricao = $result['descricao'];
        $idItem = $result['id'];
        $hj = date('Y/m/d');
        $sql2 = "SELECT item_check.data, item_check.status, observacao, funcionario FROM item_check
                 INNER JOIN check_list ON fk_check_list = check_list.id
                 WHERE fk_item = $idItem and fk_equipamento = $idAr and vencimento >= '$hj'";
        $exe2 = pg_query($GLOBALS['con'], $sql2);
        $result2 = pg_fetch_assoc($exe2);
        $data =  $result2['data'] . ' -';
        if ($data == ' -') {
            $data = "<span style='color: red;'>Não Validado<span>";
        }
        if ($result2['status'] == 't') {
            $checked =  "checked";
        } else {
            $checked = '';
        }
        if ($result2['observacao'] != '') {
            $obs =  '<span style="color: red;"><b>' . $result2['observacao'] . '</b></span>';
            $valueOBS = $result2['observacao'];
        } else {
            $obs = '<span style="color: red;">Nenhuma observação</span>';
            $valueOBS = '';
        }
        $idFun = $result2['funcionario'];
        if ($idFun != '') {
            $sql3 = "SELECT * FROM login WHERE id = $idFun";
            $exe3 = pg_query($GLOBALS['con'], $sql3);
            $NomeFuncionario = pg_fetch_assoc($exe3)['usuario'];
        }else{
            $NomeFuncionario = '';
        }
        if ($tituloAntigo != $titulo || $tituloAntigo == '') {
            $htmlTitulo .= "$fim<div style='border-bottom: solid black 3px;'><div class='numeracao'>$num1</div><h5 style='padding-top: 10px;'><b>$titulo</b></h5>";
            $num1++;
            $fim = "</div>";
        }
        $htmlTitulo .= "<div style='padding:0px 40px 0px 40px;'>
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
                <div class='col-sm-8' style='padding:0%; background-color: rgb(243,246,251);'>
                    <div class='col-sm-12' style='padding:0%;background-color:#c4ced2; border-bottom: solid black 3px;'>
                        <div class='col-sm-4'>
                            <img src='bib/img/$Periodo.png' onclick='VoltarTodos()' style='width: 100%; height: 120px; margin-top: 15px;'>
                        </div>
                        <div class='col-sm-6'>
                            <h4 style='text-align: center;'>Check-List $Periodo</h4>
                            <input type='hidden' id='periodo' value='$Periodo'>
                            <h3 style='text-align: center'>$Bloco</h3>
                            <h3 style='text-align: center; margin-top:5px;'>UH: $UH</h3>
                            <p style='text-align:center;'>
                            <img src='bib/img/Engenheiro.png' style='width: 25px; height: 25px; margin-top: -9px;'>
                            $Usuario</p>
                        </div>
                    </div>
                    <div class='col-sm-12' style='padding:1% 6% 1% 6%;'>
                        $htmlTitulo
                    </div>
                </div>
            </div>
            <div class='col-sm-2'>
                <div onclick='SalvaCheckList()' style='text-align:center; margin-left:40px; padding-top: 0.8%; position: fixed; height: 50px; width: 50px; background-color: rgb(50, 164, 250); border-radius: 30px;'>
                    <i class='fas fa-save' style='font-size: 2.5rem; color:white;'></i>
                </div>
                <div onclick='MarcarTodos()' style='text-align:center; margin-left:40px; margin-top:60px; padding-top: 0.8%; position: fixed; height: 50px; width: 50px; background-color: rgb(50, 164, 250); border-radius: 30px;'>
                    <i class='fas fa-check' style='font-size: 2.5rem; color:white;'></i>
                </div>
                <div onclick='abrirModal(\"agendar\")' style='text-align:center; margin-left:40px; margin-top:120px; padding-top: 0.8%; position: fixed; height: 50px; width: 50px; background-color: rgb(50, 164, 250); border-radius: 30px;'>
                    <i class='far fa-clock' style='font-size: 2.5rem; color:white;'></i>
                </div>
                <div onclick='OutroAr()' style='text-align:center; margin-left:40px; margin-top:180px; padding-top: 0.8%; position: fixed; height: 50px; width: 50px; background-color: rgb(50, 164, 250); border-radius: 30px;'>
                    <img src='bib/img/arcondicionadoIcon.png' style='width: 30px; height: 30px; color:white;'>  </i>
                </div>
                <div onclick='VoltarTodos()' style='text-align:center; margin-left:40px; margin-top:240px; padding-top: 0.8%; position: fixed; height: 50px; width: 50px; background-color: rgb(50, 164, 250); border-radius: 30px;'>
                    <i class='fas fa-chevron-circle-left' style='font-size: 2.5rem; color:white;'></i>
                </div>
            </div>";

    echo json_encode($html);
}


function MontarGraficos($periodo)
{
    $idUH = $_POST['uh'];
    $idAr = $_POST['idAr'];
    $sqlTotal = "SELECT COUNT(item.id) AS total FROM item WHERE item.periodo = '$periodo' and tipo_equipamento = 1";
    $exe1 = pg_query($GLOBALS['con'], $sqlTotal);
    $quantTotal = pg_fetch_assoc($exe1)['total'];
    $hj = date('Y/m/d');
    $sqlFinalizados = "SELECT COUNT(check_list.id) AS finalizados FROM check_list
                       INNER JOIN item_check ON fk_check_list = check_list.id
                       WHERE fk_uh = $idUH and periodo = '$periodo' and vencimento >= '$hj' and item_check.status = true and fk_equipamento = $idAr";
    $exe2 = pg_query($GLOBALS['con'], $sqlFinalizados);
    $quantFinalizados = pg_fetch_assoc($exe2)['finalizados'];
    $hj = date('Y/m/d');
    $sqlNaoFinalizados = "SELECT COUNT(check_list.id) AS naofinalizados FROM check_list
                       INNER JOIN item_check ON fk_check_list = check_list.id
                       WHERE fk_uh = $idUH and periodo = '$periodo' and vencimento >= '$hj' and item_check.status = false and fk_equipamento = $idAr";
    $exe3 = pg_query($GLOBALS['con'], $sqlNaoFinalizados);
    $quantNaoFinalizados = pg_fetch_assoc($exe3)['naofinalizados'];
    $hj = date('Y/m/d');
    $sql = "SELECT data_check, check_list.status FROM check_list
            INNER JOIN item_check ON fk_check_list = check_list.id
            WHERE fk_uh = $idUH and periodo = '$periodo' and fk_equipamento = $idAr and vencimento >= '$hj'";
    $exe4 = pg_query($GLOBALS['con'], $sql);
    $result = pg_fetch_assoc($exe4);
    $data = $result['data_check'];
    $status = $result['status'];
    if ($status == 'f' || $status == '') {
        $status = 'Incompleto';
    } else {
        $status = 'Completo';
    }

    $resultado = $quantTotal . ';' . $quantFinalizados . ';' . $quantNaoFinalizados . ';' . $data . ';' . $status;
    echo json_encode($resultado);
}
