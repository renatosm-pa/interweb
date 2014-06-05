<?php
session_start();

if(isset($_SESSION['CODUSU']) and isset($_SESSION['NOMUSU']) and isset($_SESSION['SISTEMAS']) and isset($_SESSION['FILIAIS'])){

require_once('../../../banco/banco.php');

$query = new banco();
$query->conecta();

/*
$codcontrato = $_POST['codcontrato'];

if($_SESSION['codven'] != ''){
	$codven = $_SESSION['codven'];
} else {
	if($_POST['vencli'] != ''){
		$codven = $_POST['vencli'];
	} else {
		$codven = '';
	}
}

require("../../banco.php");
$dbh = ibase_connect($host, $username, $password,"ISO8859_1");
require("../../formata.php");

$datai = str_replace('/','.',utf8_decode($_POST['datai']));
$dataf = str_replace('/','.',utf8_decode($_POST['dataf']));

$array_pesquisa = array();

$pesquisaconta = "";

if($_POST['tipodata'] == 'DTVENTIT' ){
	$cabecalhodata = 'VENCIMENTO';
	$tipodata = 'DTVENTIT';
} else {
	if($_POST['tipodata'] == 'DTPAGTIT' ){
		$cabecalhodata = 'PAGAMENTO';
		if($_POST['tabela'] == 'TITULOR'){
			$tipodata = 'DTPREVPAGTIT';
		} else {
			$tipodata = 'DTPAGTIT';
		}
	} else {
		$cabecalhodata = 'ALTERA&Ccedil;&Atilde;O';
		$tipodata = 'RGDATA';	
	}
}

if($datai != '' and $dataf != ''){
	$pesquisadata = " AND ".$tipodata." BETWEEN '".$datai."' AND '".$dataf."' ";
	array_push($array_pesquisa,$tipodata." BETWEEN '".$datai."' AND '".$dataf."'");
	
	$cabecalho = "<br /> ".$cabecalhodata.": '".utf8_decode($_POST['datai'])."' A '".utf8_decode($_POST['dataf'])."' ";
} else {
	$pesquisadata = '';
	$cabecalho = '';
}

if($_POST['tabela'] == 'TITULOR' ){
	$cabecalhotabela = 'EM ABERTO';
} else {
	$cabecalhotabela = 'PAGOS';	
	if($_POST['contabaixa'] != '' and $_POST['contabaixa'] != 'undefined'){
		$pesquisaconta = " AND CODCONTA = '".$_POST['contabaixa']."' ";
		array_push($array_pesquisa," CODCONTA = '".$_POST['contabaixa']."' ");
		
		$sql6 =  "select descconta from TABCONTA where codconta = '".$_POST['contabaixa']."' ;";
		//echo($sql);
		$trans6 = ibase_trans( IBASE_DEFAULT,$dbh );
		$res6 = ibase_query( $sql6 );
		ibase_commit($trans6);
		
		$array6 = ibase_fetch_row($res6);
		
		$cabecalho = $cabecalho.'<br />CONTA: '.$array6[0];
		
	} else {
		$pesquisaconta = "";
	}
}

if($_POST['campo'] == 'CODSETOR' ){
	
	$sql4 = "select nomsetor from tabsetor where codsetor = '".$_POST['setor']."' ;";
	$trans4 = ibase_trans( IBASE_DEFAULT,$dbh );
	$res4 = ibase_query( $sql4 );
	ibase_commit($trans4);
	
	$array4 = ibase_fetch_row($res4);
	
	//$cabecalhosetor = '<br /> SETOR: '.$array4[0];
	$pesquisasetor = " where codsetor = '".$_POST['setor']."'";
	$pesquisasetorlista = " and codcli in(select codcli from tabcli where codsetor = '".$_POST['setor']."') ";
	array_push($array_pesquisa," CODCLI in (select codcli from tabcli where codsetor = '".$_POST['setor']."') ");
	
} else {
	if($_POST['campo'] == 'CODCLI' ){
		if($_POST['consulta'] != ''){
			$consulta = $_POST['consulta'];	
			
			$sql4 = "select nomcli from tabcli where codcli = '".$consulta."' ;";
			$trans4 = ibase_trans( IBASE_DEFAULT,$dbh );
			$res4 = ibase_query( $sql4 );
			ibase_commit($trans4);
			
			$array4 = ibase_fetch_row($res4);
			
			$cabecalho = $cabecalho.'<br /> CLIENTE: '.$array4[0];
			$pesquisacli = " and codcli = '".$consulta."'";
			array_push($array_pesquisa," CODVEN in (select vencli from tabcli where codcli = '".$consulta."') ");
			
		} else {
			$cabecalhocli = '';
			$pesquisacli = "";
		}
	} else {
		$cabecalhosetor = '';
		$pesquisasetor = "";
	}
	$pesquisasetorlista = "";
}
*/

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>RELATORIO</title>
<script src="../../../js/jquery.js" type="text/javascript" ></script>
<script src="../../../js/Highcharts-3.0.10/js/highcharts.js" type="text/javascript" ></script>
<script src="../../../js/Highcharts-3.0.10/js/modules/exporting.js" type="text/javascript" ></script>
<style>

	* {
		font-family:Arial, Helvetica, sans-serif;
	}
	
	p {
		text-align:justify;
	}
	
	table {
		width: 90%;
		margin: 5px auto;
		border-left: 1px solid #000;
		border-top: 1px solid #000; 	
	}
	
	table tr td, table tr th{
		font-size:12px;
		text-align:center;
		padding:3px;
		border-right: 1px solid #000;
		border-bottom: 1px solid #000; 	
	}
	
	table tr th{
		font-size:12px;
		background-color:#000;
		color:#FFF;
		font-weight:bold;
	}
	
	table tr.totais td{
		font-size:12px;
		background-color:#000;
		color:#FFF;
		font-weight:bold;
	}
	
	tr.detalhes {
		display:none;
	}
	
	tr.detalhes td div {
		width: 31%;
		padding:5px;
		margin: 0 5px;
		float:left;
		text-align:left;
	}
	
	#detalhar {
		cursor:pointer;
		position:fixed;
		padding:10px;
		top:0;
		right:0;
		width:150px;
		float:right;
		background: #4F2067;
		color: #ffffff;
		font-weight:bold;
		-webkit-border-bottom-left-radius: 10px;
		-moz-border-radius-bottomleft: 10px;
		border-bottom-left-radius: 10px;
	}
	
</style>
</head>

<body >
<div style="width:30cm; padding:20px">
<div style="border-bottom:1px solid #000; text-align:center; font-weight:bold; " >BALANCETE</div><?php

$datai = str_replace('/','.',utf8_decode($_POST['datai']));
//echo($datai);
$dataf = str_replace('/','.',utf8_decode($_POST['dataf']));
//echo($dataf);

$sql = "select distinct(extract(month from dtemissao)||'/'||extract(year from dtemissao)) as MES from  movifluxo where dtemissao between '".$datai."' and '".$dataf."' order by dtemissao ;";
//echo($sql);

$query->consulta($sql);
$array_meses = array();

$array = $query->resultado();

if($array['MES'] != ''){

	do{
		array_push($array_meses,$array['MES']);
	}while($array = $query->resultado());
	
	$sql = "select distinct(codplan) as codplan from  movifluxo where dtemissao between '".$datai."' and '".$dataf."' ;";
	$query->consulta($sql);
	
	$tabela = '<table align="center" cellpadding="0" cellspacing="0" class="consulta" ><thead><tr><th></th>';
	
	foreach($array_meses as $mes){
		$tabela .= '<th>'.$mes.'</th>';
	}
	
	$tabela .= '</tr></thead><tbody>';
	
	$matriz_planos = array();
	
	$cabecalho_grafico = '<tr><th>&nbsp;</th>';
	
	while($array = $query->resultado()){
		
		$array_plano = array();
		
		$query2 = new banco();
		$query2->conecta();
		$sql2 = "select descplan from tabplacon where codplan = '".$array['CODPLAN']."' ;";
		$query2->consulta($sql2);
		
		$array2 = $query2->resultado();
		
		$tabela .= '<tr><th>'.$array2['DESCPLAN'].'</th>';
		
		$cabecalho_grafico .= '<th>'.$array2['DESCPLAN'].'</th>';
		
		foreach($array_meses as $mes){
			$sql2 = "select sum(case upper(entsai) when 'E' then valormov when 'S' then -valormov end) as valor from movifluxo where codplan = '".$array['CODPLAN']."' and (extract(month from dtemissao)||'/'||extract(year from dtemissao)) = '".$mes."' ;";
			$query2->consulta($sql2);
			$array2 = $query2->resultado();
			
			if($array2['VALOR'] == ''){		
				$tabela .= '<td>-</td>';
				array_push($array_plano,'<td>0.00</td>');
			} else {
				$tabela .= '<td>'.number_format($array2['VALOR'],2,',','.').'</td>';
				array_push($array_plano,'<td>'.$array2['VALOR'].'</td>');
			}
			
		}
		
		$tabela .= '</tr>';
		
		array_push($matriz_planos,$array_plano);
		
	}
	
	$tabela .= '</tbody><table>';
	
	$cabecalho_grafico .= '</tr>';
	
	$tabela_grafico = '<table align="center" id="datatable" ><thead>'.$cabecalho_grafico.'<tbody>';
	
	foreach($array_meses as $key => $mes){
		$tabela_grafico .= '<tr><th>'.$mes.'</th>';
		foreach($matriz_planos as $valor){
			$tabela_grafico .= $valor[$key];
		}
		$tabela_grafico .= '</tr>';
	}
	
	$tabela_grafico .= '</tbody></table>';
	
	echo('<div id="divgrafico">'.$tabela_grafico.'</div>');
	
	echo($tabela);
	
	$query2->desconecta();
} else {
	?><h2>Nenhum registro encontrado</h2><?php
}

$query->desconecta();

?></div><?php

} else {
?>

<h2 align="center" style="font-size:16px">Sua sessão expirou, clique <a href="/interweb">aqui</a> para efetuar login novamente.</h2>
<?php
}
?>
<script id="source" language="javascript" type="text/javascript">
	
	function float2moeda(num){
    x = 0;

    if(num<0)
    {
    num = Math.abs(num);
    x = 1;
    }

    if(isNaN(num))
    num = "0";

    cents = Math.floor((num*100+0.5)%100);

    num = Math.floor((num*100+0.5)/100).toString();

    if(cents < 10) cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
    num = num.substring(0,num.length-(4*i+3))+'.'+num.substring(num.length-(4*i+3)); ret = num + ',' + cents;

    if (x == 1)
    ret = '-' + ret;

    return ret;
    } 
	
	
	Highcharts.visualize = function(table, options) {
	// the categories
	options.xAxis.categories = [];
	$('tbody th', table).each( function(i) {
		options.xAxis.categories.push(this.innerHTML);
	});
	
	// the data series
	options.series = [];
	$('tr', table).each( function(i) {
		var tr = this;
		$('th, td', tr).each( function(j) {
			if (j > 0) { // skip first column
				if (i == 0) { // get the name and init the series
					options.series[j - 1] = { 
						name: this.innerHTML,
						data: []/*,	
						dataLabels: {
				enabled: true,
				rotation: -90,
				color: '#000000',
				align: 'left',
				//width: '100px',
				x: 10,
				y: -10,
				formatter: function() {
					return '';
				},
				style: {
					font: 'bold 13px Verdana, sans-serif'
				}}*/
					};
				} else { // add values
					options.series[j - 1].data.push(parseFloat(this.innerHTML));
				}
			}
		});
	});
	
	var chart = new Highcharts.Chart(options);
}
				
		// On document ready, call visualize on the datatable.
		//$(document).ready(function() {			
			var table = document.getElementById('datatable'),
			options = {
				   chart: {
				      renderTo: 'divgrafico',
				      defaultSeriesType: 'line'
				   },
				   title: {
				      text: ''
				   },
				   xAxis: {
				   },
				   yAxis: {
				      title: {
				         text: 'Valores'
				      }
				   },
				   tooltip: {
				      formatter: function() {
				          return '<b>'+ this.series.name +'</b><br/>'+this.x +': R$ '+float2moeda(this.y);
				      }
				   }
				};
			
		      					
			Highcharts.visualize(table, options);
		//});
</script>
</body>
</html>