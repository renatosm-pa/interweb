<?php

session_start();

header("Content-Type: text/html;  charset=ISO-8859-1",true);

require("../banco/banco.php");

$query = new banco();
$query->conecta();

$movimento = $_REQUEST['movimento'];

	switch($movimento){
	case 1:
		
		$sql3 =  "select count(codigo) from tabusu where nome = '".asi(utf8_decode($_REQUEST['nome']))."' and sistema = '".asi(utf8_decode($_REQUEST['sistema']))."' ;";
		
		$query->consulta($sql3);
		$array3 = $query->resultado();
		
		if($array3['COUNT'] > 0){
			$resultado = 2;
		} else {
			$sql2 =  "select max(codigo) from tabusu ;";
			
			$query->consulta($sql2);
			$array2 = $query->resultado();
			
			$codigo = intval($array2['MAX'])+1;
			
			$sql = "insert into tabusu(codigo, nome, senha, tipousu, sistema, codven, rgcodusu, rgusuario, rgdata, rgevento, percdescav, 
			percdesccc, percdescap, percdesccoav, percdescatav, percdesccocc, percdescatcc, percdesccoap, percdescatap, percdescjur, 
			percdescmul, percdesctit)
			values($codigo, '".asi(utf8_decode($_REQUEST['nome']))."', '".asi(utf8_decode($_REQUEST['senha']))."', 
			'".asi(utf8_decode($_REQUEST['tipousu']))."', '".asi(utf8_decode($_REQUEST['sistema']))."', 
			'".asi(utf8_decode($_REQUEST['codven']))."', '".$_SESSION['CODUSU']."', '".$_SESSION['NOMUSU']."', '".date('d.m.Y')."', 1, 
			'".str_replace(',','.',asi(utf8_decode($_REQUEST['percdescav'])))."', 
			'".str_replace(',','.',asi(utf8_decode($_REQUEST['percdesccc'])))."', 
			'".str_replace(',','.',asi(utf8_decode($_REQUEST['percdescap'])))."', 
			'".str_replace(',','.',asi(utf8_decode($_REQUEST['percdesccoav'])))."', 
			'".str_replace(',','.',asi(utf8_decode($_REQUEST['percdescatav'])))."', 
			'".str_replace(',','.',asi(utf8_decode($_REQUEST['percdesccocc'])))."', 
			'".str_replace(',','.',asi(utf8_decode($_REQUEST['percdescatcc'])))."', 
			'".str_replace(',','.',asi(utf8_decode($_REQUEST['percdesccoap'])))."', 
			'".str_replace(',','.',asi(utf8_decode($_REQUEST['percdescatap'])))."', 
			'".str_replace(',','.',asi(utf8_decode($_REQUEST['percdescjur'])))."', 
			'".str_replace(',','.',asi(utf8_decode($_REQUEST['percdescmul'])))."', 
			'".str_replace(',','.',asi(utf8_decode($_REQUEST['percdesctit'])))."'); ";
			
			$sql = str_replace("''",'null',$sql);
			//echo($sql);
			
			$res = $query->consulta($sql);
				
			if($res){
				$resultado = 0;
			} else {
				$resultado = 1;
			}
		}
	break;
	case 2:
		
		if($_REQUEST['codigo'] != ''){
		
			$codigo = $_REQUEST['codigo'];
			
			$sql = "update tabusu set NOME = '".asi(utf8_decode($_REQUEST['nome']))."', RGCODUSU = '".$_SESSION['CODUSU']."', 
			RGUSUARIO = '".$_SESSION['NOMUSU']."', RGDATA = '".date('d.m.Y')."', RGEVENTO = 2 where codigo = '$codigo'; ";
			
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