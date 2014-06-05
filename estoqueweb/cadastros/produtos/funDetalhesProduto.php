<?php
//session_start();

require_once('../../../banco/banco.php');

$query = new banco();
$query->conecta();

/*

if(is_int($_SESSION['codsessao']) and $_SESSION['datalogin'] == date('d/m/Y')){
	
$_SESSION['clientes']['pesquisa'] = utf8_decode($_REQUEST['pesquisa']);

$campo = utf8_decode($_REQUEST['campo']);
$_SESSION['clientes']['campo'] = utf8_decode($_REQUEST['campo']);

*/

$pesquisa = strtoupper(strtr(utf8_decode($_REQUEST['pesquisa']) ,"áéíóúâêôãõàèìòùç","ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ"));
$pular = $_REQUEST['pular'];
$campo = $_REQUEST['campo'];
$ordem = $_REQUEST['ordem'];

if($campo == 'CODGRU'){
	$parametros = " CODGRU = '$pesquisa' ";
} else {
	$parametros = " NOMGRU LIKE '%$pesquisa%' ";
}

if(intval($pular) > 0){
	$skip = ' skip '.$pular.' ';
} else {
	$skip = '';
}

$sql = "select first 20 ".$skip." * from TABGRU where ".$parametros." order by ".$ordem." ;";
$query->consulta($sql);
$array = $query->resultado();
	
if($array['CODGRU'] != ''){
	
	$x = $pular;
	
	do{
		$x ++;
		
		if(($x%2) == 1 ){
		$classe = 'branco';
		} else {
		$classe = 'cinza';
		}
		
		if($x == 1){
		$classe .= ' selecionado';
		}
		
		$linhas .= '<tr class="'.$classe.'" onClick=" selecionar(this); " ><td>'.$array['CODGRU'].'</td><td>'.htmlentities($array['NOMGRU']).'</td><td>'.$array['CFOPD'].'</td><td>'.$array['CFOPF'].'</td><td>'.$array['CFOPE'].'</td></tr>';
		
	} while($array = $query->resultado());

	if(intval($pular) > 0){
		$texto = $linhas;
	} else {
		$texto = '<table cellpadding="0" cellspacing="0" ><thead><th>C&oacute;digo</th><th>Descri&ccedil;&atilde;o</th><th>CFOP Dentro</th><th>CFOP Fora</th><th>CFOP Exterior</th></thead><tbody>'.$linhas.'</tbody></table><br />';
	}

	$query->desconecta();

//$resultado = implode('|',$array);

	echo utf8_encode($texto);

} else {
	
	echo(0);
	
}

/*
} else {

echo('Sess&atilde;o Expirou!');
	
}
*/

?>