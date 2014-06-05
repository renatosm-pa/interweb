<?php
session_start();

require_once('../../../banco/banco.php');

$codpro = $_REQUEST["codpro"];
//echo($codcli);

$query = new banco();
$query->conecta();

$sql = "select tabproagr.acagr, tabproagr.alagr, tabproagr.amagr, tabproagr.apagr, tabproagr.baagr, tabproagr.ceagr, tabproagr.dfagr, tabproagr.esagr, tabproagr.goagr, tabproagr.maagr, tabproagr.mtagr, tabproagr.msagr, tabproagr.mgagr, tabproagr.paagr, tabproagr.pbagr, tabproagr.pragr, tabproagr.peagr, tabproagr.piagr, tabproagr.rnagr, tabproagr.rsagr, tabproagr.rjagr, tabproagr.roagr, tabproagr.rragr, tabproagr.scagr, tabproagr.spagr, tabproagr.seagr, tabproagr.toagr from tabproagr where codpro = '$codpro'; ";

$query->consulta($sql);

$array = $query->resultado();

echo($array['ACAGR'].'|'.$array['ALAGR'].'|'.$array['AMAGR'].'|'.$array['APAGR'].'|'.$array['BAAGR'].'|'.$array['CEAGR'].'|'.$array['DFAGR'].'|'.$array['ESAGR'].'|'.$array['GOAGR'].'|'.$array['MAAGR'].'|'.$array['MTAGR'].'|'.$array['MSAGR'].'|'.$array['MGAGR'].'|'.$array['PAAGR'].'|'.$array['PBAGR'].'|'.$array['PRAGR'].'|'.$array['PEAGR'].'|'.$array['PIAGR'].'|'.$array['RNAGR'].'|'.$array['RSAGR'].'|'.$array['RJAGR'].'|'.$array['ROAGR'].'|'.$array['RRAGR'].'|'.$array['SCAGR'].'|'.$array['SPAGR'].'|'.$array['SEAGR'].'|'.$array['TOAGR']);

$query->desconecta();

//ibase_close($dbh);
//$resultado = implode('|',$array);

?>