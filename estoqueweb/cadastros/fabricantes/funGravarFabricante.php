<?php

session_start();

header("Content-Type: text/html;  charset=ISO-8859-1",true);

require("../../../banco/banco.php");

$query = new banco();
$query->conecta();

$movimento = $_REQUEST['movimento'];

	switch($movimento){
	case 1:
		
		$sql2 =  "select max(codfab) from tabfab ;";
		
		$array2 = $query->consulta($sql2);
		$array2 = $query->resultado();
		
		$codigo = intval($array2['MAX'])+1;
		
		$sql = "insert into tabfab(CODFAB, NOMFAB, RGCODUSU, RGUSUARIO, RGDATA, RGEVENTO)
		values($codigo, '".asi(utf8_decode($_REQUEST['nomfab']))."', '".$_SESSION['CODUSU']."', '".$_SESSION['NOMUSU']."', 
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
		
		if($_REQUEST['codfab'] != ''){
		
			$codigo = $_REQUEST['codfab'];
			
			$sql = "update tabfab set NOMFAB = '".asi(utf8_decode($_REQUEST['nomfab']))."', RGCODUSU = '".$_SESSION['CODUSU']."', 
			RGUSUARIO = '".$_SESSION['NOMUSU']."', RGDATA = '".date('d.m.Y')."', RGEVENTO = 2 where codfab = '$codigo'; ";
			
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