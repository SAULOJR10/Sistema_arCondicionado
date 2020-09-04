<?php
include_once "../comum/conf.ini.php";
$acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);

switch ($acao) {
    case 'MontarExcluir':
        MontarExcluir();
        break;
    case 'Excluir':
        Excluir();
        break;
}

function Excluir(){
    $resultado = "Usuario excluido com sucesso !!!";
    $idLogin = filter_input(INPUT_POST, 'idLogin', FILTER_SANITIZE_STRING);
    $sql = "UPDATE login SET status = false WHERE id = $idLogin";
    $conexao = new ConexaoCard();
    $conexao->execQuerry($sql);
    $conexao->fecharConexao();
    echo json_encode($resultado);
}

function MontarExcluir()
{
    $idLogin = filter_input(INPUT_POST, 'idLogin', FILTER_SANITIZE_STRING);
    $sql = "SELECT * FROM entidade_login WHERE fk_login = $idLogin";
    $conexao = new ConexaoCard();
    $result = $conexao->execQuerry($sql);
    $quant = count($result) - 1;

    $html = "<thead>
                <tr class='head'>
                    <th>Nome</th>
                    <th>Tipo de Usuario</th>
                    <th>Data de entrada</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>";
    for ($i = 0; $i <= $quant; $i++) {
        $idEnt = $result[$i]['fk_entidade'];
        $sql2 = "SELECT * FROM dados_entidade WHERE id = $idEnt";
        $nome = $conexao->execQuerry($sql2)[$i]['nome_fantasia'];
        $sql3 = "SELECT usuario, tipo_usuario, data_cadastro, login.id FROM login
                 INNER JOIN entidade_login ON fk_login = login.id
                 WHERE fk_entidade = $idEnt and status = true";
        $result2 = $conexao->execQuerry($sql3);
        $quant2 = count($result2) - 1;

        $html .= "<tr> <td colspan='4' style='text-align: center;'>$nome</td></tr>";

        for ($o = 0; $o <= $quant2; $o++) {
            $id = $result2[$o]['id'];
            $nomeUsu = $result2[$o]['usuario'];
            $tipo_usu = $result2[$o]['tipo_usuario'];
            if ($tipo_usu == 'adm') {
                $tipo_usu = "Administrador(a)";
            }
            if ($tipo_usu == 'eng') {
                $tipo_usu = "Engenheiro(a)";
            }
            if ($tipo_usu == 'manutencionista') {
                $tipo_usu = "Manutencionista";
            }
            $dataCadastro = $result2[$o]['data_cadastro'];
            $html .= "<tr>
                        <td style='text-align: center;'>$nomeUsu</td>
                        <td style='text-align: center;'>$tipo_usu</td>
                        <td style='text-align: center;'>$dataCadastro</td>
                        <td style='text-align: center;'><i onclick='RemoverUsu($id)' class='fas fa-times' style='color: red; font-size: 2.8rem'></i></td>
                      </tr>";
        }
    }
    $conexao->fecharConexao();
    $html .= "</tbody>";
    echo json_encode($html);
}
