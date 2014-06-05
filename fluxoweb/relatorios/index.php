<?php 
session_start();

if(isset($_SESSION['CODUSU']) and isset($_SESSION['NOMUSU']) and isset($_SESSION['SISTEMAS']) and isset($_SESSION['FILIAIS']) and $_SESSION['SISTEMAS'][3]['HABILITADO']){

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>.: Fluxo Web :.</title>
<link href="../../css/estilo.css" rel="stylesheet" />
<link href="../../css/menu.css" rel="stylesheet" />
<script src="../../js/jquery.js" type="text/javascript" ></script>
<script src="../../js/funcoes.js" type="text/javascript" ></script>
</head>
<body>
<?php //echo($pagina); ?>
<div id="cabecalho">
<?php include('../../cabecalho.php'); ?>
</div>
<div id="menu">
<?php include('../menu.html'); ?>
</div>
<div id="conteudo"  class="inicial">
<a href="rg" >Relat&oacute;rio <br/> Geral</a>
<a href="balancete" >Balancete <br/> &nbsp;</a>
<a href="pc" >Planos <br/> de Contas</a>
<a href="bpc" >Balancete por Plano de Contas</a>
<a href="lr" >Lan&ccedil;amentos Retroativos</a>
<a href="dre" >DRE <br/> &nbsp;</a>
</div>
<div id="rodape">
<?php include('../../rodape.php'); ?>
</div>
</body>
</html>
<?php } else { 

header('location: /interweb');

 } ?>