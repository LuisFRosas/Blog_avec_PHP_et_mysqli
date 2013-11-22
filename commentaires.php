<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Commentaires du Blog avec PHP et MySQLi : Luis Felipe Rosas</title>
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
			border:1px solid #000;
			background-color:#ffffff;
			padding:5px;
			width:100%;
		}
		.table th{
			background-color:#999;
		}
		.table .contenu {
			padding-left:60px;
		}
		.ligne{
			border-bottom:1px solid #000;
			background-color:#d9d9d9;
			pagging-bottom:5px;
		}		
		#copyright{
			text-align:center;
		}
	</style>
</head>
	<body>
		<?php
			if(!empty($_GET["billet"])){
				include("./includes/connexionObjet.inc.php");
				$id = connexionObjet("????", "dbconnect");
				
				$id_billet = $_GET["billet"];
				
				$content = "<div class='container'>
								<h1>Mon super BLOG!</h1>";
				// table billets: id, titre, contenu, date_creation
				// table commentaires: id, id_billet, auteur, commentaire, date_commentaire
				$requetePrep = $id->prepare("SELECT titre, contenu, date_creation
											FROM billets
											WHERE id=?");
				
				$requetePrep->bind_param("i",$id_billet);
				$requetePrep->execute();
				$requetePrep->bind_result($titre,$contenu, $date_creation);

				if(!$requetePrep){
					$content .= "<h1>Lecture imposible</h1>";
				}
				else{
					$content .= "<a href='index.php'>Retour à la liste des billets</a><br/><br/>
								<table class='table'>";
					while($requetePrep->fetch()){
						$content .= "<tr>
											<th>Titre : ".$titre." le ".date("d/m/y/ \à G\hi\m\i\\ns\s", strtotime($date_creation))."</th>
										</tr>
										<tr>							
											<td>Contenu :</td>
										</tr>						
										<tr>							
											<td class='contenu'>".$contenu."</td>
										</tr>";
					}
					
					$requeteCommentsPrep = $id->prepare("SELECT auteur, commentaire, date_commentaire FROM commentaires WHERE id_billet=?");
				
					$requeteCommentsPrep->bind_param("i",$id_billet);
					$requeteCommentsPrep->execute();
					$requeteCommentsPrep->bind_result($auteur, $commentaire, $date_commentaire);
					
					if($requeteCommentsPrep){
						$content .= "<tr>
										<td><h3>Commentaires</h3></td>
									</tr>";
						while($requeteCommentsPrep->fetch()){
							$content .= "<tr>
											<td><strong>".$auteur."</strong> le ".date("d/m/y/ \à G\hi\m\i\\ns\s", strtotime($date_commentaire))."</td>
										</tr>						
										<tr>							
											<td class='ligne'>".$commentaire."</td>
										</tr>";
						}
					}
					else{
						$content .= "<h3>Il n'y a pas de commentaires.</h3>";
					}
				}
				$content .= "</table><p id='copyright'>Auteur: Luis Felipe Rosas. Cours: Programmation Orientée Objet</p></div>";
				$requetePrep->free_result();
				$requeteCommentsPrep->free_result();
				$id->close();
				
				echo $content;
			}
		?>
	</body>
</html>