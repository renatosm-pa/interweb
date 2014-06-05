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
$codsis = asi(utf8_decode($_REQUEST['codsis']));

$sql = "select senha from tabususis where codusu = '".$codusu."' and codsis = '".$codsis."' ;";
$query->consulta($sql);

$array = $query->resultado();

$senha = $array['SENHA'];

if($codsis != ''){
	
	$sql = "select ou.codop, ou.descop, ou.habilita from opcaousu ou where ou.codusu = '".$codusu."' and ou.codsis = '".$codsis."' order by codop;";
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
			
			$linhas .= '<tr class="'.$classe.'" onClick=" selecionar(this); " ><td><input type="hidden" name="codop[]" value="'.$array2['CODOP'].'" />'.str_replace(' ','&nbsp;',htmlentities($array2['DESCOP'])).'</td><td><input type="checkbox" name="habilita[]" value="1" '.$marcado.' /></td></tr>';
			
		}while($array2 = $query->resultado());
		
		$texto = '<table cellpadding="0" cellspacing="0" ><thead><th>Permiss&atilde;o</th><th>Habilitar</th></thead><tbody>'.$linhas.'</tbody></table>';
		
	} else { // procura permissoes de qualquer usuario para o sistema escolhido
		
		$sql = "select first 1 distinct codusu from opcaousu where codsis = '".$codsis."';";
		$query->consulta($sql);
		
		$array = $query->resultado();
		
		$codusuopcao = $array['CODUSU'];
		
		if($codusuopcao != ''){
			
			$sql = "select ou.codop, ou.descop, ou.habilita from opcaousu ou where ou.codusu = '".$codusuopcao."' and ou.codsis = '".$codsis."' order by codop;";
			$query->consulta($sql);
			
			$array2 = $query->resultado();
			
			if($array2['CODOP'] != ''){ // permissoes de usuario qualquer encontradas
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
					
					$linhas .= '<tr class="'.$classe.'" onClick=" selecionar(this); " ><td><input type="hidden" name="codop[]" value="'.$array2['CODOP'].'" />'.str_replace(' ','&nbsp;',htmlentities($array2['DESCOP'])).'</td><td><input type="checkbox" name="habilita[]" value="1" '.$marcado.' /></td></tr>';
					
				}while($array2 = $query->resultado());
				
				$texto = '<table cellpadding="0" cellspacing="0" ><thead><th>Permiss&atilde;o</th><th>Habilitar</th></thead><tbody>'.$linhas.'</tbody></table>';
				
			} else {
				$texto = '<h2>Nenhuma permissao encontrada para esse sistema</h2>';
			}
		} else {
			$texto = '<h2>Nenhuma permissao encontrada para esse sistema</h2>';
		}
	}
}

echo($senha.'|'.$texto);

/*
} else {

echo('Sess&atilde;o Expirou!');
	
}
*/

?>