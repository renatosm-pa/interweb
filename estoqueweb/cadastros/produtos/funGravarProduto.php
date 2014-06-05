<?php

session_start();

header("Content-Type: text/html;  charset=ISO-8859-1",true);

require("../../../banco/banco.php");

$query = new banco();
$query->conecta();

$movimento = $_REQUEST['movimento'];

	switch($movimento){
	case 1:
		
		$sql2 =  "select numero from chave where alias = 'PRO' ;";
		
		$array2 = $query->consulta($sql2);
		$array2 = $query->resultado();
		
		if($array2['NUMERO'] != ''){
			$codigo = intval($array2['NUMERO']) +1;
		} else {
			$codigo = 0;
		}
		
		//echo(completarComZeros($codigo,6));
		
		$sql = "insert into tabpro(codpro, descpro, unemb, qtdemb, unidade, codbarun, detalhe, codbarcx, grupro, fabpro, regmsmed, 
		clasterap, usoprolong, unidmed, coddcbins, codvas, vlcomi, codcolecao, codaluser, pesobruto, pesoliquido, diasvenc, casadec,
		corconsul, stprod, qualprod, contrquant, contrrefer, contrcomp, meioameio, massacompr, balanca, cestabas, desonfolha, contrponto,
		baixaponto, libdesconto, libquant, tpsubest, codrefer, modelo, tamanho, cores, vlcomiavva, vlcomiccva, vlcomiapva, vlcomiavat, 
		vlcomiccat, vlcomiapat, indice, icms, substrib, perclucro, fatorirpj, fatorcsll, ipi, percipi, tribmono, fatorpis, fatorcofins,
		cst, clasfiscal, origprod, codgen, exipi, codlst, tipoitem, codanp, codif, rgcodusu, rgusuario, rgdata, rgevento)
		values('".completarComZeros($codigo,6)."','".asi(utf8_decode($_REQUEST['descpro']))."', '".asi(utf8_decode($_REQUEST['unemb']))."', '".asi(utf8_decode($_REQUEST['qtdemb']))."', '".asi(utf8_decode($_REQUEST['unidade']))."', '".asi(utf8_decode($_REQUEST['codbarun']))."', '".asi(utf8_decode($_REQUEST['detalhe']))."', '".asi(utf8_decode($_REQUEST['codbarcx']))."', '".asi(utf8_decode($_REQUEST['grupro']))."', '".asi(utf8_decode($_REQUEST['fabpro']))."', '".asi(utf8_decode($_REQUEST['regmsmed']))."', '".asi(utf8_decode($_REQUEST['clasterap']))."', '".asi(utf8_decode($_REQUEST['usoprolong']))."', '".asi(utf8_decode($_REQUEST['unidmed']))."', '".asi(utf8_decode($_REQUEST['coddcbins']))."', '".asi(utf8_decode($_REQUEST['codvas']))."', '".asi(str_replace(',','.',str_replace('.','',utf8_decode($_REQUEST['vlcomi']))))."', '".asi(utf8_decode($_REQUEST['codcolecao']))."', '".asi(utf8_decode($_REQUEST['codaluser']))."', '".asi(str_replace(',','.',str_replace('.','',utf8_decode($_REQUEST['pesobruto']))))."', '".asi(str_replace(',','.',str_replace('.','',utf8_decode($_REQUEST['pesoliquido']))))."', '".asi(utf8_decode($_REQUEST['diasvenc']))."', '".asi(utf8_decode($_REQUEST['casadec']))."', '".asi(utf8_decode($_REQUEST['corconsul']))."', '".asi(utf8_decode($_REQUEST['stprod']))."', '".asi(utf8_decode($_REQUEST['qualprod']))."', '".asi(utf8_decode($_REQUEST['contrquant']))."', '".asi(utf8_decode($_REQUEST['contrrefer']))."', '".asi(utf8_decode($_REQUEST['contrcomp']))."', '".asi(utf8_decode($_REQUEST['meioameio']))."', '".asi(utf8_decode($_REQUEST['massacompr']))."', '".asi(utf8_decode($_REQUEST['balanca']))."', '".asi(utf8_decode($_REQUEST['cestabas']))."', '".asi(utf8_decode($_REQUEST['desonfolha']))."', '".asi(utf8_decode($_REQUEST['contrponto']))."', '".asi(str_replace(',','.',str_replace('.','',utf8_decode($_REQUEST['baixaponto']))))."', '".asi(utf8_decode($_REQUEST['libdesconto']))."', '".asi(utf8_decode($_REQUEST['libquant']))."', '".asi(utf8_decode($_REQUEST['tpsubest']))."', '".asi(utf8_decode($_REQUEST['codrefer']))."', '".asi(utf8_decode($_REQUEST['modelo']))."', '".asi(utf8_decode($_REQUEST['tamanho']))."', '".asi(utf8_decode($_REQUEST['cores']))."', '".asi(utf8_decode($_REQUEST['vlcomiavva']))."', '".asi(utf8_decode($_REQUEST['vlcomiccva']))."', '".asi(utf8_decode($_REQUEST['vlcomiapva']))."', '".asi(utf8_decode($_REQUEST['vlcomiavat']))."', '".asi(utf8_decode($_REQUEST['vlcomiccat']))."', '".asi(utf8_decode($_REQUEST['vlcomiapat']))."', '".asi(utf8_decode($_REQUEST['indice']))."', '".asi(utf8_decode($_REQUEST['icms']))."', '".asi(utf8_decode($_REQUEST['substrib']))."', '".asi(utf8_decode($_REQUEST['perclucro']))."', '".asi(utf8_decode($_REQUEST['fatorirpj']))."', '".asi(utf8_decode($_REQUEST['fatorcsll']))."', '".asi(utf8_decode($_REQUEST['ipi']))."', '".asi(utf8_decode($_REQUEST['percipi']))."', '".asi(utf8_decode($_REQUEST['tribmono']))."', '".asi(utf8_decode($_REQUEST['fatorpis']))."', '".asi(utf8_decode($_REQUEST['fatorcofins']))."', '".asi(utf8_decode($_REQUEST['cst']))."', '".asi(utf8_decode($_REQUEST['clasfiscal']))."', '".asi(utf8_decode($_REQUEST['origprod']))."', '".asi(utf8_decode($_REQUEST['codgen']))."', '".asi(utf8_decode($_REQUEST['exipi']))."', '".asi(utf8_decode($_REQUEST['codlst']))."', '".asi(utf8_decode($_REQUEST['tipoitem']))."', '".asi(utf8_decode($_REQUEST['codanp']))."', '".asi(utf8_decode($_REQUEST['codif']))."', '".$_SESSION['CODUSU']."', '".$_SESSION['NOMUSU']."', '".date('d.m.Y')."', 1); ";
		
		$sql = str_replace("''",'null',$sql);
		//echo($sql);
		$res = $query->consulta($sql);
		
		$sql2 = "insert into tabproagr(codpro, acagr, alagr, amagr, apagr, baagr, ceagr, dfagr, esagr,
		goagr, maagr, mtagr, msagr, mgagr, paagr, pbagr, pragr, peagr, piagr, rnagr, rsagr, rjagr, roagr, rragr, scagr, spagr, seagr, 
		toagr) values ( '".completarComZeros($codigo,6)."', '".asi(utf8_decode($_REQUEST['acagr']))."', '".asi(utf8_decode($_REQUEST['alagr']))."', '".asi(utf8_decode($_REQUEST['amagr']))."', '".asi(utf8_decode($_REQUEST['apagr']))."', '".asi(utf8_decode($_REQUEST['baagr']))."', '".asi(utf8_decode($_REQUEST['ceagr']))."', '".asi(utf8_decode($_REQUEST['dfagr']))."', '".asi(utf8_decode($_REQUEST['esagr']))."', '".asi(utf8_decode($_REQUEST['goagr']))."', '".asi(utf8_decode($_REQUEST['maagr']))."', '".asi(utf8_decode($_REQUEST['mtagr']))."', '".asi(utf8_decode($_REQUEST['msagr']))."', '".asi(utf8_decode($_REQUEST['mgagr']))."', '".asi(utf8_decode($_REQUEST['paagr']))."', '".asi(utf8_decode($_REQUEST['pbagr']))."', '".asi(utf8_decode($_REQUEST['pragr']))."', '".asi(utf8_decode($_REQUEST['peagr']))."', '".asi(utf8_decode($_REQUEST['piagr']))."', '".asi(utf8_decode($_REQUEST['rnagr']))."', '".asi(utf8_decode($_REQUEST['rsagr']))."', '".asi(utf8_decode($_REQUEST['rjagr']))."', '".asi(utf8_decode($_REQUEST['roagr']))."', '".asi(utf8_decode($_REQUEST['rragr']))."', '".asi(utf8_decode($_REQUEST['scagr']))."', '".asi(utf8_decode($_REQUEST['spagr']))."', '".asi(utf8_decode($_REQUEST['seagr']))."', '".asi(utf8_decode($_REQUEST['toagr']))."');";
		
		$sql2 = str_replace("''",'null',$sql2);
		
		$res2 = $query->consulta($sql2);
			
		if($res){
			$resultado = 0;
			
			$sql3 =  "update chave set numero = '$codigo' where alias = 'PRO' ;";
			$query->consulta($sql3);
			
		} else {
			$resultado = 1;
		}
	
	break;
	case 2:
	
		$codigo = $_REQUEST['codpro'];
		
		$sql = "update tabpro set descpro = '".asi(utf8_decode($_REQUEST['descpro']))."', 
		unemb = '".asi(utf8_decode($_REQUEST['unemb']))."', qtdemb = '".asi(utf8_decode($_REQUEST['qtdemb']))."', 
		unidade = '".asi(utf8_decode($_REQUEST['unidade']))."', codbarun = '".asi(utf8_decode($_REQUEST['codbarun']))."', 
		detalhe = '".asi(utf8_decode($_REQUEST['detalhe']))."', codbarcx = '".asi(utf8_decode($_REQUEST['codbarcx']))."', 
		grupro = '".asi(utf8_decode($_REQUEST['grupro']))."', fabpro = '".asi(utf8_decode($_REQUEST['fabpro']))."', 
		regmsmed = '".asi(utf8_decode($_REQUEST['regmsmed']))."', clasterap = '".asi(utf8_decode($_REQUEST['clasterap']))."', 
		usoprolong = '".asi(utf8_decode($_REQUEST['usoprolong']))."', unidmed = '".asi(utf8_decode($_REQUEST['unidmed']))."', 
		coddcbins = '".asi(utf8_decode($_REQUEST['coddcbins']))."', codvas = '".asi(utf8_decode($_REQUEST['codvas']))."', 
		vlcomi = '".asi(str_replace(',','.',str_replace('.','',utf8_decode($_REQUEST['vlcomi']))))."', 
		codcolecao = '".asi(utf8_decode($_REQUEST['codcolecao']))."', 
		codaluser = '".asi(utf8_decode($_REQUEST['codaluser']))."', 
		pesobruto = '".asi(str_replace(',','.',str_replace('.','',utf8_decode($_REQUEST['pesobruto']))))."', 
		pesoliquido = '".asi(str_replace(',','.',str_replace('.','',utf8_decode($_REQUEST['pesoliquido']))))."', 
		diasvenc = '".asi(utf8_decode($_REQUEST['diasvenc']))."', 
		casadec = '".asi(utf8_decode($_REQUEST['casadec']))."', corconsul = '".asi(utf8_decode($_REQUEST['corconsul']))."', 
		stprod = '".asi(utf8_decode($_REQUEST['stprod']))."', qualprod = '".asi(utf8_decode($_REQUEST['qualprod']))."', 
		contrquant = '".asi(utf8_decode($_REQUEST['contrquant']))."', contrrefer = '".asi(utf8_decode($_REQUEST['contrrefer']))."', 
		contrcomp = '".asi(utf8_decode($_REQUEST['contrcomp']))."', meioameio = '".asi(utf8_decode($_REQUEST['meioameio']))."', 
		massacompr = '".asi(utf8_decode($_REQUEST['massacompr']))."', balanca = '".asi(utf8_decode($_REQUEST['balanca']))."', 
		cestabas = '".asi(utf8_decode($_REQUEST['cestabas']))."', desonfolha = '".asi(utf8_decode($_REQUEST['desonfolha']))."', 
		contrponto = '".asi(utf8_decode($_REQUEST['contrponto']))."', 
		baixaponto = '".asi(str_replace(',','.',str_replace('.','',utf8_decode($_REQUEST['baixaponto']))))."', 
		libdesconto = '".asi(utf8_decode($_REQUEST['libdesconto']))."', libquant = '".asi(utf8_decode($_REQUEST['libquant']))."', 
		tpsubest = '".asi(utf8_decode($_REQUEST['tpsubest']))."', codrefer = '".asi(utf8_decode($_REQUEST['codrefer']))."', 
		modelo = '".asi(utf8_decode($_REQUEST['modelo']))."', tamanho = '".asi(utf8_decode($_REQUEST['tamanho']))."', 
		cores = '".asi(utf8_decode($_REQUEST['cores']))."', vlcomiavva = '".asi(utf8_decode($_REQUEST['vlcomiavva']))."', 
		vlcomiccva = '".asi(utf8_decode($_REQUEST['vlcomiccva']))."', vlcomiapva = '".asi(utf8_decode($_REQUEST['vlcomiapva']))."', 
		vlcomiavat = '".asi(utf8_decode($_REQUEST['vlcomiavat']))."', vlcomiccat = '".asi(utf8_decode($_REQUEST['vlcomiccat']))."', 
		vlcomiapat = '".asi(utf8_decode($_REQUEST['vlcomiapat']))."', indice = '".asi(utf8_decode($_REQUEST['indice']))."', 
		icms = '".asi(utf8_decode($_REQUEST['icms']))."', substrib = '".asi(utf8_decode($_REQUEST['substrib']))."', 
		perclucro = '".asi(utf8_decode($_REQUEST['perclucro']))."', fatorirpj = '".asi(utf8_decode($_REQUEST['fatorirpj']))."', 
		fatorcsll = '".asi(utf8_decode($_REQUEST['fatorcsll']))."', ipi = '".asi(utf8_decode($_REQUEST['ipi']))."', 
		percipi = '".asi(utf8_decode($_REQUEST['percipi']))."', tribmono = '".asi(utf8_decode($_REQUEST['tribmono']))."', 
		fatorpis = '".asi(utf8_decode($_REQUEST['fatorpis']))."', fatorcofins = '".asi(utf8_decode($_REQUEST['fatorcofins']))."',
		cst = '".asi(utf8_decode($_REQUEST['cst']))."', clasfiscal = '".asi(utf8_decode($_REQUEST['clasfiscal']))."', 
		origprod = '".asi(utf8_decode($_REQUEST['origprod']))."', codgen = '".asi(utf8_decode($_REQUEST['codgen']))."', 
		exipi = '".asi(utf8_decode($_REQUEST['exipi']))."', codlst = '".asi(utf8_decode($_REQUEST['codlst']))."', 
		tipoitem = '".asi(utf8_decode($_REQUEST['tipoitem']))."', codanp = '".asi(utf8_decode($_REQUEST['codanp']))."', 
		codif = '".asi(utf8_decode($_REQUEST['codif']))."', rgcodusu = '".$_SESSION['CODUSU']."', rgusuario = '".$_SESSION['NOMUSU']."', 
		rgdata = '".date('d.m.Y')."', rgevento = 2
		where CODPRO = '$codigo'; ";
		
		$sql = str_replace("''",'null',$sql);
		
		//echo($sql);
		$trans = ibase_trans( IBASE_DEFAULT,$dbh );
		$res = ibase_query( $sql );
		ibase_commit($trans);
		
		if($res){
			$resultado = 0;
			
			$sql2 = "update tabproagr set acagr = '".asi(utf8_decode($_REQUEST['acagr']))."', 
			alagr = '".asi(utf8_decode($_REQUEST['alagr']))."', amagr = '".asi(utf8_decode($_REQUEST['amagr']))."', 
			apagr = '".asi(utf8_decode($_REQUEST['apagr']))."', baagr = '".asi(utf8_decode($_REQUEST['baagr']))."', 
			ceagr = '".asi(utf8_decode($_REQUEST['ceagr']))."', dfagr = '".asi(utf8_decode($_REQUEST['dfagr']))."', 
			esagr = '".asi(utf8_decode($_REQUEST['esagr']))."',	goagr = '".asi(utf8_decode($_REQUEST['goagr']))."', 
			maagr = '".asi(utf8_decode($_REQUEST['maagr']))."', mtagr = '".asi(utf8_decode($_REQUEST['mtagr']))."', 
			msagr = '".asi(utf8_decode($_REQUEST['msagr']))."', mgagr = '".asi(utf8_decode($_REQUEST['mgagr']))."', 
			paagr = '".asi(utf8_decode($_REQUEST['paagr']))."', pbagr = '".asi(utf8_decode($_REQUEST['pbagr']))."', 
			pragr = '".asi(utf8_decode($_REQUEST['pragr']))."', peagr = '".asi(utf8_decode($_REQUEST['peagr']))."', 
			piagr = '".asi(utf8_decode($_REQUEST['piagr']))."', rnagr = '".asi(utf8_decode($_REQUEST['rnagr']))."', 
			rsagr = '".asi(utf8_decode($_REQUEST['rsagr']))."', rjagr = '".asi(utf8_decode($_REQUEST['rjagr']))."', 
			roagr = '".asi(utf8_decode($_REQUEST['roagr']))."', rragr = '".asi(utf8_decode($_REQUEST['rragr']))."', 
			scagr = '".asi(utf8_decode($_REQUEST['scagr']))."', spagr = '".asi(utf8_decode($_REQUEST['spagr']))."', 
			seagr = '".asi(utf8_decode($_REQUEST['seagr']))."', toagr = '".asi(utf8_decode($_REQUEST['toagr']))."' 
			where codpro = '$codigo';";
			
			$sql2 = str_replace("''",'null',$sql2);
		
			$res2 = $query->consulta($sql2);
		
		} else {
			$resultado = 1;
		}
	
	break;
	case 3:
	
	$codigo = $_REQUEST['codpro'];
	
	$sql = "update tabpro set RGEVENTO = 3, RGCODUSU = ".$_SESSION['codusu'].", RGUSUARIO = '".$_SESSION['usuario']."', 
	RGDATA = '".date('d.m.Y')."' 
	where CODPRO = '$codigo'; ";
	//echo($sql);
	$trans = ibase_trans( IBASE_DEFAULT,$dbh );
	$res = ibase_query( $sql );
	ibase_commit($trans);
	
	if($res){
		$resultado = 0;
	} else {
		$resultado = 1;
	}
	
	break;
	}

	$query->desconecta();
	//ibase_close($dbh);
	
	echo($resultado.'@'.$codigo.'@'.$rep);
	
?>