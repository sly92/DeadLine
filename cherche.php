	<?php	 require('connexion.php'); ?>


<br/><br/><br/>
<form action="index2.php" id="cherche" method="post"> 
	<!-- plus sûre -->
  Souhaitez-vous cherchez une tâche en particulier ? 
  &nbsp;&nbsp;&nbsp;<input type="search" name="nomTache">
  <input type="submit" name="chercher" value ="chercher">
</form><br/>

<?php 
$datetime = date("d-m");
$param = array('chercher','nomTache');


if(testParam($param,$_POST))
{
	try
	{
		$req = $DB->prepare('SELECT id, title, description, DATE_FORMAT(date,"%d/%m") as datet, fait, utilisateur, frequence, rappel, tz  FROM events
							WHERE title = :nomTache 
							AND utilisateur =:login');
		
		$req->bindValue(':nomTache', $_POST['nomTache']);
		$req->bindValue(':login', $_SESSION['login']);
		$req->execute();
	

	if ($DB = $req->fetch(PDO::FETCH_ASSOC)!= null){
			while($DB = $req->fetch(PDO::FETCH_ASSOC))
	{	
		echo '<ul>';
	?>
			<p><li name= "tache"><a name="tache" href="infoTache.php?id=<?php echo urlencode($DB['id'])?>"><?php echo $DB['title'];?></a>&nbsp; &nbsp;<?php echo '    '; echo $DB['datet'];?>
	<?php	
		
			if(!$DB['fait']) {
	?>		&nbsp; &nbsp;<a href="marque.php?as=fait&fre=<?php echo $DB['frequence'];?>&dd=<?php echo $DB['datet'];?>&tache=<?php echo $DB['id'];?>" class="bouton-effectué"><img src="images/valider.png" alt="valide"/></a>&nbsp;&nbsp;&nbsp;<a href="reporter.php?id=<?php echo urlencode($DB['id'])?>&report=11"><img  id="ico" src="images/plusun.png" alt="plusun"/></a>&nbsp;&nbsp;&nbsp;<a href="supprimer.php?id=<?php echo urlencode($DB['id'])?>"><img src="images/supprimer.png" alt="suppr"/></a>&nbsp;&nbsp;&nbsp;<a href="modification.php?id=<?php echo urlencode($DB['id'])?>"><img src="images/modifier.png" alt="modif"/></a></li></p>
		<?php } 
		
	echo '</ul>';
	
	}
	}	
		else echo '<p> La tache n\'existe pas </p>';	
	}
	catch(PDOException $e)
	{
		die(' Erreur : ' . $e->getMessage() . '</div></body></html>');
	}
	
	}
	else 
		if(isset($_POST['chercher']))
		echo '<br/> Veuillez taper le nom d\'une tache dans la barre de recherche ';
?>

