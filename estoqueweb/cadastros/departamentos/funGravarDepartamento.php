<?php

session_start();

header("Content-Type: text/html;  charset=ISO-8859-1",true);

require("../../../banco/banco.php");

$query = new banco();
$query->conecta();

$movimento = $_REQUEST['movimento'];

	switch($movimento){
	case 1:
		
		$sql2 =  "select max(codgrc) from tabgrc ;";
		
		$array2 = $query->consulta($sql2);
		$array2 = $query->resultado();
		
		$codigo = intval($array2['MAX'])+1;
		
		$sql = "insert into tabgrc(CODGRC, NOMGRC, RGCODUSU, RGUSUARIO, RGDATA, RGEVENTO)
		values($codigo, '".asi(utf8_decode($_REQUEST['nomgrc']))."', '".$_SESSION['CODUSU']."', '".$_SESSION['NOMUSU']."', 
		'".date('d.m.Y')."', 1 ); ";
		
		$sql = str_replace("''",'null',$sql);
		//echo($sql);
		
		$res = $query->consulta($sql);
			
		if($res){
			$resultado = 0;
		} else {
			$resultado = 1;
		}
	
	break;
	case 2:
		
		if($_REQUEST['codgrc'] != ''){
		
			$codigo = $_REQUEST['codgrc'];
			
			$sql = "update tabgrc set NOMGRC = '".asi(utf8_decode($_REQUEST['nomgrc']))."', RGCODUSU = '".$_SESSION['CODUSU']."', 
			RGUSUARIO = '".$_SESSION['NOMUSU']."', RGDATA = '".date('d.m.Y')."', RGEVENTO = 2 where codgrc = '$codigo'; ";
			
			//$sql = str_replace("''",'null',$sql);
			//echo($sql);
			
			$res = $query->consulta($sql);
				
			if($res){
				$resultado = 0;
			} else {
				$resultado = 1;
			}
		
		} else {
			$res = false;
		}
	
	break;
	}

	$query->desconecta();
	
	echo($resultado.'@'.$codigo.'@'.$rep);
	
?>