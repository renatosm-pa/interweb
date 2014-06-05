<?php 
session_start();

if(isset($_SESSION['CODUSU']) and isset($_SESSION['NOMUSU']) and isset($_SESSION['SISTEMAS']) and isset($_SESSION['FILIAIS'])){

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
<script src="../../../js/jquery.maskmoeda.js" type="text/javascript" ></script>
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
		
		$('.valor').priceFormat({
			prefix: '',
			centsSeparator: ',',
			thousandsSeparator: '.',
			limit: 17,
			centsLimit: 2
		});
		
		$('.valor').keyup(function(){ calcDRE(); })
		
	});
	
	function buscarValores(){
			
			var dados = $('#pesquisa').serialize();
			
			//alert(dados);
			
			$.ajax({type: "POST",url: "funBuscarValores.php",data: dados ,beforeSend: function() {
			
				$('#loading').fadeIn();
			
			},success: function(txt) {
			
				//alert(txt);
				
				$('#loading').fadeOut();
				
				matriz = txt.split('@');
				array = matriz[0].split('|');
				array_fluxo = matriz[1].split('|');
				
				if(array[0] == '0'){
					document.pesquisa.rob.value = float2moeda(parseFloat(array[1]).toFixed(2));
					document.pesquisa.da.value = float2moeda((parseFloat(array[3])+parseFloat(array[4])).toFixed(2));
					//document.pesquisa.da.value = float2moeda(array[2]);
					document.pesquisa.custo.value = float2moeda(parseFloat(array[2]).toFixed(2));
					
					/* ---------------- fluxo -----------------------*/
					
					document.pesquisa.deso.value = float2moeda(parseFloat(array_fluxo[2]).toFixed(2));
					document.pesquisa.desa.value = float2moeda(parseFloat(array_fluxo[3]).toFixed(2));
					document.pesquisa.desv.value = float2moeda(parseFloat(array_fluxo[4]).toFixed(2));
					document.pesquisa.desf.value = float2moeda(parseFloat(array_fluxo[5]).toFixed(2));
					document.pesquisa.recf.value = float2moeda(parseFloat(array_fluxo[6]).toFixed(2));
					document.pesquisa.orecdes.value = float2moeda(parseFloat(array_fluxo[7]).toFixed(2));
					document.pesquisa.recdesno.value = float2moeda(parseFloat(array_fluxo[8]).toFixed(2));
					document.pesquisa.cssl.value = float2moeda(parseFloat(array_fluxo[9]).toFixed(2));
					document.pesquisa.pir.value = float2moeda(parseFloat(array_fluxo[10]).toFixed(2));
					document.pesquisa.participacoes.value = float2moeda(parseFloat(array_fluxo[11]).toFixed(2));
					
					/* ---------------- fluxo fim -------------------*/
				}
				
				calcDRE();
				
			}});
			
			return false;
		}
		
		function calcDRE(){
			
			var rob = moeda2float(document.pesquisa.rob.value);
			
			var da = moeda2float(document.pesquisa.da.value);
			
			var imposto = moeda2float(document.pesquisa.imposto.value);
			
			var rol = rob-da-imposto;
			
			document.pesquisa.rol.value = float2moeda(parseFloat(rol).toFixed(2));
			
			var custo = moeda2float(document.pesquisa.custo.value);
			
			var resob = rol-custo;
			
			document.pesquisa.resob.value = float2moeda(parseFloat(resob).toFixed(2));
			
			var deso = moeda2float(document.pesquisa.deso.value);
			var desa = moeda2float(document.pesquisa.desa.value);
			var desv = moeda2float(document.pesquisa.desv.value);
			var desf = moeda2float(document.pesquisa.desf.value);
			var recf = moeda2float(document.pesquisa.recf.value);
			var orecdes = moeda2float(document.pesquisa.orecdes.value);
			
			var resol = resob-deso-desa-desv-desf+recf+orecdes;
			
			document.pesquisa.resol.value = float2moeda(parseFloat(resol).toFixed(2));
			
			var recdesno = moeda2float(document.pesquisa.recdesno.value);
			
			var resaci = resol+recdesno;
			
			document.pesquisa.resaci.value = float2moeda(parseFloat(resaci).toFixed(2));
			
			var cssl = moeda2float(document.pesquisa.cssl.value);
			
			var lai = resaci-cssl;
			
			document.pesquisa.lai.value = float2moeda(parseFloat(lai).toFixed(2));
			
			var pir = moeda2float(document.pesquisa.pir.value);
			
			var resai = lai-pir;
			
			document.pesquisa.resai.value = float2moeda(parseFloat(resai).toFixed(2));
			
			var participacoes = moeda2float(document.pesquisa.participacoes.value);
			
			var lple = resai-participacoes;
			
			document.pesquisa.lple.value = float2moeda(parseFloat(lple).toFixed(2));
			
		}
	
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
				return true;
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
<h2 align="center">Demonstrativo de Rendimento do Exerc&iacute;cio</h2>
<form name="pesquisa" id="pesquisa" method="post" onSubmit=" return false; " >
    <fieldset>
        <div><label>Pe&iacute;odo de</label> <input type="text" class="data" name="datai" id="datai" value="01/01/2013<?php //echo(date('d/m/Y')); ?>" /></div>
        <div><label>a</label> <input type="text" class="data" name="dataf" id="dataf" value="31/12/2013<?php //echo(date('d/m/Y')); ?>" /></div>
        <div class="clear"></div>
        <div class="dre">
            <div class="tot"><label>Receita Operacional Bruta</label> <input type="text" name="rob" id="rob" value="0,00" disabled="disabled" /></div>
            <div class="deb"><label> [-] Devolu&ccedil;&atilde;o e Abatimento</label> <input type="text" name="da" id="da" value="0,00" disabled="disabled" /></div>
            <div class="deb"><label> [-] Imposto sobre Vendas</label> <input type="text" name="imposto" id="imposto" class="valor" value="0,00" /></div>
            <div class="tot"><label> [=] Receita Operacional L&iacute;quida</label> <input type="text" name="rol" id="rol" value="0,00" disabled="disabled" /></div>
            <div class="deb"><label> [-] CMV / CPV / CSP</label> <input type="text" name="custo" id="custo" value="0,00" disabled="disabled" /></div>
            <div class="tot"><label> [=] Resultado Operacional Bruto</label> <input type="text" name="resob" id="resob" value="0,00" disabled="disabled" /></div>
            <div class="deb"><label> [-] Despesas Operacionais</label> <input type="text" name="deso" id="deso" value="0,00" disabled="disabled" /></div>
            <div class="deb"><label> [-] Despesas Administrativas</label> <input type="text" name="desa" id="desa" value="0,00" disabled="disabled" /></div>
            <div class="deb"><label> [-] Despesas de Vendas</label> <input type="text" name="desv" id="desv" value="0,00" disabled="disabled" /></div>
            <div class="deb"><label> [-] Despesas Financeiras</label> <input type="text" name="desf" id="desf" value="0,00" disabled="disabled" /></div>
            <div class="cred"><label> [+] Receitas Financeiras</label> <input type="text" name="recf" id="recf" value="0,00" disabled="disabled" /></div>
            <div class="cred"><label> [+/-] Outras Receitas e Despesas</label> <input type="text" name="orecdes" id="orecdes" value="0,00" disabled="disabled" /></div>
            <div class="tot"><label> [=] Resultado Operacional L&iacute;quido</label> <input type="text" name="resol" id="resol" value="0,00" disabled="disabled" /></div>
        </div>
        <div class="dre">
            <div class="cred"><label> [+/-] Receitas e Despesas n&atilde;o Operacionais</label> <input type="text" name="recdesno" id="recdesno" value="0,00" disabled="disabled" /></div>
            <div class="tot"><label> [=] Resultado Antes de CS e IR</label> <input type="text" name="resaci" id="resaci" value="0,00" disabled="disabled" /></div>
            <div class="deb"><label> [-] Contribui&ccedil;&atilde;o Social sobre Lucro</label> <input type="text" name="cssl" id="cssl" class="valor" value="0,00" /></div>
            <div class="tot"><label> [=] Lucro Antes de CS e IR</label> <input type="text" name="lai" id="lai" value="0,00" disabled="disabled" /></div>
            <div class="deb"><label> [-] Provis&atilde;o para Imposto de Renda</label> <input type="text" name="pir" id="pir" class="valor" value="0,00" /></div>
            <div class="tot"><label> [=] Resultado Ap&oacute;s Imposto de Renda</label> <input type="text" name="resai" id="resai" value="0,00" disabled="disabled" /></div>
            <div class="deb"><label> [-] Participa&ccedil;&otilde;es (somente S/A)</label> <input type="text" name="participacoes" id="participacoes" class="valor" value="0,00" /></div>
            <div class="tot"><label>LUCRO ou PREJU&Iacute;ZO l&iacute;quido do exerc&iacute;cio</label> <input type="text" name="lple" id="lple" value="0,00" disabled="disabled" /></div>
        </div>
        <div class="clear"></div>
        <input type="submit" value="Gerar" onClick="buscarValores();" />
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