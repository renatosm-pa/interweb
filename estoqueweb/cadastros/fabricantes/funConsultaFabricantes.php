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


$pesquisa = strtoupper(strtr(asi(utf8_decode($_REQUEST['pesquisa'])) ,"áéíóúâêôãõàèìòùç","ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ"));
$pular = asi(utf8_decode($_REQUEST['pular']));
$campo = asi(utf8_decode($_REQUEST['campo']));
$ordem = asi(utf8_decode($_REQUEST['ordem']));

if($campo == 'CODFAB'){
	$parametros = " CODFAB = '$pesquisa' ";
} else {
	$parametros = " NOMFAB LIKE '%$pesquisa%' ";
}

if(intval($pular) > 0){
	$skip = ' skip '.$pular.' ';
} else {
	$skip = '';
}

$sql = "select first 20 ".$skip." tabfab.codfab, tabfab.nomfab, tabfab.rgcodusu, tabfab.rgusuario, tabfab.rgdata, tabfab.rgevento from TABFAB where ".$parametros." order by ".$ordem." ;";

//echo($sql);

$query->consulta($sql);
$array = $query->resultado();
	
if($array['NOMFAB'] != ''){
	
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
		
		$linhas .= '<tr class="'.$classe.'" onClick=" selecionar(this); " ><td><input type="hidden" name="fabricante[]" value="'.implode('|',$array).'" />'.$array['CODFAB'].'</td><td>'.htmlentities($array['NOMFAB']).'</td></tr>';
		
	} while($array = $query->resultado());

	if(intval($pular) > 0){
		$texto = $linhas;
	} else {
		$texto = '<table cellpadding="0" cellspacing="0" ><thead><th>C&oacute;digo</th><th>Descri&ccedil;&atilde;o</th></thead><tbody>'.$linhas.'</tbody></table><br /><input id="mais" type="button" value="Mais registros" onclick=" consulta(); " />';
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