<?php 
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>.: Inter Web :.</title>
<link href="css/estilo.css" rel="stylesheet" />
<script src="js/jquery.js" type="text/javascript" ></script>
<script src="js/funcoes.js" type="text/javascript" ></script>
</head>
<body>
<?php //echo($pagina); ?>
<div id="cabecalho">
<?php include('cabecalho.php'); ?>
</div>
<?php if(isset($_SESSION['CODUSU']) and isset($_SESSION['NOMUSU']) and isset($_SESSION['SISTEMAS']) and isset($_SESSION['FILIAIS'])){ 

?><div id="conteudo" class="inicial"><?php

require('banco/banco.php');

$query = new banco();
$query->conecta();

$sql =  "select * from tabsis order by codsis ;";
//echo($sql);
$query->consulta($sql);

$sistemas = '';

while($array = $query->resultado()){
	if(isset($_SESSION['SISTEMAS'][$array['CODSIS']])){
		if($_SESSION['SISTEMAS'][$array['CODSIS']]['HABILITADO']){
			$sistemas .= '<div id="sis'.$array['CODSIS'].'" ><a href="'.$array['PASTA'].'" >'.htmlentities(ucfirst(strtolower(strtr($array['NOMSIS'],"ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ","áéíóúâêôãõàèìòùç")))).'</a></div>';
		} else {
			$sistemas .= '<div id="sis'.$array['CODSIS'].'" ><form name="form_sis'.$array['CODSIS'].'" onsubmit=" return autorizarModulo(this); " ><input type="hidden" name="pasta" value="'.$array['PASTA'].'" /><input type="hidden" name="codsis" value="'.$array['CODSIS'].'" /><input type="hidden" name="nomsis" value="'.$array['NOMSIS'].'" /><input type="hidden" name="chave" value="'.$_SESSION['SISTEMAS'][$array['CODSIS']]['SENHA'].'" /><h4>'.htmlentities(ucfirst(strtolower(strtr($array['NOMSIS'],"ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ","áéíóúâêôãõàèìòùç")))).'</h4><fieldset><input type="password" name="senha" value="" placeholder="Senha" /><input type="submit" value="Enviar" /></fieldset></form></div>';
		}
	}
}

echo($sistemas);

?>
</div>
<?php } else { ?>
<div id="conteudo">
<form name="form_login" id="form_login" onsubmit=" return false " >
    <div id="caixalogin" >
    <h2>&Aacute;rea de Login</h2>
    <div><label for="login" >Login:</label><input type="text" name="login"  /></div>
    <div><label for="senha" >Senha:</label><input type="password" name="senha"  /></div>
    <div>
      <button onclick=" logar(); " >Entrar</button>
      <div id="msg" ></div>
      <div class="clear"></div>
    </div>
    </div>
    </form>
</div>
<?php } ?>
<div id="rodape">
<?php include('rodape.php'); ?>
</div>
</body>
</html>