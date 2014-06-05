<?php
session_start();

require_once('../../../banco/banco.php');

$consulta = $_GET["term"];
//echo($codcli);

$query = new banco();
$query->conecta();

$sql = "select first 5 codpro, descpro from tabpro where descpro like upper('".$consulta."%') order by descpro; ";

$query->consulta($sql);

$array_cod = array();

while($array = $query->resultado()){
	//array_push($result, array("id"=>$value, "label"=>$key, "value" => strip_tags($key)));
	array_push($array_cod,array("id"=>$array['CODPRO'], "label"=>$array['DESCPRO'], "value" => strip_tags($array['DESCPRO'])));
}

//echo(implode(',',$array_cod));

//ibase_close($dbh);

$query->desconecta();

//$resultado = implode('|',$array);

//echo utf8_encode($texto);

echo json_encode($array_cod);

?>