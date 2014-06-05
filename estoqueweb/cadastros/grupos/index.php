<?php 
session_start();

if(isset($_SESSION['CODUSU']) and isset($_SESSION['NOMUSU']) and isset($_SESSION['SISTEMAS']) and isset($_SESSION['FILIAIS'])){

require_once('../../../banco/banco.php');

$query = new banco();
$query->conecta();

$sql = "select * from tabgrc order by nomgrc;";
$query->consulta($sql);
//$array = $query->resultado();

$grc_cod = array();
$grc_desc = array();

while($array = $query->resultado()){
	array_push($grc_cod,$array['CODGRC']);
	array_push($grc_desc,$array['NOMGRC']);
	$opcoesgrc .= '<option value="'.$array['CODGRC'].'" >'.htmlentities(ucwords(strtolower($array['NOMGRC']))).'</option>';
}

$sql = "select * from natoper order by cfops;";
$query->consulta($sql);
//$array = $query->resultado();

$natops_cod = array();
$natops_desc = array();

$natope_cod = array();
$natope_desc = array();

while($array = $query->resultado()){
	array_push($natops_cod,$array['CFOPS']);
	array_push($natops_desc,$array['NATOPS']);
	$opcoesnatops .= '<option value="'.$array['CFOPS'].'" >'.$array['CFOPS'].' - '.htmlentities(ucwords(strtolower($array['NATOPS']))).'</option>';
	
	array_push($natope_cod,$array['CFOPS']);
	array_push($natope_desc,$array['NATOPE']);
	$opcoesnatope .= '<option value="'.$array['CFOPS'].'" >'.$array['CFOPS'].' - '.htmlentities(ucwords(strtolower($array['NATOPE']))).'</option>';
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>.: Estoque Web :.</title>
<link href="../../../css/estilo.css" rel="stylesheet" />
<link href="../../../css/menu.css" rel="stylesheet" />
<script src="../../../js/jquery.js" type="text/javascript" ></script>
<script src="../../../js/funcoes.js" type="text/javascript" ></script>
<script type="text/javascript" >
	
	var form_grupo = '<div class="janela" ><button class="fechar" onclick=" esconder(1); " >X</button><form name="form_grupo" id="form_grupo" ><h4 align="center" id="label_grupo" >Novo Grupo</h4><input type="hidden" name="codgru" id="codgru" /><fieldset><div><label>Descri&ccedil;&atilde;o do grupo </label><input type="text" class="grande" name="nomgru" maxlength="30" /></div><div><label>Departamento </label><select name="codgrc" id="codgrc" size="1"><option value=""></option><?php echo($opcoesgrc); ?></select></div><div><label>Medicamento</label><input type="radio" name="medicamento" value="S" checked="checked" /> Sim <input type="radio" name="medicamento" value="N" /> N&atilde;o </div><div><label>Med. Controlado</label><input type="radio" name="remcontr" value="S" checked="checked" /> Sim <input type="radio" name="remcontr" value="N" /> N&atilde;o </div><div><label>CFOP Dentro </label><select name="cfopd" id="cfopd" size="1"><option value=""></option><?php echo($opcoesnatope); ?></select></div><div><label>CFOP Fora </label><select name="cfopf" id="cfopf" size="1"><option value=""></option><?php echo($opcoesnatops); ?></select></div><div><label>CFOP Exterior </label><select name="cfope" id="cfope" size="1"><option value=""></option><?php echo($opcoesnatops); ?></select></div></fieldset></form><div><button id="gravar" >Gravar</button><button onclick=" esconder(1); " >Cancelar</button></div><div style="clear:both" ></div></div>';
	
	$(document).ready(function(){
	
		consulta();
		
	});
	
	$(document).keydown(function(e){
		return navegar(e.keyCode);
	});
	
	function consulta(completar){
		
		var dados = $('#pesquisa').serialize();
		
		var pular = 0;
		
		if(completar == 0){
			pular = 0;
		} else {
			//alert('1');
			if($('#res_pesquisa > table')){
				pular = parseInt($('#res_pesquisa > table > tbody > tr').length,10);
				//alert(pular);
			} else {
				pular = 0
			}
		}
		
		dados += '&pular='+pular;
		
		//alert(dados);
		
		var conteudo = $('#res_pesquisa').html();
		
		$.ajax({async: false, type: "POST",url: "funConsultagrupos.php",data: dados ,beforeSend: function() {
			$('#res_pesquisa').append('<img class="loading" src="../../../imagens/ajax-loader.gif" style="display:block; margin: auto;" />');
			//$(window).unbind('scroll');
		},success: function(txt) {
			
			if(pular == 0){
				if(txt == '0'){
					$('#res_pesquisa').html('Nenhum registro encontrado');
				} else {
					$('#res_pesquisa').html(txt);
					//continuarListagem(consulta);
					
					
					if(!conteudo){
						//alert(conteudo);
						
						//------------- testar permissoes ------------------//
						
						$('#detalhes').addClass('link');
						document.getElementById('detalhes').src = '../../../imagens/icone_detalhes.jpg';
						$('#detalhes').click(  function(){ detalhes(); });
						
						$('#alterar').addClass('link');
						document.getElementById('alterar').src = '../../../imagens/icone_alterar.jpg';
						$('#alterar').click(  function(){ alterar(); });
						
						$('#excluir').addClass('link');
						document.getElementById('excluir').src = '../../../imagens/icone_x.jpg';
						$('#excluir').click(  function(){ excluir(); });
						
					}
				}
			} else {
				if(txt == '0'){
					$('#mais').remove();
					if($('#naomais')){
						$('#naomais').remove();
					}
					$('#res_pesquisa').append('<span id="naomais">N&atilde;o h&aacute; mais registros</span>');
					//$(window).unbind('scroll');
				} else {
					$('#res_pesquisa > table > tbody').append(txt);
				}
				$('#res_pesquisa > .loading').remove();
			}
			
		},error: function(){
			alert('nao encontrado');
			$('#res_pesquisa > .loading').remove();
		}});
		
		return false;

	}
	
	function incluir(){
		
		$('#camada1').html(form_grupo);
		
		$('#camada1').fadeIn();
		//$('#camada1').css({position: 'fixed'});
		
		$('#camada1 input:text').keyup(function(){
			var valor = $(this).val().toUpperCase();
			$(this).val(valor);
		});
		
		$('#gravar').click(function(){gravar(1);});
		
	}
	
	function detalhes(){
		
		var string = $('#res_pesquisa > table > tbody > tr.selecionado > td > input ').val();
		//alert(string);
		var array = string.split('|');
		
		$('#camada1').html(form_grupo);
		//$('#camada1').css({position: 'fixed'});
		
		$('#camada1').fadeIn();
		
	}
	
	function alterar(){
		
		var string = $('#res_pesquisa > table > tbody > tr.selecionado > td > input ').val();
		//alert(string);
		var array = string.split('|');
		
		$('#camada1').html(form_grupo);
		//$('#camada1').css({position: 'fixed'});
		$('#label_grupo').html('Alterar grupo');
		
		document.form_grupo.codgru.value = array[0];
		document.form_grupo.nomgru.value = array[2];
		
		if(array[1] != ''){
			selecionarCombo('codgrc',array[1]);
		}
		
		if(array[4] != ''){
			selecionarRadio('form_grupo','medicamento',array[4]);
		}
		
		if(array[3] != ''){
			selecionarRadio('form_grupo','remcontr',array[3]);
		}
		
		if(array[10] != ''){
			selecionarCombo('cfopd',array[10]);
		}
		
		if(array[11] != ''){
			selecionarCombo('cfopf',array[11]);
		}
		
		if(array[12] != ''){
			selecionarCombo('cfope',array[12]);
		}
		
		$('#camada1').fadeIn();
		
		$('#camada1 input:text').keyup(function(){
			var valor = $(this).val().toUpperCase();
			$(this).val(valor);
		});
		
		$('#gravar').click(function(){gravar(2);});
		
	}
	
	function excluir(){
		
		if(confirm('Deseja realmente excluir o grupo selecionado?')){
			gravar(3);
		}
		
	}
	
	function gravar(movimento){
		var dados = $('#form_grupo').serialize();
		dados = dados+'&movimento='+movimento;
		
			$.ajax({type: "POST",url: "funGravargrupo.php",data: dados ,beforeSend: function() {
				
				$('#loading').fadeIn();
				
			},success: function(txt) {
			
				$('#loading').fadeOut();
			//alert(txt);
			
			var string = txt;
			var array = string.split('@');
			
				if(array[0] == 0){
					switch(parseInt(movimento,10)){
						case 1:
							$('#camada1').fadeOut();
							$('#camada1').html('');
							alert('grupo cadastrado com sucesso !');
							consulta(0);
						break;
						case 2:
							$('#camada1').fadeOut();
							$('#camada1').html('');
							alert('grupo alterado com sucesso !');
							consulta(0);
						break;
						default:
							alert('Outro movimento');
						break;
					}
				} else {
					alert('Erro ao inserir o grupo, tente novamente.');
				}
				
			//$('#resultado').html(txt);
			//$('#msg').html('');
				
			}});
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
<div id="conteudo" class="cadastro">
<div id="menu-lateral">
<img class="link" src="../../../imagens/icone_mais.jpg" alt="incluir" title="Incluir" onClick=" incluir(); " />
<img id="detalhes" src="../../../imagens/icone_detalhes_cinza.jpg" alt="detalhes" title="Detalhes" />
<img id="alterar" src="../../../imagens/icone_alterar_cinza.jpg" alt="alterar" title="Alterar" />
<img id="excluir" src="../../../imagens/icone_x_cinza.jpg" alt="excluir" title="Excluir" />
</div>
<h2 align="center">Cadastro de Grupos</h2>
<form name="pesquisa" id="pesquisa" method="post" action="index.php" onSubmit=" return consulta(0); " >
<fieldset>
<div><label>Buscar por</label> <select name="campo" id="campo" size="1" ><option value="NOMGRU">Descri&ccedil;&atilde;o</option><option value="CODGRU">C&oacute;digo</option></select></div>
<div><label>Pesquisa</label> <input type="text" name="pesquisa"  maxlength="10" /></div>
<div><label>Ordem</label> <select name="ordem" id="ordem" size="1" ><option value="CODGRU">C&oacute;digo</option><option value="NOMGRU">Descri&ccedil;&atilde;o</option></select></div>
<input type="submit" value="Buscar" />
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