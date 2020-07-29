<?php
$servidor = "localhost";
$porta = 5432;
$bancoDeDados = "arcondicionado03";
$usuario = "postgres";
$senha = "Infosoft";

global $con;

$con = pg_connect("host=$servidor port=$porta dbname=$bancoDeDados user=$usuario password=$senha");
?>