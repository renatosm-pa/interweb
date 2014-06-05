<?php 
session_start();

if(isset($_SESSION['CODUSU']) and isset($_SESSION['NOMUSU']) and isset($_SESSION['SISTEMAS']) and isset($_SESSION['FILIAIS'])){

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
	
	var form_departamento = '<div class="janela" ><button class="fechar" onclick=" esconder(1); " >X</button><form name="form_departamento" id="form_departamento" onsubmit="return false" ><h4 align="center" id="label_departamento" >Novo Departamento</h4><input type="hidden" name="codgrc" id="codgrc" /><fieldset><div><label>Descri&ccedil;&atilde;o do Departamento </label><input type="text" class="grande" name="nomgrc" maxlength="30" /></div></fieldset></form><div><button id="gravar" >Gravar</button><button onclick=" esconder(1); " >Cancelar</button></div><div style="clear:both" ></div></div>';
	
	$(document).ready(function(){
	
		consulta();
		
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
		
		$.ajax({ type: "POST",url: "funConsultaDepartamentos.php",data: dados ,beforeSend: function() {
			$('#res_pesquisa').append('<img class="loading" src="../../../imagens/ajax-loader.gif" style="display:block; margin: auto;" />');
			//$(window).unbind('scroll');
		},success: function(txt) {
			
			if(txt == '0'){
				alert('Nenhum registro encontrado');
				$('#res_pesquisa > .loading').remove();
				$('#mais').remove();
			} else {
				if(pular == 0){
					
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
					
				} else {
					if(txt == '0'){
						$('#mais').remove();
						$('#res_pesquisa').append('N&atilde;o h&aacute; mais registros');
						//$(window).unbind('scroll');
					} else {
						$('#res_pesquisa > table > tbody').append(txt);
					}
					$('#res_pesquisa > .loading').remove();
				}
			}
		},error: function(){
			alert('nao encontrado');
			$('#res_pesquisa > .loading').remove();
		}});
		
		return false;

	}
	
	function incluir(){
		
		$('#camada1').html(form_departamento);
		$('#camada1').fadeIn();
		
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
		
		$('#camada1').html(form_departamento);
		
		$('#camada1').fadeIn();
		
	}
	
	function alterar(){
		
		var string = $('#res_pesquisa > table > tbody > tr.selecionado > td > input ').val();
		//alert(string);
		var array = string.split('|');
		
		$('#camada1').html(form_departamento);
		$('#label_departamento').html('Alterar departamento');
		
		document.form_departamento.codgrc.value = array[0];
		document.form_departamento.nomgrc.value = array[1];
		
		$('#camada1').fadeIn();
		
		$('#gravar').click(function(){gravar(2);});
		
		$('#camada1 input:text').keyup(function(){
			var valor = $(this).val().toUpperCase();
			$(this).val(valor);
		});
		
	}
	
	function excluir(){
		
		if(confirm('Deseja realmente excluir o departamento selecionado?')){
			gravar(3);
		}
		
	}
	
	function gravar(movimento){
		var dados = $('#form_departamento').serialize();
		dados = dados+'&movimento='+movimento;
		
			$.ajax({type: "POST",url: "funGravarDepartamento.php",data: dados ,beforeSend: function() {
				
				$('#loading').fadeIn();
				
			},success: function(txt) {
			
				$('#loading').fadeOut();
			//alert(txt);
			
			var string = txt;
			var array = string.split('@');
			
				if(array[0] == 0){
					switch(parseInt(movimento,10)){
						case 1:
							document.pesquisa.pesquisa.value = document.form_departamento.nomgrc.value.substr(0,10);
							selecionarCombo('campo','NOMGRC');
							$('#camada1').fadeOut();
							$('#camada1').html('');
							alert('Departamento cadastrado com sucesso !');
							consulta(0);
						break;
						case 2:
							//document.pesquisa.pesquisa.value = document.form_departamento.nomgrc.value.substr(0,10);
							//selecionarCombo('campo','NOMGRC');
							$('#camada1').fadeOut();
							$('#camada1').html('');
							alert('Departamento alterado com sucesso !');
							consulta(0);
						break;
						default:
							alert('Outro movimento');
						break;
					}
				} else {
					alert('Erro ao inserir o departamento, tente novamente.');
				}
				
			//$('#resultado').html(txt);
			//$('#msg').html('');
				
			}});
			
			//consulta(1);
		
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
<h2 align="center">Cadastro de Departamentos</h2>
<form name="pesquisa" id="pesquisa" method="post" action="index.php" onSubmit=" return consulta(0); " >
<fieldset>
<div><label>Buscar por</label> <select name="campo" id="campo" size="1" ><option value="NOMGRC">Descri&ccedil;&atilde;o</option><option value="CODGRC">C&oacute;digo</option></select></div>
<div><label>Pesquisa</label> <input type="text" name="pesquisa"  maxlength="10" /></div>
<div><label>Ordem</label> <select name="ordem" id="ordem" size="1" ><option value="CODGRC">C&oacute;digo</option><option value="NOMGRC">Descri&ccedil;&atilde;o</option></select></div>
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