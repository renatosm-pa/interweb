<?php
//session_start();

require_once('../banco/banco.php');

$query = new banco();
$query->conecta();

/*

if(is_int($_SESSION['codsessao']) and $_SESSION['datalogin'] == date('d/m/Y')){
	
$_SESSION['clientes']['pesquisa'] = utf8_decode($_REQUEST['pesquisa']);

$campo = utf8_decode($_REQUEST['campo']);
$_SESSION['clientes']['campo'] = utf8_decode($_REQUEST['campo']);

*/

$codusu = asi(utf8_decode($_REQUEST['codusu']));

$sql = "select tus.codsis, ts.nomsis, tus.senha from tabususis tus left join tabsis ts on ts.codsis = tus.codsis where tus.codusu = '".$codusu."';";
$query->consulta($sql);

$array = $query->resultado();

$senha = $array['SENHA'];

if($array['CODSIS'] != ''){ // possui ligacoes na tabela tabususis
	
	$primeiro = $array['CODSIS'];
	
	do{
		$opcoessistemas .= '<option value="'.$array['CODSIS'].'" >'.htmlentities(ucwords(mb_strtolower($array['NOMSIS']))).'</option>';
	}while($array = $query->resultado());
	
	$sql = "select ou.codop, ou.descop, ou.habilita from opcaousu ou where ou.codusu = '".$codusu."' and ou.codsis = '".$primeiro."' order by codop;";
	$query->consulta($sql);
	
	$array2 = $query->resultado();
	
	if($array2['CODOP'] != ''){ // possui permissoes atreladas pela tabela tabususis
		do{
			$x ++;
		
			if(($x%2) == 1 ){
				$classe = 'branco';
			} else {
				$classe = 'cinza';
			}
			
			/*
			if($x == 1){
				$classe .= ' selecionado';
			}
			*/
			
			if($array2['HABILITA'] == 'Sim'){
				$marcado = ' checked="checked" ';
			} else {
				$marcado = '';
			}
			
			$linhas .= '<tr class="'.$classe.'" ><td><input type="hidden" name="codop[]" value="'.$array2['CODOP'].'" />'.str_replace(' ','&nbsp;',htmlentities($array2['DESCOP'])).'</td><td><input type="checkbox" name="habilita[]" value="1" '.$marcado.' /></td></tr>';
			
		}while($array2 = $query->resultado());
		
		$texto = '<table cellpadding="0" cellspacing="0" ><thead><th>Permiss&atilde;o</th><th>Habilitar</th></thead><tbody>'.$linhas.'</tbody></table>';
		
	}
 } else {
	 $opcoessistemas = '<option value="">Nenhum sistema encontrado</option>';
 }

echo($opcoessistemas.'|'.$texto.'|'.$senha);

/*
} else {

echo('Sess&atilde;o Expirou!');
	
}
*/

?>