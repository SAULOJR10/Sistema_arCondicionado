<?php
include_once "../comum/conexao.php";

$nome = filter_input(INPUT_GET, 'term', FILTER_SANITIZE_STRING);
    
$sql = "SELECT * FROM proprietarios WHERE nome LIKE '$nome' ORDER BY nome ASC LIMIT 7";
$exe = pg_query($GLOBALS['con'], $sql);

while ($result = pg_fetch_assoc($exe)){
    $data[] = $result['nome'];
}

echo json_encode($data);
?>