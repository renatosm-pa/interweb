<a href="/interweb" >
<img src="/interweb/imagens/Interage_200.png" class="logo" />
<h1>Interage Sistemas</h1>
</a>
<?php if(isset($_SESSION['CODUSU']) and isset($_SESSION['NOMUSU']) and isset($_SESSION['SISTEMAS']) and isset($_SESSION['FILIAIS'])){ ?>
<div id="usuario">
Logado como <?php echo($_SESSION['NOMUSU']); ?>
<button name="sair" onclick=" logoff(); " >Sair</button>
</div>
<?php } ?>