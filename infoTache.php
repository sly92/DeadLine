<?php require('Require/header.php');
	  require('connexion.php');
	  require('Require/fonctions.php');
?>
<br>
<br>
<br>
<br>
    <div id="body2">
        <div id="bloc">
			<div id="calendrier2">
				<div id="co" >Information sur la tache</div>
					<?php
						afficheInfoTache($DB);
						try 
						{	
							$req = $DB->prepare('SELECT id, title, description, DATE_FORMAT(date,"%d/%m") as datet, fait,utilisateur frequence, rappel, tz FROM events
											  WHERE id =:id
											  AND utilisateur =:utilisateur'); 
							$req->bindvalue(':id', $_GET['id']);
							$req->bindvalue(':utilisateur', $_SESSION['login']);
							$req->execute();
							$DB = $req->fetch(PDO::FETCH_ASSOC);
						}
						catch (PDOException $e)
						{
							die('<p> La connexion a echoué. Erreur['.$e->getCode().'] : '.$e->getMessage().'</p>');
						}
					?>
				<div id="ajouter" name="modifier"><a name="tache" href="modification.php?id=<?php echo urlencode($DB['id'])?>">Modifier</a></div>
				<br>
				<br>
				<br>
			</div>
		</div>
	</div>