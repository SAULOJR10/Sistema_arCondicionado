<?php
include_once '../bib/conexao.php';

$source = pg_escape_string($_GET['term']);
$sql = "SELECT * FROM proprietarios WHERE nome LIKE '%$source%' ORDER BY nome";
$exe = pg_query($GLOBALS['con'], $sql);

$resultado = '[';
$teste = true;

while ($result = pg_fetch_assoc($exe)) {
    if (!$teste) {
        $resultado .= ', ';
    } else {
        $teste = false;
    }
    $resultado .= json_encode($result['nome']);
}

$resultado .= ']';

echo $resultado;
?>