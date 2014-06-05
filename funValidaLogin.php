<?php
session_start();

require("banco/banco.php");

$login = asi(utf8_decode($_REQUEST['login']));
$login = strtoupper(strtr($login ,"áéíóúâêôãõàèìòùç","ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ"));
$senha = asi(utf8_decode($_REQUEST['senha']));

//$browser = str_replace($proibidos,$caracteres,utf8_decode($_REQUEST['browser']));
//$versao = str_replace($proibidos,$caracteres,utf8_decode($_REQUEST['versao']));
//$tipousu = str_replace($proibidos,$caracteres,utf8_decode($_REQUEST['tipousu']));

$ip = $_SERVER['REMOTE_ADDR'];

$query = new banco();
$query->conecta();

$sql =  "select count(codigo) from TABUSU where rgevento <> 3 and NOME = '$login' ;";
//echo($sql);
$query->consulta($sql);
$array = $query->resultado();

$usuarios = $array['COUNT'];

/*
resultado

1 = login ok
2 = Operador nao encontrado
3 = senha incorreta
4 = usuario nao possui acesso a nenhuma filial
5 = usuario nao possui acesso a nenhum sistema

*/

$codusu = '';
$nomusu = '';

$array_filiais = array();
$array_sistemas = array();

$resultado = 1;

if($usuarios == 0){
	$resultado = 2;
} else {
	$sql =  "select * from TABUSU where rgevento <> 3 and NOME = '$login' ;";
	//echo($sql);
	$query->consulta($sql);
	
	while($array = $query->resultado()){
		if($senha == $array['SENHA']){
			$codusu = $array['CODIGO'];
			$nomusu = $array['NOME'];
			break;
		}
	}
	
	if($codusu == '' or $nomusu == ''){
		$resultado = 3;
	} else {
		
		$sql =  "select TUF.CODFIL, TF.NOMFIL from TABUSUFIL TUF left join TABFIL TF on TF.CODFIL = TUF.CODFIL where TUF.codusu = '$codusu' order by TUF.codfil ;";
		//echo($sql);
		$query->consulta($sql);
		
		$array2 = $query->resultado();
		
		if($array2['CODFIL'] == ''){
			$resultado = 5;
		} else {
			do{
				array_push($array_filiais,array('CODFIL' => $array2['CODFIL'], 'NOMFIL' => $array2['NOMFIL']));
			}while($array3 = $query->resultado());
		}
		
		if($resultado != 5){
			$sql =  "select * from TABUSUSIS where codusu = '$codusu' ;";
			//echo($sql);
			$query->consulta($sql);
			$array3 = $query->resultado();
			
			if($array3['CODSIS'] == ''){
				$resultado = 4;
			} else {
				do{
					if($array3['SENHA'] == '' or $array3['SENHA'] == $senha){
						$array_sistemas[$array3['CODSIS']]['HABILITADO'] = true;
					} else {
						$array_sistemas[$array3['CODSIS']]['HABILITADO'] = false;
					}
					$array_sistemas[$array3['CODSIS']]['CODSIS'] = $array3['CODSIS'];
					$array_sistemas[$array3['CODSIS']]['SENHA'] = md5($array3['SENHA']);
				}while($array3 = $query->resultado());
			}
			
			if($resultado == 1){
				
				$_SESSION['CODUSU'] = $codusu;
				$_SESSION['NOMUSU'] = $nomusu;
				$_SESSION['FILIAIS'] = $array_filiais;
				$_SESSION['SISTEMAS'] = $array_sistemas;
				
			}
		}
	}
}

$query->desconecta();

echo($resultado);
//echo($array);
?>
