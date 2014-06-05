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

$datai = str_replace('/','.',utf8_decode($_REQUEST['datai']));
//echo($datai);
$dataf = str_replace('/','.',utf8_decode($_REQUEST['dataf']));


$sql = "SELECT SUM(I.QTDVEND*I.VLUNIT+(CASE I.TPDESACRNOT WHEN 'A' THEN I.VLDESACRNOT WHEN 'N' THEN 0 WHEN 'D' THEN 0 END)+(CASE I.TPDESACRITE WHEN 'A' THEN (I.QTDVEND*I.VLDESACRITE) WHEN 'N' THEN 0 WHEN 'D' THEN 0 END)) AS STOTVENDA, SUM(I.VLCUSTO*(I.QTDVEND-I.QTDDEVOL)) AS STOTCUSTO, SUM((CASE I.TPDESACRNOT WHEN 'D' THEN I.VLDESACRNOT WHEN 'N' THEN 0 WHEN 'A' THEN 0 END)+(CASE I.TPDESACRITE WHEN 'D' THEN (I.QTDVEND*I.VLDESACRITE) WHEN 'N' THEN 0 WHEN 'A' THEN 0 END)) AS STOTDESC, SUM(I.QTDDEVOL*I.VLUNIT+(CASE I.TPDESACRITE WHEN 'A' THEN (I.QTDDEVOL*I.VLDESACRITE) WHEN 'N' THEN 0 WHEN 'D' THEN 0 END)) AS STOTDEVOL  FROM NOTASAI N, NOTASAIITENS I WHERE (N.NRCONTR = I.NRCONTR) AND ((N.SITUACAO = 'N') OR (N.SITUACAO = 'E')) AND (N.TPPAGAM <> 'CP') and N.DTEMISSAO between '".$datai."' and '".$dataf."';";
$query->consulta($sql);
$array = $query->resultado();

$texto = '0|'.implode('|',$array);

$sql = "select p.codplandre, sum(case upper(m.entsai) when 'E' then m.valormov when 'S' then -m.valormov end) as valor from movifluxo m left join tabplacon p on p.codplan = m.codplan where p.codplandre is not null and m.dtemissao between '".$datai."' and '".$dataf."' group by p.codplandre;";

$query->consulta($sql);

while($array = $query->resultado()){
	$array_valores[$array['CODPLANDRE']] = $array['VALOR'];
}

$sql = "select codplandre from tabplacondre order by codplandre;";

$query->consulta($sql);

$array_fluxo = array();

while($array = $query->resultado()){
	if($array_valores[$array['CODPLANDRE']] != ''){
		if($array_valores[$array['CODPLANDRE']] < 0.00){
			$array_fluxo[$array['CODPLANDRE']] = $array_valores[$array['CODPLANDRE']]*(-1);
		} else {
			$array_fluxo[$array['CODPLANDRE']] = $array_valores[$array['CODPLANDRE']];
		}
	} else {
		$array_fluxo[$array['CODPLANDRE']] = 0.00;
	}
}

$texto .= '@'.implode('|',$array_fluxo);

echo($texto);

?>