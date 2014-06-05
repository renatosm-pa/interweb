<?php
session_start();

require("banco/banco.php");

$pasta = asi(utf8_decode($_REQUEST['pasta']));
$codsis = asi(utf8_decode($_REQUEST['codsis']));
$nomsis = asi(utf8_decode($_REQUEST['nomsis']));
$senha = asi(utf8_decode($_REQUEST['senha']));
$chave = asi(utf8_decode($_REQUEST['chave']));

if($chave == md5($senha)){
	$_SESSION['SISTEMAS'][$codsis]['HABILITADO'] = true;
	
	$txt = '<div id="sis'.$codsis.'" ><a href="'.$pasta.'" >'.htmlentities(ucfirst(strtolower(strtr($nomsis,"ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ","áéíóúâêôãõàèìòùç")))).'</a></div>|'.$pasta;
} else {
	$txt = 0;
}

echo($txt);

?>