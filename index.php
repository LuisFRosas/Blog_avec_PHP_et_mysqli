<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Blog avec PHP et MySQLi : Luis Felipe Rosas</title>
	<style>
		.container{
			margin:0 auto;
			width:700px;
			text-align:left;
			background:#d1d1d1;
			padding:15px
		}
		h1{
			text-align:center;
		}
		.table{
			border:1px;
			background-color:#ffffff;
			padding:5px;
			width:100%;
		}
		.table th{
			text-align:center;
			background-color:#999;
		}
		.table .contenu {
			padding-left:60px;
		}
		#copyright{
			text-align:center;
			margin:0;
			padding:0;
		}
	</style>
</head>
	<body>
		<?php
			include("./includes/connexionObjet.inc.php");
			$id = connexionObjet("????", "dbconnect");
			$content = "<div class='container'>
							<h1>Mon super BLOG!</h1>";
			
			$requete = "SELECT *
						FROM billets
						WHERE id<=5
						ORDER BY id DESC";
			
			$result = $id->query($requete);

			if(!$result){
				$content .= "<h1>Lecture imposible</h1>";
			}
			else{				
				$content .= "<h3>Nos dernières billets du blog</h3>";
				
				if($result->num_rows != 0){	
					while($row = $result->fetch_object()){
						$content .= "<table class='table'>
										<tr>
											<th>Titre : ".$row->titre." le ".date("d/m/y/ \à G\hi\m\i\\ns\s",strtotime($row->date_creation))."</th>
										</tr>
										<tr>							
											<td>Contenu :</td>
										</tr>						
										<tr>							
											<td class='contenu'>".$row->contenu."</td>
										</tr>
										<tr>
											<td class='contenu'><a href='commentaires.php?billet=".$row->id."'>commentaires</a></td>
										</tr>
									</table><br/><hr><br/>";
					}
				}
				else{
					$content .= "<h2>Desolé il n'y a pas aucun billet pour le moment</h2>";
				}
			}
			$content .= "<p id='copyright'>Auteur: Luis Felipe Rosas. Cours: Programmation Orientée Objet</p></div>";
			$result->close();
			$id->close();

			echo $content;
			
		?>
	</body>
</html>