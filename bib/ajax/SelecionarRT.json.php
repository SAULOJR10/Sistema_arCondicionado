<?php
include_once "../comum/conf.ini.php";
$acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);

switch ($acao) {
    case 'Relatorio':
        Relatorio();
        break;
    case 'selectBloco':
        Selects('Bloco');
        break;
    case 'Andar':
        Selects('Andar');
        break;
    case 'UH':
        Selects('UH');
        break;
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
            } else if ($o == 0 || !isset($o)) {
                $option .= "<option value='$id'> $UH </option>";
            }
        }
        $html = "<h4 style='text-align:center;'>Selecione local:</h4><select class='form-control' id='UHGer' onchange=\"MontarQualUH('colocarButton')\" style='border-radius:10px;'> $option </select>";
        echo json_encode($html);
    }
}

function Relatorio()
{
    $idUH = filter_input(INPUT_POST, 'idUH', FILTER_SANITIZE_STRING);
    $idLogin = filter_input(INPUT_POST, 'idLogin', FILTER_SANITIZE_STRING);
    $hj = date('Y/m/d');
    $sql = "SELECT localizacao, marca, modelo, potencia, equipamento.id AS idar, uhs.fk_bloco, proprietario, uhs.nome AS nomeuh FROM uhs
            INNER JOIN equipamento ON equipamento.uh = uhs.id
            WHERE uhs.id = $idUH";
    $conexao = new ConexaoCard();
    $result = $conexao->execQuerry($sql);

    if (is_array($result) && $result != null) {
        $idBloco = $result[0]['fk_bloco'];
        $idProp = $result[0]['proprietario'];
        $UH = 'UH: ' . $result[0]['nomeuh'] . ' - ';
        $sqlBloco = "SELECT * FROM bloco WHERE id = $idBloco";
        $resultBloco = $conexao->execQuerry($sqlBloco);
        if (is_array($resultBloco) && $resultBloco != null) {
            $Bloco = $resultBloco[0]['nome'];
            $idEnt = $resultBloco[0]['fk_entidade'];
            $sqlEnt = "SELECT * FROM dados_entidade WHERE id = $idEnt";
            $resultEntdidade = $conexao->execQuerry($sqlEnt);
            if (is_array($resultEntdidade) && $resultEntdidade != null) {
                $Entidade = $resultEntdidade[0]['nome_fantasia'];
                $cidade = $resultEntdidade[0]['cidade'];
                $razao = $resultEntdidade[0]['razao_social'];
                $cnpj = $resultEntdidade[0]['cnpj'];
                $sqlProp = "SELECT * FROM proprietarios WHERE id = $idProp";
                $resultProp = $conexao->execQuerry($sqlProp);
                if (is_array($resultEntdidade) && $resultEntdidade != null) {
                    $nomeProp = $resultProp[0]['nome'];
                    if ($nomeProp == '') {
                        $nomeProp = 'Saulo Coelho da Costa Junior';
                    }
                    $documento = $resultProp[0]['documento'];
                    if ($documento == '') {
                        $documento = '703.484.031-86';
                    }
                    $endereco = $resultProp[0]['endereco'];
                    if ($endereco == '') {
                        $endereco = 'Rua 3 Quadra 59 Lote 2 Setor São José';
                    }
                }
            }
        }
    }

    $quant = count($result) - 1;
    $idArAnterior = 0;
    $AR = '';
    for ($i = 0; $i <= $quant; $i++) {
        $qual = $i + 1;
        $localizacao = $result[$i]['localizacao'];
        $marca = $result[$i]['marca'];
        $modelo = $result[$i]['modelo'];
        $potencia = $result[$i]['potencia'];
        $idAr = $result[$i]['idar'];
        if ($idAr != $idArAnterior) {
            $sql2 = "SELECT fk_item, item.periodo, descricao, item_check.data, funcionario, item_check.status FROM item_check
                    INNER JOIN item ON fk_item = item.id
                    INNER JOIN check_list ON fk_check_list = check_list.id
                    WHERE fk_equipamento = $idAr
                    ORDER BY data desc, fk_item";
            $result2 = $conexao->execQuerry($sql2);
            $quant2 = count($result2) - 1;
            $ItensQuinzenal = '';
            $ItensMensal = '';
            $ItensTrimestral = '';
            $ItensAnual = '';
            $idItemAnterior = 0;
            $num = 0;
            for ($o = 0; $o <= $quant2; $o++) {
                $idItem = $result2[$o]['fk_item'];
                $perido = $result2[$o]['periodo'];
                $desc = $result2[$o]['descricao'];
                $dataItem = $result2[$o]['data'];
                $idFun = $result2[$o]['funcionario'];
                $status = $result2[$o]['status'];
                $sqlFun = "SELECT * FROM login WHERE id = $idFun";
                $funcionario = $conexao->execQuerry($sqlFun)[0]['usuario'];
                if ($idItem != $idItemAnterior) {
                    if ($perido == 'Quinzenal') {
                        $dataTeste = date('Y/m/d', strtotime('+15 days', strtotime($dataItem)));
                        $dataItem = date('d/m/y', strtotime($dataItem));
                        if ($hj <= $dataTeste && $status == 0) {
                            $situacao = '<span style="color:blue;"> Aguardando </span>';
                        }else if ($hj >= $dataTeste || $status == 0) {
                            $situacao = '<span style="color:red;"> Atrasado </span>';
                        }
                        if ($hj <= $dataTeste && $status == 1) {
                            $situacao = '<span style="color:green;"> Em dia </span>';
                        }
                        $ItensQuinzenal .= "<tr>
                                                <td>$idItem</td>
                                                <td>$desc</td>
                                                <td class='naoQuebra'>$situacao</td>
                                                <td class='naoQuebra'>$dataItem</td>
                                                <td style='text-align:center;'>$funcionario</td>
                                            </tr>";
                        $ultimoNum = $idItem;
                    }
                    if ($perido == 'Mensal') {
                        $dataTeste = date('Y/m/d', strtotime('+30 days', strtotime($dataItem)));
                        $dataItem = date('d/m/y', strtotime($dataItem));
                        if ($hj <= $dataTeste && $status == 0) {
                            $situacao = '<span style="color:blue;"> Aguardando </span>';
                        }else if ($hj <= $dataTeste || $status == 0) {
                            $situacao = '<span style="color:red;"> Atrasado </span>';
                        }
                        if ($hj <= $dataTeste && $status == 1) {
                            $situacao = '<span style="color:green;"> Em dia </span>';
                        }
                        $ItensMensal .= "<tr>
                                                <td>$idItem</td>
                                                <td>$desc</td>
                                                <td class='naoQuebra'>$situacao</td>
                                                <td class='naoQuebra'>$dataItem</td>
                                                <td style='text-align:center;'>$funcionario</td>
                                            </tr>";
                        $ultimoNum = $idItem;
                    }
                    if ($perido == 'Trimestral') {
                        $dataTeste = date('Y/m/d', strtotime('+90 days', strtotime($dataItem)));
                        $dataItem = date('d/m/y', strtotime($dataItem));
                        if ($hj <= $dataTeste && $status == 0) {
                            $situacao = '<span style="color:blue;"> Aguardando </span>';
                        }else if ($hj >= $dataTeste || $status == 0) {
                            $situacao = '<span style="color:red;"> Atrasado </span>';
                        }
                        if ($hj <= $dataTeste && $status == 1) {
                            $situacao = '<span style="color:green;"> Em dia </span>';
                        }
                        $ItensTrimestral .= "<tr>
                                                <td>$idItem</td>
                                                <td>$desc</td>
                                                <td class='naoQuebra'>$situacao</td>
                                                <td class='naoQuebra'>$dataItem</td>
                                                <td style='text-align:center;'>$funcionario</td>
                                            </tr>";
                        $ultimoNum = $idItem;
                    }
                    if ($perido == 'Anual') {
                        $dataTeste = date('Y/m/d', strtotime('+365 days', strtotime($dataItem)));
                        $dataItem = date('d/m/y', strtotime($dataItem));
                        if ($hj <= $dataTeste && $status == 0) {
                            $situacao = '<span style="color:blue;"> Aguardando </span>';
                        }else if ($hj >= $dataTeste || $status == 0) {
                            $situacao = '<span style="color:red;"> Atrasado </span>';
                        }
                        if ($hj <= $dataTeste && $status == 1) {
                            $situacao = '<span style="color:green;"> Em dia </span>';
                        }
                        $ItensAnual .= "<tr>
                                                <td>$idItem</td>
                                                <td>$desc</td>
                                                <td class='naoQuebra'>$situacao</td>
                                                <td class='naoQuebra'>$dataItem</td>
                                                <td style='text-align:center;'>$funcionario</td>
                                            </tr>";
                        $ultimoNum = $idItem;
                    }
                }
                $idItemAnterior = $idItem;
            }

            if ($ItensQuinzenal == '') {
                $sqlQuinzenal = "SELECT * FROM item WHERE periodo = 'Quinzenal'";
                $resultQuinzenal = $conexao->execQuerry($sqlQuinzenal);
                $quantQuinzenal = count($resultQuinzenal) - 1;
                $num = 0;
                for ($u = 0; $u <= $quantQuinzenal; $u++) {
                    if($num = 0){
                        $num = $ultimoNum +1;
                    }else{
                        $num = $num +1;
                    }
                    $perido = $resultQuinzenal[$u]['periodo'];
                    $desc = $resultQuinzenal[$u]['descricao'];
                    $situacao = '';
                    $dataItem = '<span style="color:red;">Nunca Feito</span>';
                    $funcionario = '        ';
                    $ItensQuinzenal .= "<tr>
                                                <td>$num</td>
                                                <td>$desc</td>
                                                <td class='naoQuebra'>$situacao</td>
                                                <td class='naoQuebra'>$dataItem</td>
                                                <td style='text-align:center;'>$funcionario</td>
                                            </tr>";
                }
            }
            if ($ItensMensal == '') {
                $sqlMensal = "SELECT * FROM item WHERE periodo = 'Mensal'";
                $resultMensal = $conexao->execQuerry($sqlMensal);
                $quantMensal = count($resultMensal) - 1;
                $num = 0;
                for ($u = 0; $u <= $quantMensal; $u++) {
                    if($num = 0){
                        $num = $ultimoNum +1;
                    }else{
                        $num = $num +1;
                    }
                    $perido = $resultMensal[$u]['periodo'];
                    $desc = $resultMensal[$u]['descricao'];
                    $situacao = '';
                    $dataItem = '<span style="color:red;">Nunca Feito</span>';
                    $funcionario = '        ';
                    $ItensMensal .= "<tr>
                                                <td>$num</td>
                                                <td>$desc</td>
                                                <td class='naoQuebra'>$situacao</td>
                                                <td class='naoQuebra'>$dataItem</td>
                                                <td style='text-align:center;'>$funcionario</td>
                                            </tr>";
                }
            }
            if ($ItensTrimestral == '') {
                $sqlTrimestral = "SELECT * FROM item WHERE periodo = 'Trimestral'";
                $resultTrimestral = $conexao->execQuerry($sqlTrimestral);
                $quantTrimestral = count($resultTrimestral) - 1;
                $num = 0;
                for ($u = 0; $u <= $quantTrimestral; $u++) {
                    if($num = 0){
                        $num = $ultimoNum +1;
                    }else{
                        $num = $num +1;
                    }
                    $perido = $resultTrimestral[$u]['periodo'];
                    $desc = $resultTrimestral[$u]['descricao'];
                    $situacao = '';
                    $dataItem = '<span style="color:red;">Nunca Feito</span>';
                    $funcionario = '        ';
                    $ItensTrimestral .= "<tr>
                                                <td>$num</td>
                                                <td>$desc</td>
                                                <td class='naoQuebra'>$situacao</td>
                                                <td class='naoQuebra'>$dataItem</td>
                                                <td style='text-align:center;'>$funcionario</td>
                                            </tr>";
                }
            }
            if ($ItensAnual == '') {
                $sqlAnual = "SELECT * FROM item WHERE periodo = 'Anual'";
                $resultAnual = $conexao->execQuerry($sqlAnual);
                $quantAnual = count($resultAnual) - 1;
                $num = 0;
                for ($u = 0; $u <= $quantAnual; $u++) {
                    if($num = 0){
                        $num = $ultimoNum +1;
                    }else{
                        $num = $num +1;
                    }
                    $perido = $resultAnual[$u]['periodo'];
                    $desc = $resultAnual[$u]['descricao'];
                    $situacao = '';
                    $dataItem = '<span style="color:red;">Nunca Feito</span>';
                    $funcionario = '        ';
                    $ItensAnual .= "<tr>
                                                <td>$num</td>
                                                <td>$desc</td>
                                                <td class='naoQuebra'>$situacao</td>
                                                <td class='naoQuebra'>$dataItem</td>
                                                <td style='text-align:center;'>$funcionario</td>
                                            </tr>";
                }
            }

            $AR .= "<div class='row'>
                        <div class='col-sm-1'></div>
                            <div class='col-sm-10'>
                                <div style='background-color: #abdeef40; margin-bottom: 10px; padding: 10px;'>
                                    <h5>Ar Condicionado $qual</h5>
                                    <h5>Localização: $localizacao | Marca: $marca | Modelo: $modelo | Potência: $potencia</h5>
                                </div>
                                <table>
                                    <tr>
                                        <td colspan='2' style='font-size: 16px; background-color: #0025ff24;'><b>Quinzenal</b></td>
                                    </tr>
                                    <tr>
                                        <td><b>Item:</b></td>
                                        <td style='width: 600px;'><b>Descrição:</b></td>
                                        <td><b>Status:</b></td>
                                        <td><b>Data:</b></td>
                                        <td><b>Funcionario:</b></td>
                                    </tr>
                                    $ItensQuinzenal
                                </table>
                                <table>
                                    <tr>
                                        <td colspan='2' style='font-size: 16px; background-color: #0025ff24;'><b>Mensal</b></td>
                                    </tr>
                                    <tr>
                                        <td><b>Item:</b></td>
                                        <td style='width: 600px;'><b>Descrição:</b></td>
                                        <td><b>Status:</b></td>
                                        <td><b>Data:</b></td>
                                        <td><b>Funcionario:</b></td>
                                    </tr>
                                    $ItensMensal
                                </table>
                                <table>
                                    <tr>
                                        <td colspan='2' style='font-size: 16px; background-color: #0025ff24;'><b>Trimestral</b></td>
                                    </tr>
                                    <tr>
                                        <td><b>Item:</b></td>
                                        <td style='width: 600px;'><b>Descrição:</b></td>
                                        <td><b>Status:</b></td>
                                        <td><b>Data:</b></td>
                                        <td><b>Funcionario:</b></td>
                                    </tr>
                                    $ItensTrimestral
                                </table>
                                <table>
                                    <tr>
                                        <td colspan='2' style='font-size: 16px; background-color: #0025ff24;'><b>Anual</b></td>
                                    </tr>
                                    <tr>
                                        <td><b>Item:</b></td>
                                        <td style='width: 600px;'><b>Descrição:</b></td>
                                        <td><b>Status:</b></td>
                                        <td><b>Data:</b></td>
                                        <td><b>Funcionario:</b></td>
                                    </tr>
                                    $ItensAnual
                                </table>
                            </div>
                        <div class='col-sm-1'></div>
                    </div>";
        }
        $idArAnterior = $idAr;
    }
    $sqlLogin = "SELECT * FROM login WHERE id = $idLogin";
    $resultLogin = $conexao->execQuerry($sqlLogin);
    if ($resultLogin[0]['tipo_usuario'] == 'eng') {
        // $idEng = $resultLogin[0]['fk_engenheiro'];
        $sqlEng = "SELECT * FROM dados_engenheiro WHERE id = 45";
        $resultEng = $conexao->execQuerry($sqlEng);
        $assinatura = $resultEng[0]['assinatura'];
        $nomeEng = $resultEng[0]['nome'];
        $telefoneEng = $resultEng[0]['telefone'];
        $CREA = $resultEng[0]['crea'];
    } else {
        $assinatura = '';
        $nomeEng = '';
        $telefoneEng = '';
        $CREA = '';
    }
    $conexao->fecharConexao();
    $dia = date('d/m/y');
    $HTML = "  <div class='row'>
                        <div class='col-sm-12' style='border-bottom: solid black 1px;'>
                            <div class='col-sm-4'>
                                <img src='bib/img/logo2.png' style='width: 180px; height: 5 0px;'>
                            </div>
                            <div class='col-sm-2'></div>
                            <div class='col-sm-6'>
                                <h5 style='text-align:right; margin:15px 0px 2px 0px'>$Entidade - $cidade</h5>
                                <h5 style='text-align:right; margin:2px;'>CNPJ: $cnpj</h5>
                                <h5 style='text-align:right; margin:2px;'>Razão Social: $razao</h5>
                            </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-sm-3'></div>
                        <div class='col-sm-2' style='text-align:center;'>
                            <h3 style='text-align:center;'><b><u>RT-PMOC</u></b></h3>
                            <h4 style='text-align:center;'>$UH $Bloco</h4>
                        </div>
                        <div class='col-sm-4' style='text-align: center;'>
                            <h5 style='margin: 1px; margin-top: 20px;'><b><u>$nomeProp</b></u></h5>
                            <h5 style='margin: 1px;'>$documento</h5>
                            <h5 style='margin: 1px;'>$endereco</h5>
                        </div>
                        <div class='col-sm-3'></div>
                    </div>
                    $AR
                    <div class='row'>
                        <div class='col-sm-4'></div>
                        <div class='col-sm-4' style='text-align:center; padding-top: 10px; margin-bottom: 20px;'>
                            <h4 style='white-space: nowrap;  margin-left: -10px;'>Firmo o presente: $dia - Caldas Novas</h4>
                            <img src='$assinatura' style='width: 100%; height: 70px;'>
                        </div>
                        </div class='col-sm-4'></div>
                    </div>
                    <div class='row'>
                        <div class='col-sm-4'></div>
                        <div class='col-sm-4' style='text-align:center;'>
                            <h5><b><u>$nomeEng</b></u></h5>
                            <h5>CREA: $CREA</h5>
                            <h5>Telefone: $telefoneEng</h5>
                        </div>
                        <div class='col-sm-4'></div>
                    </div>
                </div>";

    echo json_encode($HTML);
}
