<?php

class banco {
 
    var $host       = 'localhost';
    var $usuario    = 'SYSDBA';
    var $senha      = 'masterkey';
    var $banco      = 'C:\renato\INTEGRADO.GDB';
 
    var $conexao;
    var $query;
	var $trans;
 	
	var $sgdb		= 'firebird';
	
    function conecta() {
		switch($this->sgdb){
			case 'mysql':
				$this->conexao = mysql_connect($this->host, $this->usuario, $this->senha);
				$status = mysql_select_db($this->banco, $this->conexao);
				return $status;
			break;
			case 'firebird':
				$this->conexao = ibase_connect($this->host.':'.$this->banco, $this->usuario, $this->senha,"ISO8859_1");
				return $this->conexao;
			break;
		}
    }
 
    function consulta($query) {
        switch($this->sgdb){
			case 'mysql':
				$this->query = mysql_query($query);
				return $this->query;
			break;
			case 'firebird':
				$this->trans = ibase_trans( IBASE_DEFAULT,$this->conexao );
				$this->query = ibase_query( $query );
				ibase_commit($this->trans);
				return $this->query;
			break;
		}
    }
 
    function resultado() {
		switch($this->sgdb){
			case 'mysql':
        		return mysql_fetch_assoc($this->query);
			break;
			case 'firebird';
				return ibase_fetch_assoc($this->query);
			break;
		}
    }
	
	function desconecta() {
		switch($this->sgdb){
			case 'mysql':
        		return mysql_close($this->conexao);
			break;
			case 'firebird';
				return ibase_close($this->conexao);
			break;
		}
	}
	
	function liberaResultado(){
		switch($this->query){
			case 'mysql':
        		return mysql_free_result($this->query);
			break;
			case 'firebird';
				return ibase_free_result($this->query);
			break;
		}	
	}
}

// ----------------------- anti sql injection ---------------------------------

function asi($str){
	if(!is_numeric($str)){
		$str = addslashes($str);
		$str = htmlspecialchars($str);
   		$str = str_replace("SELECT",   "", $str);
   		$str = str_replace("FROM",     "", $str);
   		$str = str_replace("WHERE",    "", $str);
   		$str = str_replace("INSERT",   "", $str);
   		$str = str_replace("UPDATE",   "", $str);
   		$str = str_replace("DELETE",   "", $str);
   		$str = str_replace("DROP",     "", $str);
   		$str = str_replace("DATABASE", "", $str);
		$str = str_replace("\'", "", $str);
		$str = str_replace('\"', "", $str);
	}
	return $str;
}

// ----------------------- anti sql injection fim ----------------------------


function completarComZeros($str,$tamanho){
	$diferenca = intval($tamanho)-strlen($str);
	
	for($i = 0; $i < $diferenca; $i++){
		$str = '0'.$str;
	}
	
	return($str);
}

?>