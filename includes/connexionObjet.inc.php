<?php
	function connexionObjet($base, $param){
		require_once($param.".inc.php");
		$id = new mysqli(HOST,USER,PASS,$base);
		$id->query("SET NAMES UTF8");
		
		if(!$id){
			echo "<script type=text/javascript>"." alert('Connexion Imposible à la base')"
					."</script>";
			exit();
		}
		return $id;
	
	}
?>