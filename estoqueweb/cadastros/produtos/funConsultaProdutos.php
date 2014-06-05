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

if($campo == 'CODPRO'){
	$parametros = " CODPRO = '$pesquisa' ";
} else {
	$parametros = " DESCPRO LIKE '%$pesquisa%' ";
}

if(intval($pular) > 0){
	$skip = ' skip '.$pular.' ';
} else {
	$skip = '';
}

$sql = "select first 20 ".$skip." ";

$sql .= "tabpro.codpro, tabpro.descpro, tabpro.detalhe, tabpro.codbarun, tabpro.codbarcx, tabpro.codrefer, tabpro.unemb, tabpro.qtdemb, tabpro.unidade, tabpro.codvas, tabpro.vlcomi,";
//10
$sql .= "tabpro.grupro, tabpro.fabpro, tabpro.forpro01, tabpro.forpro02, tabpro.forpro03, tabpro.docfor01, tabpro.docfor02, tabpro.docfor03, tabpro.qtdultent01, tabpro.qtdultent02,";
//20
$sql .= "tabpro.qtdultent03, tabpro.ultprcom01, tabpro.ultprcom02, tabpro.ultprcom03, tabpro.dtultcom01, tabpro.dtultcom02, tabpro.dtultcom03, tabpro.dtchegada, tabpro.dtsaipro, tabpro.icms,";
//30
$sql .= "tabpro.indice, tabpro.peso, tabpro.largura, tabpro.altura, tabpro.massacompr, tabpro.contrquant, tabpro.contrrefer, tabpro.contrcomp, tabpro.contrponto, tabpro.baixaponto,";
//40
$sql .= " tabpro.stprod, tabpro.qualprod, tabpro.rgcodusu, tabpro.rgusuario, tabpro.rgdata, tabpro.rgevento, tabpro.alicmscom, tabpro.alipicom, tabpro.prcustocom, tabpro.vldescocom,";
//50
$sql .= " tabpro.vlfretecom, tabpro.vlsegcom, tabpro.outdespcom, tabpro.fatorirpj, tabpro.fatorcsll, tabpro.fatorpis, tabpro.fatorcofins, tabpro.substrib, tabpro.ipi, tabpro.percipi,";
//60
$sql .= " tabpro.meioameio, tabpro.ultprcompra, tabpro.prmepro, tabpro.tpsubest, tabpro.modelo, tabpro.tamanho, tabpro.indcomp, tabpro.perclucro, tabpro.remcontr, tabpro.libquant,";
//70
$sql .= " tabpro.vlcomiavva, tabpro.vlcomiccva, tabpro.vlcomiapva, tabpro.vlcomiavat, tabpro.vlcomiccat, tabpro.vlcomiapat, tabpro.dtvenc01, tabpro.dtvenc02, tabpro.ltvenc01, tabpro.ltvenc02,";
//80
$sql .= " tabpro.balanca, tabpro.clasfiscal, tabpro.codaluser, tabpro.codcolecao, tabpro.quantped, tabpro.dtchegped, tabpro.corconsul, tabpro.casadec, tabpro.cst, tabpro.fatorsubst,";
//90
$sql .= " tabpro.tribmono, tabpro.pesobruto, tabpro.pesoliquido, tabpro.libdesconto, tabpro.tipoitem, tabpro.exipi, tabpro.codgen, tabpro.codlst, tabpro.codanp, tabpro.codif,";
//100
$sql .= " tabpro.clasterap, tabpro.usoprolong, tabpro.regmsmed, tabpro.unidmed, tabpro.coddcbins, tabpro.cores, tabpro.cestabas, tabpro.desonfolha, tabpro.diasvenc, tabpro.origprod";
//110
$sql .= " from TABPRO where ".$parametros." order by ".$ordem." ;";
$query->consulta($sql);
$array = $query->resultado();
	
if($array['CODPRO'] != ''){
	
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
		
		$linhas .= '<tr class="'.$classe.'" onClick=" selecionar(this); " ><td class="esconder"><input type="hidden" name="produto[]" value="'.implode('|',$array).'" />'.$array['CODPRO'].'</td><td class="esconder">'.$array['CODBARUN'].'</td><td>'.htmlentities($array['DESCPRO']).'</td><td class="esconder">'.$array['UNEMB'].'</td><td class="esconder">'.$array['QTDEMB'].'</td><td class="esconder">'.$array['UNIDADE'].'</td></tr>';
		
	} while($array = $query->resultado());

	if(intval($pular) > 0){
		$texto = $linhas;
	} else {
		$texto = '<table cellpadding="0" cellspacing="0" ><thead><th class="esconder">C&oacute;digo</th><th class="esconder">C&oacute;digo de Barras</th><th>Nome do Produto</th><th class="esconder">Emb.</th><th class="esconder">Qtd. Emb.</th><th class="esconder">Unid.</th></thead><tbody>'.$linhas.'</tbody></table><br /><input id="mais" type="button" value="Mais registros" onclick=" consulta(); " />';
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