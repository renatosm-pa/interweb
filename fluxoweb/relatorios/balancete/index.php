<?php 
session_start();

if(isset($_SESSION['CODUSU']) and isset($_SESSION['NOMUSU']) and isset($_SESSION['SISTEMAS']) and isset($_SESSION['FILIAIS'])){

$opcoes_fil = '';

foreach($_SESSION['FILIAIS'] as $filial){
	$opcoes_fil .= '<option value="'.$filial['CODFIL'].'">'.$filial['NOMFIL'].'</option>';
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>.: Fluxo Web :.</title>
<link href="../../../css/estilo.css" rel="stylesheet" type="text/css" />
<link href="../../../css/menu.css" rel="stylesheet" type="text/css" />
<link href="../../../js/jquery-ui-1.10.3/themes/base/jquery-ui-1.10.4.custom.css" rel="stylesheet" type="text/css" />
<script src="../../../js/jquery.js" type="text/javascript" ></script>
<script src="../../../js/funcoes.js" type="text/javascript" ></script>
<script src="../../../js/jquery-ui-1.10.3/ui/jquery-ui.js" type="text/javascript" ></script>
<script src="../../../js/jquery-ui-1.10.3/ui/jquery.ui.core.js" type="text/javascript" ></script>
<script src="../../../js/jquery-ui-1.10.3/ui/jquery.ui.widget.js" type="text/javascript" ></script>
<script src="../../../js/jquery-ui-1.10.3/ui/jquery.ui.tabs.js" type="text/javascript" ></script>
<script src="../../../js/jquery.maskedinput.js" type="text/javascript" ></script>
<script type="text/javascript">
	$(document).ready(function(){
	
		$('#datai').mask("99/99/9999",{placeholder:""});
				
		
		$("#datai").datepicker({
		dateFormat: 'dd/mm/yy',
		dayNames: [
		'Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'
		],
		dayNamesMin: [
		'D','S','T','Q','Q','S','S','D'
		],
		dayNamesShort: [
		'Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'
		],
		monthNames: [
		'Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro',
		'Outubro','Novembro','Dezembro'
		],
		monthNamesShort: [
		'Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set',
		'Out','Nov','Dez'
		],
		nextText: 'Próximo',
		prevText: 'Anterior'
		});
		
		
		$('#dataf').mask("99/99/9999",{placeholder:""});
				
		
		$("#dataf").datepicker({
		dateFormat: 'dd/mm/yy',
		dayNames: [
		'Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'
		],
		dayNamesMin: [
		'D','S','T','Q','Q','S','S','D'
		],
		dayNamesShort: [
		'Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'
		],
		monthNames: [
		'Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro',
		'Outubro','Novembro','Dezembro'
		],
		monthNamesShort: [
		'Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set',
		'Out','Nov','Dez'
		],
		nextText: 'Próximo',
		prevText: 'Anterior'
		});
		
	});
	
	function valida(){
		if(document.pesquisa.datai.value == ''){
			alert('Preencha o periodo');
			document.pesquisa.datai.focus();
			return false;
		} else {
			if(document.pesquisa.dataf.value == ''){
				alert('Preencha o periodo');
				document.pesquisa.dataf.focus();
				return false;
			} else {
				if(document.pesquisa.datai.value == ''){
					alert('Preencha o periodo');
					document.pesquisa.datai.focus();
					return false;
				} else {
					return true;
				}
			}
		}
	}
	
</script>
</head>
<body>
<?php //echo($pagina); ?>
<div id="cabecalho">
<?php include('../../../cabecalho.php'); ?>
</div>
<div id="menu">
<?php include('../../menu.html'); ?>
</div>
<div id="camada1"></div>
<div id="camada2"></div>
<div id="loading"></div>
<div id="conteudo">
<h2 align="center">Balancete</h2>
<form name="pesquisa" id="pesquisa" method="post" action="relatorio.php" target="_blank" onSubmit=" return valida(); " >
<fieldset>
<div><label>Filial</label> <select name="codfil" id="codfil" size="1" ><option value="">Todas</option><?php echo($opcoes_fil); ?></select></div>
<div><label>Pe&iacute;odo de</label> <input type="text" class="data" name="datai" id="datai" value="01/01/2013<?php //echo(date('d/m/Y')); ?>" /></div>
<div><label>a</label> <input type="text" class="data" name="dataf" id="dataf" value="31/12/2013<?php //echo(date('d/m/Y')); ?>" /></div>
<div><label>Tipo de Conta</label> <select name="tipoconta" id="tipoconta" size="1" ><option value="">Banco</option><option value="">Carteira</option><option value="">Sal&aacute;rio</option></select></div>
<div><label>Conta</label> <select name="conta" id="conta" size="1" ><option value="">Todas</option></select></div>
<div><label>Filial</label> <select name="filial" id="filial" size="1" ><option value="">Todas</option></select></div>
<div><label>Plano de contas</label> <select name="plano" id="plano" size="1" ><option value="">Todos</option></select></div>
<input type="submit" value="Gerar" />
<div class="clear"></div>
</fieldset>
</form>
<form id="res_pesquisa" class="lista"></form>
</div>
<div id="rodape">
<?php include('../../../rodape.php'); ?>
</div>
</body>
</html>
<?php } else { 

header('location: /interweb');

 } ?>