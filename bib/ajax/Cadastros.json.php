<?php
include_once "../comum/conf.ini.php";
$acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);

switch ($acao) {
    case 'Entidades':
        Entidades();
        break;
    case 'salvarUsuario':
        SalvarUsuario();
        break;
}

function SalvarUsuario()
{
    $resultado = "Usuario cadastrado com sucesso !!!";
    $filename = $_FILES['arquivo']['name'];
    $imageFileType = pathinfo($filename, PATHINFO_EXTENSION);

    /* Verifica extensao do arquivo */
    if (!in_array(strtolower($imageFileType), array("jpg", "jpeg", "png"))) {
        $return['erro'] = 'Arquivo não é JPG ou PNG';
        $uploadOk = 0;
    }else{
        $resultado = "Erro ao Enviar imagem, tenta outra nas extenções JPG ou PNG";
    }
    // verifica para carregar arquivo menor que 1 MB
    if ($_FILES["arquivo"]["size"] > (1024 * 1025)) {
        $return['erro'] .= ' Arquivo é muito grande.' . $_FILES["arquivo"]["size"];
        $uploadOk = 0;
    }else{
        $resultado = "Erro ao Enviar imagem, tenta outra nas extenções JPG ou PNG";
    }
    $location = getNomeArquivo($imageFileType);
    if (move_uploaded_file($_FILES['arquivo']['tmp_name'], '../' . $location)) {
        $tipo_usu = filter_input(INPUT_POST, 'tipo_usu', FILTER_SANITIZE_STRING);
        $nomeUsu = filter_input(INPUT_POST, 'nomeUsu', FILTER_SANITIZE_STRING);
        $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
        $entidades = filter_input(INPUT_POST, 'entidades', FILTER_SANITIZE_STRING);
        $explodeEnt = explode(',', $entidades);
        $quantEnt = count($explodeEnt) - 2;
        $explodeNome = explode(' - ', $nomeUsu);
        $quantEng = count($explodeNome);
        $conexao = new ConexaoCard();
        if ($quantEng > 1) {
            $nomeEng = $explodeNome[0];
            $documento = $explodeNome[1];
            $sqlEng = "SELECT * FROM dados_engenheiro WHERE nome = $nomeEng and documento = $documento";
            $fk_ent = $conexao->execQuerry($sqlEng)[0]['id'];
        } else {
            $fk_ent = 1;
        }

        $sqlCadUsu = "INSERT INTO public.login(usuario, senha, tipo_usuario, data_cadastro, data_alteracao, status, imagem, fk_engenheiro)
        VALUES ('$nomeUsu', '$senha', '$tipo_usu', now(), now(), true, 'bib/$location', $fk_ent) RETURNING id";
        $idLogin = $conexao->execQuerry($sqlCadUsu)[0]['id'];

        for ($i = 0; $i <= $quantEnt; $i++) {
            $idEnt = $explodeEnt[$i];
            $sqlEntLogin = "INSERT INTO public.entidade_login(fk_login, fk_entidade)
                VALUES ($idLogin, $idEnt);";
            $conexao->execQuerry($sqlEntLogin);
        }
        $conexao->fecharConexao();
    }else{
        $resultado = "Selecione uma imagem nas extenções JPG ou PNG";
    }
    echo json_encode($resultado);
}

function getNomeArquivo($extensao) {
    $valor = random_int(100, 100000);
    $val = 0;
    while (file_exists("../imgUsu/usuario$valor.$extensao")) {
        $valor = random_int(100, 100000);
        $val++;
        if ($val > 1000) {
            $valor = 'extra';
            break;
        }
    }
    return "imgUsu/usuario$valor.$extensao";
}

function Entidades()
{
    $idLogin = filter_input(INPUT_POST, 'idUsuario', FILTER_SANITIZE_STRING);
    $sql = "SELECT nome_fantasia, dados_entidade.id FROM dados_entidade
            INNER JOIN entidade_login ON fk_entidade = dados_entidade.id
            WHERE fk_login = $idLogin";
    $conexao = new ConexaoCard();
    $result = $conexao->execQuerry($sql);
    $conexao->fecharConexao();

    $quant = count($result) - 1;
    $html = '';
    for ($i = 0; $i <= $quant; $i++) {
        $entidade = $result[$i]['nome_fantasia'];
        $idEnt = $result[$i]['id'];
        $html .= "<div class='col-xs-12' style='width: 100%; padding: 0%;'>
                    <div class='col-xs-2' style='padding-right: 0px; padding-left:0px; margin-top: 2%;'>
                        <input id='ch_entidade$i' value='$idEnt' name='allEntidades' class='switch switch--shadow' type='checkbox'>
                        <label style='float:right; min-width: 40px;' for='ch_entidade$i'></label>
                    </div>
                    <div class='col-xs-9'>
                        <h4>$entidade</h4>
                    </div>
                </div>";
    }
    echo json_encode($html);
}
