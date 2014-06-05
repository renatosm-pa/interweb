<?php 
session_start();

if(isset($_SESSION['CODUSU']) and isset($_SESSION['NOMUSU']) and isset($_SESSION['SISTEMAS']) and isset($_SESSION['FILIAIS'])){

require_once('../banco/banco.php');

$query = new banco();
$query->conecta();

$sql = "select * from tabsis order by nomsis;";
$query->consulta($sql);
//$array = $query->resultado();

$sis_cod = array();
$sis_desc = array();

while($array = $query->resultado()){
	array_push($sis_cod,$array['CODSIS']);
	array_push($sis_desc,$array['NOMSIS']);
	$opcoessistemas .= '<option value="'.$array['CODSIS'].'" >'.htmlentities(ucwords(strtolower($array['NOMSIS']))).'</option>';
}

$sql = "select * from tabven order by nomven;";
$query->consulta($sql);
//$array = $query->resultado();

$vendedor_cod = array();
$vendedor_desc = array();

while($array = $query->resultado()){
	array_push($vendedor_cod,$array['CODVEN']);
	array_push($vendedor_desc,$array['NOMVEN']);
	$opcoesven .= '<option value="'.$array['CODVEN'].'" >'.htmlentities(ucwords(strtolower($array['NOMVEN']))).'</option>';
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>.: Usuarios :.</title>
<link href="../css/estilo.css" rel="stylesheet" />
<link href="../css/menu.css" rel="stylesheet" />
<script src="../js/jquery.js" type="text/javascript" ></script>
<script src="../js/funcoes.js" type="text/javascript" ></script>
<script src="../js/jquery.maskmoeda.js" type="text/javascript" ></script>
<script type="text/javascript" >
	
	var form_usuario = '<div class="janela" ><button class="fechar" onclick=" esconder(1); " >X</button><form name="form_usuario" id="form_usuario" onsubmit="return false" ><h4 align="center" id="label_usuario" >Novo usuario</h4><input type="hidden" name="codigo" id="codigo" /><fieldset><div id="divsistema" ><label>Sistema </label><select name="sistema" id="sistema" size="1" onchange="selSisUsu();" ><?php echo($opcoessistemas); ?></select></div><div><label>Nome</label><input type="text" class="grande" name="nome" maxlength="30" /></div><div><label>Classifica&ccedil;&atilde;o </label><select name="tipousu" id="tipousu" size="1" ><option value="U">Operador</option><option value="A">Administrador</option></select></div><div><label>Vendedor </label><select name="codven" id="codven" size="1" ><option value=""></option><?php echo($opcoesven); ?></select></div><div><label>Senha</label><input type="password" name="senha" /></div><div><label>Confirme a Senha</label><input type="password" name="confsenha" /></div><div><label>Visual. D&eacute;bitos</label><input type="radio" name="visualizardebitos" value="N" checked="checked" /> N&atilde;o <input type="radio" name="visualizardebitos" value="S" /> Sim</div><div><label>Desconto P&eacute; da Nota </label><div><label>% Desc. A Vista</label><input type="text" class="valor pequeno" name="percdescav" /></div><div><label>% Desc. Cart&atilde;o</label><input type="text" class="valor pequeno" name="percdesccc" /></div><div><label>% Desc. A Prazo</label><input type="text" class="valor pequeno" name="percdescap" /></div></div><div><label>Desconto Item da Nota </label><div><label>Varejo</label><div><label>% Desc. A Vista</label><input type="text" class="valor pequeno" name="percdesccoav" /></div><div><label>% Desc. Cart&atilde;o</label><input type="text" class="valor pequeno" name="percdesccocc" /></div><div><label>% Desc. A Prazo</label><input type="text" class="valor pequeno" name="percdesccoap" /></div></div><div><label>Atacado </label><div><label>% Desc. A Vista</label><input type="text" class="valor pequeno" name="percdescatav" /></div><div><label>% Desc. Cart&atilde;o</label><input type="text" class="valor pequeno" name="percdescatcc" /></div><div><label>% Desc. A Prazo</label><input type="text" class="valor pequeno" name="percdescatap" /></div></div></div><div><label>Desconto no Contas a Receber </label><div><label>% Desc. Juros</label><input type="text" class="valor pequeno" name="percdescjur" /></div><div><label>% Desc. Multa</label><input type="text" class="valor pequeno" name="percdescmul" /></div><div><label>% Desc. T&iacute;tulo</label><input type="text" class="valor pequeno" name="percdesctit" /></div></div></fieldset></form><div><button id="gravar" >Gravar</button><button onclick=" esconder(1); " >Cancelar</button></div><div style="clear:both" ></div></div>';
	
	var form_permissoes = '<div class="janela" ><button class="fechar" onclick=" esconder(1); " >X</button><form name="form_permissoes" id="form_permissoes" onsubmit="return false" ><h4 align="center" id="label_usuario" >Permiss&otilde;es de Usuario</h4><input type="hidden" name="codigo" id="codigo" /><input type="hidden" name="alterado" id="alterado" value="0" /><fieldset><div><label>Sistema </label><select name="codsis" id="codsis" size="1" onchange="selSisPerm();"><option value="">Processando...</option></select></div><div><img class="link" src="../imagens/icone_mais.jpg" alt="incluir sistema" title="Incluir Sistema" onClick=" incluirSistema(); " /></div><div class="camposenha" ><label>Senha </label><input type="password" name="senha" id="senha" placeholder="Usar senha do usuario" /></div><div class="camposenha" ><label>Confirme a Senha </label><input type="password" name="confsenha" id="confsenha" /></div><div id="lista_permissoes" class="lista"></div></fieldset></form><div><button id="gravar" >Gravar</button><button onclick=" esconder(1); " >Cancelar</button></div><div style="clear:both" ></div></div>';
	
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
		
		$.ajax({ type: "POST",url: "funConsultaUsuarios.php",data: dados ,beforeSend: function() {
			$('#res_pesquisa').append('<img class="loading" src="../imagens/ajax-loader.gif" style="display:block; margin: auto;" />');
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
						document.getElementById('detalhes').src = '../imagens/icone_detalhes.jpg';
						$('#detalhes').click(  function(){ detalhes(); });
						
						$('#alterar').addClass('link');
						document.getElementById('alterar').src = '../imagens/icone_alterar.jpg';
						$('#alterar').click(  function(){ alterar(); });
						
						$('#excluir').addClass('link');
						document.getElementById('excluir').src = '../imagens/icone_x.jpg';
						$('#excluir').click(  function(){ excluir(); });
						
						$('#permissoes').addClass('link');
						document.getElementById('permissoes').src = '../imagens/icone_permissoes.png';
						$('#permissoes').click(  function(){ permissoes(); });
						
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
			
			/*
			if(txt == '0'){
				$('#res_pesquisa').html('Nenhum registro encontrado');
			} else {
				if(pular == 0){
					
					$('#res_pesquisa').html(txt);
					//continuarListagem(consulta);
					
					
					if(!conteudo){
						//alert(conteudo);
						
						//------------- testar permissoes ------------------//
						
						$('#detalhes').addClass('link');
						document.getElementById('detalhes').src = '../imagens/icone_detalhes.jpg';
						$('#detalhes').click(  function(){ detalhes(); });
						
						$('#alterar').addClass('link');
						document.getElementById('alterar').src = '../imagens/icone_alterar.jpg';
						$('#alterar').click(  function(){ alterar(); });
						
						$('#excluir').addClass('link');
						document.getElementById('excluir').src = '../imagens/icone_x.jpg';
						$('#excluir').click(  function(){ excluir(); });
						
						$('#permissoes').addClass('link');
						document.getElementById('permissoes').src = '../imagens/icone_permissoes.png';
						$('#permissoes').click(  function(){ permissoes(); });
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
			} */
			
		},error: function(){
			alert('nao encontrado');
			$('#res_pesquisa > .loading').remove();
		}});
		
		return false;

	}
	
	function incluir(){
		
		$('#camada1').html(form_usuario);
		$('#camada1').fadeIn();
		$('#divsistema').show();
		
		$('#camada1 input:text').keyup(function(){
			var valor = $(this).val().toUpperCase();
			$(this).val(valor);
		});
		
		$('#camada1 .valor').priceFormat({
			prefix: '',
			centsSeparator: ',',
			thousandsSeparator: '.',
			limit: 4,
			centsLimit: 2
		});
		
		$('#gravar').click(function(){gravar(1);});
		
	}
	
	function detalhes(){
		
		var string = $('#res_pesquisa > table > tbody > tr.selecionado > td > input ').val();
		//alert(string);
		var array = string.split('|');
		
		$('#camada1').html(form_usuario);
		
		$('#camada1').fadeIn();
		
	}
	
	function alterar(){
		
		var string = $('#res_pesquisa > table > tbody > tr.selecionado > td > input ').val();
		//alert(string);
		var array = string.split('|');
		
		$('#camada1').html(form_usuario);
		$('#label_usuario').html('Alterar usuario');
		
		document.form_usuario.codigo.value = array[0];
		document.form_usuario.nome.value = array[1];
		document.form_usuario.senha.value = array[2];
		document.form_usuario.confsenha.value = array[2];
		
		selecionarCombo('tipousu',array[3]);
		
		if(array[4] == 6){
			
			if(array[5] != ''){
				selecionarCombo('codven',array[5]);
			}
			
			document.form_usuario.percdescav.value = float2moeda(array[16]);
			document.form_usuario.percdesccc.value = float2moeda(array[17]);
			document.form_usuario.percdescap.value = float2moeda(array[18]);
			
			document.form_usuario.percdesccoav.value = float2moeda(array[19]);
			document.form_usuario.percdesccocc.value = float2moeda(array[21]);
			document.form_usuario.percdesccoap.value = float2moeda(array[23]);
			
			document.form_usuario.percdescatav.value = float2moeda(array[20]);
			document.form_usuario.percdescatcc.value = float2moeda(array[22]);
			document.form_usuario.percdescatap.value = float2moeda(array[24]);
			
			document.form_usuario.percdescjur.value = float2moeda(array[25]);
			document.form_usuario.percdescmul.value = float2moeda(array[26]);
			document.form_usuario.percdesctit.value = float2moeda(array[27]);
			
		}
		
		$('#camada1').fadeIn();
		
		$('#gravar').click(function(){gravar(2);});
		
		$('#camada1 input:text').keyup(function(){
			var valor = $(this).val().toUpperCase();
			$(this).val(valor);
		});
		
		$('#camada1 .valor').priceFormat({
			prefix: '',
			centsSeparator: ',',
			thousandsSeparator: '.',
			limit: 4,
			centsLimit: 2
		});
		
	}
	
	function excluir(){
		
		if(confirm('Deseja realmente excluir o usuario selecionado?')){
			gravar(3);
		}
		
	}
	
	function permissoes(){
		
		var string = $('#res_pesquisa > table > tbody > tr.selecionado > td > input ').val();
		//alert(string);
		var array = string.split('|');
		
		$('#camada1').html(form_permissoes);
		
		document.form_permissoes.codigo.value = array[0];
		
		$('#camada1').fadeIn();
		
		$.ajax({type: "POST",url: "funOpcoesSistemas.php",data: 'codusu='+array[0] ,beforeSend: function() {
			//alert('codusu='+array[0]+'&codsis='+document.form_permissoes.codsis.value);
			$('#loading').fadeIn();
		},success: function(txt) {
			var string = txt;
			var array = string.split('|');
			
			if(array[0] != ''){
				$('#codsis').html(array[0]);
				if(document.form_permissoes.codsis.value != ''){
					$('.camposenha').show();
					document.form_permissoes.senha.value = array[2];
					document.form_permissoes.confsenha.value = array[2];
				}
			}
			
			if(array[1] != ''){
				$('#lista_permissoes').html(array[1]);
			}
			
			$('#loading').fadeOut();
		}});
	}
	
	function selSisPerm(){
		
		if(document.form_permissoes.codigo.value != '' && document.form_permissoes.codsis.value != ''){
		
			$.ajax({type: "POST",url: "funPermissoesSistemas.php",data: 'codusu='+document.form_permissoes.codigo.value+'&codsis='+document.form_permissoes.codsis.value ,beforeSend: function() {
				//alert('codusu='+array[0]+'&codsis='+document.form_permissoes.codsis.value);
				$('#loading').fadeIn();
			},success: function(txt) {
				var string = txt;
				var array = string.split('|');
				
				document.form_permissoes.senha.value = array[0];
				document.form_permissoes.confsenha.value = array[0];
				
				if(array[1] != ''){
					$('#lista_permissoes').html(array[1]);
				}
				
				$('#loading').fadeOut();
			}});
		}
	}
	
	function gravar(movimento){
		var dados = $('#form_usuario').serialize();
		dados = dados+'&movimento='+movimento;
		
			$.ajax({type: "POST",url: "funGravarUsuario.php",data: dados ,beforeSend: function() {
				
				$('#loading').fadeIn();
				
			},success: function(txt) {
			
				$('#loading').fadeOut();
			//alert(txt);
			
			var string = txt;
			var array = string.split('@');
			
				switch(parseInt(array[0],10)){
				case 0:
					switch(parseInt(movimento,10)){
						case 1:
							document.pesquisa.pesquisa.value = document.form_usuario.nome.value.substr(0,10);
							selecionarCombo('campo','NOME');
							$('#camada1').fadeOut();
							$('#camada1').html('');
							alert('usuario cadastrado com sucesso !');
							consulta(0);
						break;
						case 2:
							//document.pesquisa.pesquisa.value = document.form_usuario.nome.value.substr(0,10);
							//selecionarCombo('campo','NOME');
							$('#camada1').fadeOut();
							$('#camada1').html('');
							alert('usuario alterado com sucesso !');
							consulta(0);
						break;
						default:
							alert('Outro movimento');
						break;
					}
				break;
				case 1:
					alert('Erro ao gravar o usuario, tente novamente.');
				break;
				case 2:
					alert('Ja existe um usuario com esse nome para esse sistema.');
				break;
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
<?php include('../cabecalho.php'); ?>
</div>
<div id="camada1"></div>
<div id="camada2"></div>
<div id="loading"></div>
<div id="conteudo" class="cadastro">
<div id="menu-lateral">
<img class="link" src="../imagens/icone_mais.jpg" alt="incluir" title="Incluir" onClick=" incluir(); " />
<img id="detalhes" src="../imagens/icone_detalhes_cinza.jpg" alt="detalhes" title="Detalhes" />
<img id="alterar" src="../imagens/icone_alterar_cinza.jpg" alt="alterar" title="Alterar" />
<img id="excluir" src="../imagens/icone_x_cinza.jpg" alt="excluir" title="Excluir" />
<img id="permissoes" src="../imagens/icone_permissoes_cinza.jpg" alt="permissoes" title="Permiss&otilde;es" />
</div>
<h2 align="center">Cadastro de Usuarios</h2>
<form name="pesquisa" id="pesquisa" method="post" action="index.php" onSubmit=" return consulta(0); " >
<fieldset>
<div><label>Buscar por</label> <select name="campo" id="campo" size="1" ><option value="NOME">Descri&ccedil;&atilde;o</option><option value="CODIGO">C&oacute;digo</option></select></div>
<div><label>Pesquisa</label> <input type="text" name="pesquisa"  maxlength="10" /></div>
<div><label>Ordem</label> <select name="ordem" id="ordem" size="1" ><option value="CODIGO">C&oacute;digo</option><option value="NOME">Descri&ccedil;&atilde;o</option></select></div>
<input type="submit" value="Buscar" />
<div class="clear"></div>
</fieldset>
</form>
<form id="res_pesquisa" class="lista"></form>
</div>
<div id="rodape">
<?php include('../rodape.php'); ?>
</div>
</body>
</html>
<?php } else { 

header('location: /interweb');

 } ?>