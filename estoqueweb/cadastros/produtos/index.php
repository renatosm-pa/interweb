<?php 
session_start();

if(isset($_SESSION['CODUSU']) and isset($_SESSION['NOMUSU']) and isset($_SESSION['SISTEMAS']) and isset($_SESSION['FILIAIS'])){

require_once('../../../banco/banco.php');

$query = new banco();
$query->conecta();

$sql = "select * from tabgru order by nomgru;";
$query->consulta($sql);
//$array = $query->resultado();

$grupo_cod = array();
$grupo_desc = array();

while($array = $query->resultado()){
	array_push($grupo_cod,$array['CODGRU']);
	array_push($grupo_desc,$array['NOMGRU']);
	$opcoesgrupo .= '<option value="'.$array['CODGRU'].'" >'.htmlentities(ucwords(strtolower($array['NOMGRU']))).'</option>';
}

$sql = "select * from tabfab where nomfab <> '' order by nomfab;";
$query->consulta($sql);
//$array = $query->resultado();

$fab_cod = array();
$fab_desc = array();

while($array = $query->resultado()){
	array_push($fab_cod,$array['CODFAB']);
	array_push($fab_desc,$array['NOMFAB']);
	$opcoesfab .= '<option value="'.$array['CODFAB'].'" >'.str_replace('&amp;','&',htmlentities(ucwords(strtolower(asi($array['NOMFAB']))))).'</option>';
}

$sql = "select * from tabcolecao order by nomcolecao;";
$query->consulta($sql);
//$array = $query->resultado();

$colecaopo_cod = array();
$colecaopo_desc = array();

while($array = $query->resultado()){
	array_push($colecao_cod,$array['CODCOLECAO']);
	array_push($colecao_desc,$array['NOMCOLECAO']);
	$opcoescolecao .= '<option value="'.$array['CODCOLECAO'].'" >'.htmlentities(ucwords(strtolower($array['NOMCOLECAO']))).'</option>';
}

$sql = "select * from tabaluser order by nomaluser;";
$query->consulta($sql);
//$array = $query->resultado();

$aluser_cod = array();
$aluser_desc = array();

while($array = $query->resultado()){
	array_push($aluser_cod,$array['CODALUSER']);
	array_push($aluser_desc,$array['NOMALUSER']);
	$opcoesaluser .= '<option value="'.$array['CODALUSER'].'" >'.htmlentities(ucwords(strtolower($array['NOMALUSER']))).'</option>';
}

$sql = "select * from tabaluser order by nomaluser;";
$query->consulta($sql);
//$array = $query->resultado();

$aluser_cod = array();
$aluser_desc = array();

while($array = $query->resultado()){
	array_push($aluser_cod,$array['CODALUSER']);
	array_push($aluser_desc,$array['NOMALUSER']);
	$opcoesaluser .= '<option value="'.$array['CODALUSER'].'" >'.htmlentities(ucwords(strtolower($array['NOMALUSER']))).'</option>';
}

include('servicos.php');

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>.: Estoque Web :.</title>
<link href="../../../css/estilo.css" rel="stylesheet" />
<link href="../../../css/menu.css" rel="stylesheet" />
<link href="../../../js/jquery-ui-1.10.3/themes/base/jquery-ui-1.10.4.custom.css" rel="stylesheet" type="text/css" />
<script src="../../../js/jquery.js" type="text/javascript" ></script>
<script src="../../../js/funcoes.js" type="text/javascript" ></script>
<script src="../../../js/jquery-ui-1.10.3/ui/jquery-ui.js" type="text/javascript" ></script>
<script src="../../../js/jquery-ui-1.10.3/ui/jquery.ui.core.js" type="text/javascript" ></script>
<script src="../../../js/jquery-ui-1.10.3/ui/jquery.ui.widget.js" type="text/javascript" ></script>
<script src="../../../js/jquery-ui-1.10.3/ui/jquery.ui.tabs.js" type="text/javascript" ></script>
<script src="../../../js/jquery.maskedinput.js" type="text/javascript" ></script>
<script src="../../../js/jquery.maskmoeda.js" type="text/javascript" ></script>
<script type="text/javascript" >
	
	var servicos = [<?php echo($opcoesservicos); ?>];
	var array_servicos = ('<?php echo($array_servicos); ?>').split('|');
	
	var tab1 = '<fieldset><div><label>Descri&ccedil;&atilde;o do Produto </label><input type="text" class="grande" name="descpro" maxlength="30" /></div><div><label>Emb. </label><input type="text" class="pequeno" name="unemb" maxlength="2" /></div><div><label>Com </label><input type="text" class="pequeno" name="qtdemb" maxlength="10" /></div><div><label>Unidade </label><input type="text" class="pequeno" name="unidade" maxlength="2" /></div><div><label>C&oacute;digo de Barras </label><input type="text" name="codbarun" maxlength="20" /></div><div><label>Espedifica&ccedil;&otilde;es</label><textarea name="detalhe"></textarea></div><div><label>C&oacute;digo da Embalagem </label><input type="text" name="codbarcx" maxlength="20" /></div><div><label>Grupo </label><select name="grupro" id="grupro" size="1"><option value=""></option><?php echo($opcoesgrupo); ?></select></div><div><label>Fabricante </label><select name="fabpro" id="fabpro" size="1"><option value=""></option><?php echo($opcoesfab); ?></select></div><div><label>Registro MS (Medicamento)</label><input type="text" name="regmsmed" maxlength="13" /></div><div><label>Classe Terap&ecirc;utica </label><select name="clasterap" id="clasterap" size="1"><option value=""></option><option value="C">Controlado</option><option value="A">Antimicrobiano</option></select></div><div><label>Uso Prolongado </label><input type="radio" name="usoprolong" value="S" /> Sim <input type="radio" name="usoprolong" value="N" checked="checked" /> N&atilde;o </div><div><label>Unidade Med. </label><select name="unidmed" id="unidmed" size="1"><option value=""></option><option value="F"> Frasco </option><option value="C"> Caixa </option></select></div><div><label>Cod. Insumo </label><input type="text" class="pequeno" name="coddcbins" maxlength="6" /></div></fieldset>';
	
	var tab2 = '<fieldset><div><label>Cod. Vasil. </label><input type="text" name="codvas" id="codvas" class="pequeno" title="Digite o codigo e saia do campo para pesquisar" onblur=" selVasilhame(); " /></div><div><label>Vasilhame </label><input type="text" name="nomvas" id="nomvas" size="1" title="Digite parte do nome para pesquisar" /></div><div><label>Vl. Comiss&atilde;o </label><input type="text" name="vlcomi" class="valor" maxlength="10" /></div><div><label>Cole&ccedil;&atilde;o/Disciplina </label><select name="codcolecao" id="codcolecao" size="1"><option value=""></option><?php echo($opcoescolecao); ?></select></div><div><label>S&eacute;rie Aluno </label><select name="codaluser" id="codaluser" size="1"><option value=""></option><?php echo($opcoesaluser); ?></select></div><div><label>Peso Bruto Kg </label><input type="text" name="pesobruto" class="valor" maxlength="10" /></div><div><label>Peso L&iacute;quido Kg </label><input type="text" name="pesoliquido" class="valor" maxlength="10" /></div><div><label>Dias Vencimento </label><input type="text" class="pequeno" name="diasvenc" maxlength="2" /></div><div><label>Casas Decimais</label><input type="text" class="pequeno" name="casadec" maxlength="2" /></div><div><label>Sele&ccedil;&atilde;o de Cor </label><select name="corconsul" id="corconsul" size="1"><option value="">Normal</option></select></div></fieldset>';
	
	var tab3 = '<fieldset><div><label>Situa&ccedil;&atilde;o </label><input type="radio" name="stprod" value="A" checked="checked" /> Ativo <input type="radio" name="stprod" value="I" /> Inativo </div><div><label>Qualifica&ccedil;&atilde;o </label><input type="radio" name="qualprod" value="R" checked="checked" /> Revenda <input type="radio" name="qualprod" value="A" /> Acabado <input type="radio" name="qualprod" value="M" /> Mat&eacute;ria Prima </div><div><label>Controla Estoque </label><input type="radio" name="contrquant" value="S" checked="checked" /> Sim <input type="radio" name="contrquant" value="N" /> N&atilde;o </div><div><label>Contr. Sub-Estoque </label><input type="radio" name="contrrefer" value="S" /> Sim <input type="radio" name="contrrefer" value="N" checked="checked" /> N&atilde;o </div><div><label>Produto Composto </label><input type="radio" name="contrcomp" value="S" /> Sim <input type="radio" name="contrcomp" value="N" checked="checked" /> N&atilde;o </div><div><label>Meio a Meio </label><input type="radio" name="meioameio" value="S" /> Sim <input type="radio" name="meioameio" value="N" checked="checked" /> N&atilde;o </div><div><label>Fracionado </label><input type="radio" name="massacompr" value="S" /> Sim <input type="radio" name="massacompr" value="N" checked="checked" /> N&atilde;o </div><div><label>Prod. Balan&ccedil;a </label><input type="radio" name="balanca" value="S" /> Sim <input type="radio" name="balanca" value="N" checked="checked" /> N&atilde;o </div><div><label>Cesta B&aacute;sica </label><input type="radio" name="cestabas" value="S" /> Sim <input type="radio" name="cestabas" value="N" checked="checked" /> N&atilde;o </div><div><label>Desonera&ccedil;&atilde;o Folha </label><input type="radio" name="desonfolha" value="S" /> Sim <input type="radio" name="desonfolha" value="N" checked="checked" /> N&atilde;o </div><div><label>Troca por Pontos </label><input type="radio" name="contrponto" value="S" /> Sim <input type="radio" name="contrponto" value="N" checked="checked" /> N&atilde;o </div><div><label>Pontos </label><input type="text" name="baixaponto" maxlength="10" /></div><div><label>Aceitar Desconto </label><input type="radio" name="libdesconto" value="S" /> Sim <input type="radio" name="libdesconto" value="N" checked="checked" /> N&atilde;o </div><div><label>Liberar Quantidade </label><input type="radio" name="libquant" value="S" /> Sim <input type="radio" name="libquant" value="N" checked="checked" /> N&atilde;o </div><div><label>Tipo de Sub-Estoque </label><input type="radio" name="tpsubest" value="G" checked="checked" /> Grade <input type="radio" name="tpsubest" value="S" /> Serial <input type="radio" name="tpsubest" value="L" /> Lote </div><div><label>Refer&ecirc;ncia </label><input type="text" name="codrefer" /></div><div><label>Modelos </label><input type="text" name="modelo" /></div><div><label>Tamanhos </label><input type="text" name="tamanho" /></div><div><label>Cores </label><input type="text" name="cores" /></div><div class="clear"></div><div><label>Perc. Comiss&atilde;o Varejo Vendedor </label><div><label>A Vista </label><input type="text" name="vlcomiavva" class="pequeno" /></div><div><label>C. Cr&eacute;dito </label><input type="text" name="vlcomiccva" class="pequeno" /></div><div><label>A Prazo </label><input type="text" name="vlcomiapva" class="pequeno" /></div></div><div><label>Perc. Comiss&atilde;o Atacado Vendedor </label><div><label>A Vista </label><input type="text" name="vlcomiavat" class="pequeno" /></div><div><label>C. Cr&eacute;dito </label><input type="text" name="vlcomiccat" class="pequeno" /></div><div><label>A Prazo </label><input type="text" name="vlcomiapat" class="pequeno" /></div></div></fieldset>';
	
	var tab4 = '<fieldset><div><label>&Iacute;ndice </label><select name="indice" id="indice" size="1"><option value=""></option><option value="PT">Produto Tarifado</option><option value="ST">Servi&ccedil;o Tarifado</option><option value="II">Isento</option><option value="NN">N&atilde;o Incidente</option><option value="SS">Subs. Tribut&aacute;ria</option></select></div><div><label>ICMS / ISS </label><input type="text" name="icms" /></div><div><label>ICMS Antecipado </label><input type="radio" name="substrib" value="S" /> Sim <input type="radio" name="substrib" value="N" checked="checked" /> N&atilde;o </div><div><label>Perc. Agregado (Padr&atilde;o) </label><input type="text" name="perclucro" /></div><div><label>% IRPJ</label><input type="text" class="pequeno" name="fatorirpj" maxlength="2" /></div><div><label>% CSLL</label><input type="text" class="pequeno" name="fatorcsll" maxlength="2" /></div><div><label>IPI </label><input type="radio" name="ipi" value="T" /> Tarifado <input type="radio" name="ipi" value="I" /> Isento <input type="radio" name="ipi" value="O" checked="checked" /> Outros </div><div><label>Perc. IPI</label><input type="text" class="pequeno" name="percipi" maxlength="2" /></div><div><label>Tributa&ccedil;&atilde;o Monof&aacute;sica PIS/COFINS</label><input type="radio" name="tribmono" value="S" /> Sim <input type="radio" name="tribmono" value="N" checked="checked" /> N&atilde;o </div><div><label>% PIS</label><input type="text" class="pequeno" name="fatorpis" maxlength="2" /></div><div><label>% CONFINS</label><input type="text" class="pequeno" name="fatorcofins" maxlength="2" /></div><div><label>CST</label><input type="text" class="pequeno" name="cst" maxlength="2" /></div><div><label>NCM</label><select name="clasfiscal" id="clasfiscal" size="1"><option value=""></option></select></div><div><label>Origem</label><input type="radio" name="origprod" value="N" checked="checked" /> Nacional <input type="radio" name="origprod" value="I" /> Importado </div><div><label>C&oacute;d. G&ecirc;nero</label><input type="text" class="pequeno" name="codgen" maxlength="2" /></div><div><label>C&oacute;d. EX</label><input type="text" class="pequeno" name="exipi" maxlength="2" /></div><div><label>Cod Servi&ccedil;o</label><input type="text" class="pequeno" name="codlst" id="codlst" onblur="selServico();" title="Digite o codigo e saia do campo para pesquisar" /></div><div><label>Servi&ccedil;o</label><input type="text" name="nomlst" id="nomlst" title="Digite parte do nome para pesquisar" /></div><div><label>Tipo do Item</label><select name="tipoitem" id="tipoitem" size="1"><option value=""></option><option value="00"> 00 - Mercadoria para Revenda </option><option value="01"> 01 - Mat&eacute;ria Prima </option><option value="02"> 02 - Embalagem </option><option value="03"> 03 - Produto em Processo </option><option value="04"> 04 - Produto Acabado </option><option value="05"> 05 - Subproduto </option><option value="06"> 06 - Produto Intermedi&aacute;rio </option><option value="07"> 07 - Material de Uso e Consumo </option><option value="08"> 08 - Ativo Imobilizado </option><option value="09"> 09 - Servi&ccedil;os </option><option value="10"> 10 - Outros Insumos </option><option value="99"> 99 - Outras </option></select></div><div><label>C&oacute;digo ANP</label><input type="text" class="pequeno" name="codanp" /></div><div><label>CODIF</label><input type="text" name="codif" /></div></fieldset>';
	
	var tab5 = '<fieldset><div><label>AC</label><input type="text" class="pequeno" name="acagr" maxlength="2" /></div><div><label>AL</label><input type="text" class="pequeno" name="alagr" maxlength="2" /></div><div><label>AM</label><input type="text" class="pequeno" name="amagr" maxlength="2" /></div><div><label>AP</label><input type="text" class="pequeno" name="apagr" maxlength="2" /></div><div><label>BA</label><input type="text" class="pequeno" name="baagr" maxlength="2" /></div><div><label>CE</label><input type="text" class="pequeno" name="ceagr" maxlength="2" /></div><div><label>DF</label><input type="text" class="pequeno" name="dfagr" maxlength="2" /></div><div><label>ES</label><input type="text" class="pequeno" name="esagr" maxlength="2" /></div><div><label>GO</label><input type="text" class="pequeno" name="goagr" maxlength="2" /></div><div><label>MA</label><input type="text" class="pequeno" name="maagr" maxlength="2" /></div><div><label>MT</label><input type="text" class="pequeno" name="mtagr" maxlength="2" /></div><div><label>MS</label><input type="text" class="pequeno" name="msagr" maxlength="2" /></div><div><label>MG</label><input type="text" class="pequeno" name="mgagr" maxlength="2" /></div><div><label>PA</label><input type="text" class="pequeno" name="paagr" maxlength="2" /></div><div><label>PB</label><input type="text" class="pequeno" name="pbagr" maxlength="2" /></div><div><label>PR</label><input type="text" class="pequeno" name="pragr" maxlength="2" /></div><div><label>PE</label><input type="text" class="pequeno" name="peagr" maxlength="2" /></div><div><label>PI</label><input type="text" class="pequeno" name="piagr" maxlength="2" /></div><div><label>RN</label><input type="text" class="pequeno" name="rnagr" maxlength="2" /></div><div><label>RS</label><input type="text" class="pequeno" name="rsagr" maxlength="2" /></div><div><label>RJ</label><input type="text" class="pequeno" name="rjagr" maxlength="2" /></div><div><label>RO</label><input type="text" class="pequeno" name="roagr" maxlength="2" /></div><div><label>RR</label><input type="text" class="pequeno" name="rragr" maxlength="2" /></div><div><label>SC</label><input type="text" class="pequeno" name="scagr" maxlength="2" /></div><div><label>SP</label><input type="text" class="pequeno" name="spagr" maxlength="2" /></div><div><label>SE</label><input type="text" class="pequeno" name="seagr" maxlength="2" /></div><div><label>TO</label><input type="text" class="pequeno" name="toagr" maxlength="2" /></div></fieldset>';
	
	var form_produto = '<div class="janela" ><button class="fechar" onclick=" esconder(1); " >X</button><form name="form_produto" id="form_produto" ><h4 align="center" id="label_produto" >Novo Produto</h4><input type="hidden" name="codpro" id="codpro" /><div id="tabs" ><ul><li><a href="#tabs-1" >Especifica&ccedil;&otilde;es</a></li><li><a href="#tabs-2" >Espec. Cont...</a></li><li><a href="#tabs-3" >Gerenciamento</a></li><li><a href="#tabs-4" >Tributa&ccedil;&atilde;o</a></li><li><a href="#tabs-5" >Perc. Agr. por Estado</a></li></ul><div id="tabs-1" >'+tab1+'</div><div id="tabs-2" >'+tab2+'</div><div id="tabs-3" >'+tab3+'</div><div id="tabs-4" >'+tab4+'</div><div id="tabs-5" >'+tab5+'</div></div></form><div><button id="gravar" >Gravar</button><button onclick=" esconder(1); " >Cancelar</button></div><div style="clear:both" ></div></div>';
	
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
		
		$.ajax({async: false, type: "POST",url: "funConsultaProdutos.php",data: dados ,beforeSend: function() {
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
		
		$('#camada1').html(form_produto);
		
		$("#tabs").tabs();
		
		$('#camada1').fadeIn();
		//$('#camada1').css({position: 'fixed'});
		
		$('#camada1 input:text').keyup(function(){
			var valor = $(this).val().toUpperCase();
			$(this).val(valor);
		});
		
		$('#gravar').click(function(){gravar(1);});
		
		$("#nomvas").autocomplete({
			source: "funSugestaoVasilhame.php",
			minLength: 4,
			select: function( event, ui ) {
				document.form_produto.codvas.value = ui.item.id;
				//$('#codcli').val(ui.item.id);
				//selecionarCombo('codven',ui.item.codven);
				//alert(ui.item.id);
			}
		});
		
		$("#nomlst").autocomplete({
			source: servicos,
			minLength: 2,
			select: function( event, ui ) {
				var index = parseInt(ui.item.label.indexOf('-'),10)-1;
				//alert(index);
				document.form_produto.codlst.value = ui.item.label.substr(0,index);
				document.form_produto.nomlst.value = ui.item.label.substr(0,100);
				//$('#codcli').val(ui.item.id);
				//selecionarCombo('codven',ui.item.codven);
				//alert(ui.item.id);
			}
		});
		
		$('#camada1 .valor').priceFormat({
			prefix: '',
			centsSeparator: ',',
			thousandsSeparator: '.',
			limit: 17,
			centsLimit: 2
		});
		
		$('#camada1').tooltip();
		$('#camada1').tooltip({
		  position: {
			my: "center bottom-20",
			at: "center top",
			using: function( position, feedback ) {
			  $( this ).css( position );
			  $( "<div>" )
				.addClass( "arrow" )
				.addClass( feedback.vertical )
				.addClass( feedback.horizontal )
				.appendTo( this );
			}
		  }
		});
		$('#camada1').tooltip().off("mouseover mouseout");
		
	}
	
	function detalhes(){
		
		var string = $('#res_pesquisa > table > tbody > tr.selecionado > td > input ').val();
		//alert(string);
		var array = string.split('|');
		
		$('#camada1').html(form_produto);
		//$('#camada1').css({position: 'fixed'});
		
		$('#camada1').fadeIn();
		
	}
	
	function alterar(){
		
		var string = $('#res_pesquisa > table > tbody > tr.selecionado > td > input ').val();
		//alert(string);
		var array = string.split('|');
		
		$('#camada1').html(form_produto);
		$('#label_produto').html('Alterar Produto');
		
		document.form_produto.codpro.value = array[0];
		
		//--------- tab 1 ----------
		
		document.form_produto.descpro.value = array[1];
		document.form_produto.detalhe.value = array[2];
		document.form_produto.codbarun.value = array[3];
		document.form_produto.codbarcx.value = array[4];
		document.form_produto.codrefer.value = array[5];
		document.form_produto.unemb.value = array[6];
		document.form_produto.qtdemb.value = array[7];
		document.form_produto.unidade.value = array[8];
		
		if(array[11] != ''){
			selecionarCombo('grupro',array[11]);
		}
		
		if(array[12] != ''){
			selecionarCombo('fabpro',array[12]);
		}
		
		document.form_produto.regmsmed.value = array[103];
		
		if(array[101] != ''){
			selecionarCombo('clasterap',array[101]);
		}
		
		if(array[102] != ''){
			selecionarRadio('form_produto','usoprolong',array[102]);
		}
		
		if(array[104] != ''){
			selecionarCombo('unidmed',array[104]);
		}
		
		document.form_produto.coddcbins.value = array[105];
		
		//--------- tab 2 ----------
		
		document.form_produto.codvas.value = array[9];
		
		if(array[9] != ''){
			selVasilhame();
		}
		
		if(array[10] != ''){
			document.form_produto.vlcomi.value = float2moeda(array[10]);
		}
		
		if(array[84] != ''){
			selecionarCombo('codcolecao',array[84]);
		}
		
		if(array[83] != ''){
			selecionarCombo('codaluser',array[83]);
		}
		
		if(array[92] != ''){
			document.form_produto.pesobruto.value = float2moeda(array[92]);
		}
		
		if(array[93] != ''){
			document.form_produto.pesoliquido.value = float2moeda(array[93]);
		}
		
		document.form_produto.diasvenc.value = array[109];
		document.form_produto.casadec.value = array[88];
		
		if(array[87] != ''){
			selecionarCombo('corconsul',array[87]);
		}
		
		//-------- tab 3 -----------
		
		if(array[41] != ''){
			selecionarRadio('form_produto','stprod',array[41]);
		}
		
		if(array[42] != ''){
			selecionarRadio('form_produto','qualprod',array[42]);
		}
		
		if(array[36] != ''){
			selecionarRadio('form_produto','contrquant',array[36]);
		}
		
		if(array[37] != ''){
			selecionarRadio('form_produto','contrrefer',array[37]);
		}
		
		if(array[38] != ''){
			selecionarRadio('form_produto','contrcomp',array[38]);
		}
		
		if(array[61] != ''){
			selecionarRadio('form_produto','meioameio',array[61]);
		}
		
		if(array[35] != ''){
			selecionarRadio('form_produto','massacompr',array[35]);
		}
		
		if(array[81] != ''){
			selecionarRadio('form_produto','balanca',array[81]);
		}
		
		if(array[107] != ''){
			selecionarRadio('form_produto','cestabas',array[107]);
		}
		
		if(array[108] != ''){
			selecionarRadio('form_produto','desonfolha',array[108]);
		}
		
		if(array[39] != ''){
			selecionarRadio('form_produto','contrponto',array[39]);
		}
		
		document.form_produto.baixaponto.value = array[40];
		
		if(array[94] != ''){
			selecionarRadio('form_produto','libdesconto',array[94]);
		}
		
		if(array[70] != ''){
			selecionarRadio('form_produto','libquant',array[70]);
		}
		
		if(array[64] != ''){
			selecionarRadio('form_produto','tpsubest',array[64]);
		}
		
		document.form_produto.codrefer.value = array[5];
		document.form_produto.modelo.value = array[65];
		document.form_produto.tamanho.value = array[66];
		document.form_produto.cores.value = array[106];
		document.form_produto.vlcomiavva.value = array[71];
		document.form_produto.vlcomiccva.value = array[72];
		document.form_produto.vlcomiapva.value = array[73];
		document.form_produto.vlcomiavat.value = array[74];
		document.form_produto.vlcomiccat.value = array[75];
		document.form_produto.vlcomiapat.value = array[76];
		
		//---------- tab 4 --------------
		
		if(array[31] != ''){
			selecionarCombo('indice',array[31]);
		}
		
		document.form_produto.icms.value = array[30];
		
		if(array[58] != ''){
			selecionarRadio('form_produto','substrib',array[58]);
		}
		
		document.form_produto.perclucro.value = array[68];
		document.form_produto.fatorirpj.value = array[54];
		document.form_produto.fatorcsll.value = array[55];
		
		if(array[59] != ''){
			selecionarRadio('form_produto','ipi',array[59]);
		}
		
		document.form_produto.percipi.value = array[60];
		
		if(array[91] != ''){
			selecionarRadio('form_produto','tribmono',array[91]);
		}
		
		document.form_produto.fatorpis.value = array[56];
		document.form_produto.fatorcofins.value = array[57];
		document.form_produto.cst.value = array[89];
		
		if(array[82] != ''){
			selecionarCombo('clasfiscal',array[82]);
		}
		
		if(array[110] != ''){
			selecionarRadio('form_produto','origprod',array[110]);
		}
		
		document.form_produto.codgen.value = array[97];
		document.form_produto.exipi.value = array[96];
		document.form_produto.codlst.value = array[98];
		
		if(array[98] != ''){
			selServico();
		}
		
		if(array[95] != ''){
			selecionarCombo('tipoitem',array[95]);
		}
		
		document.form_produto.codanp.value = array[99];
		document.form_produto.codif.value = array[100];
		
		// --------------- tab 5 ---------------
		
			$.ajax({type: "POST",url: "funTabProAgr.php",data: 'codpro='+array[0] ,beforeSend: function() {
				
				$('#loading').fadeIn();
				
			},success: function(txt) {
			
				$('#loading').fadeOut();
			//alert(txt);
			
			var string = txt;
			var array_agr = string.split('|');
			
			document.form_produto.acagr.value = array_agr[0];
			document.form_produto.alagr.value = array_agr[1];
			document.form_produto.amagr.value = array_agr[2];
			document.form_produto.apagr.value = array_agr[3];
			document.form_produto.baagr.value = array_agr[4];
			document.form_produto.ceagr.value = array_agr[5];
			document.form_produto.dfagr.value = array_agr[6];
			document.form_produto.esagr.value = array_agr[7];
			document.form_produto.goagr.value = array_agr[8];
			document.form_produto.maagr.value = array_agr[9];
			document.form_produto.mtagr.value = array_agr[10];
			document.form_produto.msagr.value = array_agr[11];
			document.form_produto.mgagr.value = array_agr[12];
			document.form_produto.paagr.value = array_agr[13];
			document.form_produto.pbagr.value = array_agr[14];
			document.form_produto.pragr.value = array_agr[15];
			document.form_produto.peagr.value = array_agr[16];
			document.form_produto.piagr.value = array_agr[17];
			document.form_produto.rnagr.value = array_agr[18];
			document.form_produto.rsagr.value = array_agr[19];
			document.form_produto.rjagr.value = array_agr[20];
			document.form_produto.roagr.value = array_agr[21];
			document.form_produto.rragr.value = array_agr[22];
			document.form_produto.scagr.value = array_agr[23];
			document.form_produto.spagr.value = array_agr[24];
			document.form_produto.seagr.value = array_agr[25];
			document.form_produto.toagr.value = array_agr[26];
				
			}});
		
		//--------------- fim tab --------------
		
		$("#tabs").tabs();
		$('#camada1').fadeIn();
		
		//$('#camada1').css({position: 'fixed'});
		
		$('#camada1 input:text').keyup(function(){
			var valor = $(this).val().toUpperCase();
			$(this).val(valor);
		});
		
		$('#gravar').click(function(){gravar(2);});
		
		$("#nomvas").autocomplete({
			source: "funSugestaoVasilhame.php",
			minLength: 4,
			select: function( event, ui ) {
				document.form_produto.codvas.value = ui.item.id;
				//$('#codcli').val(ui.item.id);
				//selecionarCombo('codven',ui.item.codven);
				//alert(ui.item.id);
			}
		});
		
		$("#nomlst").autocomplete({
			source: servicos,
			minLength: 2,
			select: function( event, ui ) {
				var index = parseInt(ui.item.label.indexOf('-'),10)-1;
				//alert(index);
				document.form_produto.codlst.value = ui.item.label.substr(0,index);
				document.form_produto.nomlst.value = ui.item.label.substr(0,100);
				//$('#codcli').val(ui.item.id);
				//selecionarCombo('codven',ui.item.codven);
				//alert(ui.item.id);
			}
		});
		
		$('#camada1 .valor').priceFormat({
			prefix: '',
			centsSeparator: ',',
			thousandsSeparator: '.',
			limit: 17,
			centsLimit: 2
		});
		
		$('#camada1').tooltip();
		$('#camada1').tooltip().off("mouseover mouseout");
		
	}
	
	function excluir(){
		
		if(confirm('Deseja realmente excluir o produto selecionado?')){
			gravar(3);
		}
		
	}
	
	function gravar(movimento){
		var dados = $('#form_produto').serialize();
		dados = dados+'&movimento='+movimento;
		
			$.ajax({type: "POST",url: "funGravarProduto.php",data: dados ,beforeSend: function() {
				
				$('#loading').fadeIn();
				
			},success: function(txt) {
			
				$('#loading').fadeOut();
			alert(txt);
			
			var string = txt;
			var array = string.split('@');
			
				if(array[0] == 0){
					switch(parseInt(movimento,10)){
						case 1:
							$('#camada1').fadeOut();
							$('#camada1').html('');
							alert('produto cadastrado com sucesso !');
							consulta(0);
						break;
						case 2:
							$('#camada1').fadeOut();
							$('#camada1').html('');
							alert('produto alterado com sucesso !');
							consulta(0);
						break;
						default:
							alert('Outro movimento');
						break;
					}
				} else {
					alert('Erro ao inserir o produto, tente novamente.');
				}
				
			//$('#resultado').html(txt);
			//$('#msg').html('');
				
			}});
	}
	
	function selVasilhame(){
		
		var codvas = document.form_produto.codvas.value;
		//alert(codvas);
		if(codvas != ''){
			$.ajax({async: false, type: "POST",url: "funSelVas.php",data: 'codvas='+codvas ,beforeSend: function() {
			//$('#msgcodvas').html('<img src="/imagens/ajax-loader.gif" style=" height:30px " />');	
			},success: function(txt) {
			//alert(txt);
			
			var string_vas = txt;
			var array_vas = string_vas.split('|');
			
			if(array_vas[0] == '0'){
				document.form_produto.nomvas.value = array_vas[1];
				document.form_produto.codvas.value = array_vas[2];
			} else {
				alert('Vasilhame nao encontrado');
			}
			
			//$('#msgcodvas').html(' ');
			
			},error: function(){
				alert('erro');
			}});
		}
	}
	
	function selServico(){
		
		var codlst = document.form_produto.codlst.value;
		//alert(codvas);
		
		posicao = -1;  
  
		for (i=0; i<array_servicos.length; i++){  
			if (array_servicos[i].indexOf(codlst)) {  
				//alert(array_servicos[i]);
				document.form_produto.nomlst.value = array_servicos[i];
				break;          
			}  
		}  
		  
	}
	
</script>
<style>
  .ui-tooltip, .arrow:after {
    background: #00135A;
    border: 2px solid white;
  }
  .ui-tooltip {
    padding: 10px 20px;
    color: white;
    border-radius: 20px;
    box-shadow: 0 0 7px black;
  }
  .arrow {
    width: 70px;
    height: 16px;
    overflow: hidden;
    position: absolute;
    left: 50%;
    margin-left: -35px;
    bottom: -16px;
  }
  .arrow.top {
    top: -16px;
    bottom: auto;
  }
  .arrow.left {
    left: 20%;
  }
  .arrow:after {
    content: "";
    position: absolute;
    left: 20px;
    top: -20px;
    width: 25px;
    height: 25px;
    box-shadow: 6px 5px 9px -9px black;
    -webkit-transform: rotate(45deg);
    -moz-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    -o-transform: rotate(45deg);
    tranform: rotate(45deg);
  }
  .arrow.top:after {
    bottom: -20px;
    top: auto;
  }
  </style>
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
<h2 align="center">Cadastro de Produtos</h2>
<form name="pesquisa" id="pesquisa" method="post" action="index.php" onSubmit=" return consulta(0); " >
<fieldset>
<div><label>Buscar por</label> <select name="campo" id="campo" size="1" ><option value="DESCPRO">Nome</option><option value="CODPRO">C&oacute;digo</option></select></div>
<div><label>Pesquisa</label> <input type="text" name="pesquisa"  maxlength="10" /></div>
<div><label>Ordem</label> <select name="ordem" id="ordem" size="1" ><option value="DESCPRO">Nome</option><option value="CODPRO">C&oacute;digo</option></select></div>
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