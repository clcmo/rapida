<?php	
	# Classe referente as Tabelas
  	class Tables {
    	# 1 - Verifica se a tabela existe, através da informação de uma string
    	function IsThisTableExists($name_table){
		    $Load = new Load;
		    $PDO = $Load->DataBase();
		    $con = $PDO->query("SHOW TABLES") or die ($PDO);
		    while ($row = $con->fetch(PDO::FETCH_OBJ)) {
		    	$tabs[] = $row;
		    }
		    return ($tabs) ? true : false;
	    }
		
		# 2.1 - Localizar uma coluna de uma tabela para carregar seus dados
	    function Found_Item($item, $name_table){
	    	return $item.'_'.substr($name_table, 0, 3);
	    }

	    # 2 - Carregar todos os dados (ou específicos) de uma tabela através do string informado
	    function SelectFrom($item = null, $name_table_and_cond, $limit = array()){
	    	$Tables = new Tables;
	    	switch ($item) {
	    		case 'COUNT':
	    			$sql = 'SELECT COUNT('.$Tables->Found_Item('id', $name_table).') AS qt';
	    		break;

	    		case null:
	    			$sql = 'SELECT *';
	    		break;
	    		
	    		default:
	    			$sql = 'SELECT '.$item;
	    		break;
	    	}
	    	$sql .= (!$limit) ? ' FROM '.$name_table_and_cond : ' FROM '.$name_table_and_cond.' LIMIT '.$limit[1].', '.$limit[2];
	    	return $sql;
	    }

	    # 2.2 - Contar dados existentes de uma tabela através do string informado
	    function LoadCountFrom($name_table){
	      	$Tables = new Tables;
	      	return $Tables->LoadFrom('COUNT', $name_table);
	    }

	    # 3 - Cria o Hash da Senha, usando MD5 e SHA-1
	    function HashStr($password){
	    	return sha1(md5($password));
	    }

	    # 4 - Busca uma determinada linha da tabela //a desenvolver
	    function SearchId($name_table){
	     	return isset($_REQUEST['id']) ? $_REQUEST['id']: '';
	    }

	    # 5 - Conta os registros de uma tabela ou de uma busca //a aprimorar
	    function CountViewTable($type = null, $name_table, $item = null){
	    	$Load = new Load;
	    	$Tables = new Tables;
	      	$PDO = $Load->DataBase();
	      	switch ($type) {
	      		case 'search':
	      			$q = isset($_GET['q']) ? $_GET['q'] : '';
	      			$qt = count($PDO->prepare($Tables->LoadCountFrom($name_table)." WHERE ".$item." LIKE '%".$q."%' ORDER BY ".$item) or die ($PDO));
	      		break;
	      		
	      		case null:
	      		default:
	      			$con = $PDO->query($Tables->LoadCountFrom($name_table)) or die ($PDO);
	      			while($row = $con->fetch(PDO::FETCH_OBJ)){
	        			$qt = $row->qt;
	      			}
	      		break;
	      	}
	      	return $qt;
	    }

	    # 6 - Deleta um registro do sistema // a desenvolver
	    function DeleteId($name_table){
	    	$Load = new Load;
	    	$Tables = new Tables;
	    	$PDO = $Load->DataBase();
	    	$con = $PDO->query('DELETE FROM '.$name_table.' WHERE '.$Tables->FoundId($name_table).' = '.$Tables->SearchId($name_table)) or die ($PDO);
	    	if ($con) {
	    	  return $Load->GoToLink($str);
	    	} else {
	    	  //return messageShow('error', $_SERVER['REQUEST_URI'], $str);
	    	}
	    }
  	}
  	$Tables = new Tables;