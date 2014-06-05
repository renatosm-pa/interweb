<?php

session_start();

header("Content-Type: text/html;  charset=ISO-8859-1",true);

require("../../../banco/banco.php");

$query = new banco();
$query->conecta();

$movimento = $_REQUEST['movimento'];

	switch($movimento){
	case 1:
		
		$sql2 =  "select max(cast(codgru as integer)) from tabgru ;";
		
		$array2 = $query->consulta($sql2);
		$array2 = $query->resultado();
		
		$codigo = intval($array2['MAX']) +1;
		
		$sql = "insert into tabgru(CODGRU, CODGRC, NOMGRU, REMCONTR, MEDICAMENTO, RGCODUSU, RGUSUARIO, RGDATA, RGEVENTO, CFOPD,
		CFOPF, CFOPE)
		values('".completarComZeros($codigo,6)."', '".asi(utf8_decode($_REQUEST['codgrc']))."', 
		'".asi(utf8_decode($_REQUEST['nomgru']))."', '".asi(utf8_decode($_REQUEST['remcontr']))."', 
		'".asi(utf8_decode($_REQUEST['medicamento']))."', '".$_SESSION['CODUSU']."', '".$_SESSION['NOMUSU']."', '".date('d.m.Y')."', 1, 
		'".asi(utf8_decode($_REQUEST['cfopd']))."', '".asi(utf8_decode($_REQUEST['cfopf']))."', 
		'".asi(utf8_decode($_REQUEST['cfope']))."' ); ";
		
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
	
	$codigo = $_REQUEST['codgru'];
	
	$sql = "update tabgru set CODGRC = '".asi(utf8_decode($_REQUEST['codgrc']))."', NOMGRU = '".asi(utf8_decode($_REQUEST['nomgru']))."',
	REMCONTR = '".asi(utf8_decode($_REQUEST['remcontr']))."', MEDICAMENTO = '".asi(utf8_decode($_REQUEST['medicamento']))."', 
	RGCODUSU = '".$_SESSION['CODUSU']."', RGUSUARIO = '".$_SESSION['NOMUSU']."', RGDATA = '".date('d.m.Y')."', RGEVENTO = 2, 
	CFOPD = '".asi(utf8_decode($_REQUEST['cfopd']))."', CFOPF = '".asi(utf8_decode($_REQUEST['cfopf']))."', 
	CFOPE = '".asi(utf8_decode($_REQUEST['cfope']))."'
	where CODGRU = '$codigo'; ";
	//echo($sql);
	$trans = ibase_trans( IBASE_DEFAULT,$dbh );
	$res = ibase_query( $sql );
	ibase_commit($trans);
	
	if($res){
		$resultado = 0;
	} else {
		$resultado = 1;
	}
	
	break;
	case 3:
	
	$codigo = $_REQUEST['codigo'];
	
	$sql = "update tabconta set RGEVENTO = 3, RGCODUSU = ".$_SESSION['codusu'].", RGUSUARIO = '".$_SESSION['usuario']."', 
	RGDATA = '".date('d.m.Y')."' 
	where CODCONTA = '$codigo'; ";
	//echo($sql);
	$trans = ibase_trans( IBASE_DEFAULT,$dbh );
	$res = ibase_query( $sql );
	ibase_commit($trans);
	
	if($res){
		$resultado = 0;
	} else {
		$resultado = 1;
	}
	
	break;
	}

	$query->desconecta();
	//ibase_close($dbh);
	
	echo($resultado.'@'.$codigo.'@'.$rep);
	
?>