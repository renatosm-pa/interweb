<?php
session_start();

require_once('../../../banco/banco.php');

$codvas = $_REQUEST["codvas"];
//echo($codcli);

$query = new banco();
$query->conecta();

$sql = "select codpro, descpro from tabpro where codpro = '".completarComZeros($codvas,6)."' ; ";

$query->consulta($sql);

$array = $query->resultado();

$query->desconecta();

if($array['DESCPRO'] != ''){
	echo('0|'.$array['DESCPRO'].'|'.$array['CODPRO']);
} else {
	echo('1');
}

?>