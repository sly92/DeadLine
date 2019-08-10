
<?php require('Require/header.php');
	  require('Require/config.php');
	  require('Require/entete.php');
	  require('Require/fonctions.php');
	  require('Require/script.php');
?>
    <div id="body2">
        <div id="bloc">
			<div id="calendrier3">
				<?php 	
					$req = $DB->prepare('SELECT id, title, description, DATE_FORMAT(date,"%d/%m") as datet, fait, frequence, rappel, tz  FROM events WHERE id =:id');
					$req->bindvalue(':id',$_GET['id']);
					$req->execute();
					$res = $req->fetch(PDO::FETCH_ASSOC);
				?>
				<div id="co" ><?php echo $res['title']; ?></div>
				<?php 
				if(isset($_POST['modifier']))
				{
					$modif=0;	
					if($res['description']!=$_POST['description'])
					{
						$res['description']=$_POST['description'];
						$modif=1;
						$req = $DB->prepare('UPDATE events set description=:description where id =:id');
						$req->bindvalue(':description',$_POST['description']);
						$req->bindvalue(':id',$_GET['id']);
						$req->execute();
					}		
				
					if($_POST['frequence']!=0 && $res['frequence']!=$_POST['frequence'])
					{
						$modif=1;
						$req = $DB->prepare('UPDATE events set frequence=:frequence where id =:id');
						$req->bindvalue(':frequence',$_POST['frequence']);
						$req->bindvalue(':id',$_GET['id']);
						$req->execute();
					}
					if($modif==1) 
						echo "modification effectuée";	
				}
				if(isset($_POST['supprimer']))
				{ 
					suppression($DB,$_GET['id']);
					die('<META HTTP-equiv="refresh" content=0;URL=index.php>');
				}
				?>
				<br>
				<br>
					<form action ="<?php echo $_SERVER['PHP_SELF']."?id=".$res['id'];?>" method="post">
						<div id="gauche">Reporter la tache du <?php echo $res['datet']; ?> 		:  
							<select name="reporter" onchange="afficher(this.value);">
								<option value="pasreporter">pas de report</option>
								<option value="un">1 Jour</option>
								<option value="deux">2 Jours</option>
								<option value="sept">7 Jours</option>
								<option value="visible" >autre date</option>
							</select>
						</div>
						<div id="milieu">
							<div id="champ" style=" visibility:hidden" ><input  type = "Date" name="2" value = "Date" /></div>
						</div>
						<br>
						<br>
						Description :
						<textarea name="description" id="description">
						<?php 
							echo $res['description'];
						?>
						</textarea>
						<br>
						<br>
						<br>
						<div id="gauche2"> Frequence : 
							<?php 
							if($res['frequence']==1)
								echo"une seule fois";
							elseif($res['frequence']==2)
								echo"tous les jours";
							elseif($res['frequence']==3)
								echo"toutes les semaines";
							elseif($res['frequence']==4)
								echo"tous les mois";
							elseif($res['frequence']==5)
								echo"tous les ans";		
							?>
						</div>
						<div id="milieu">
							<select name="frequence" ">
								<option value="0"> changer la frequence </option>
								<option value="1"> Evenement ponctuel </option>
								<option value="2"> Quotidien </option>
								<option value="3"> Hebdomadaire(tous les lundis) </option>
								<option value="4"> Mensuel(le 30) </option>
								<option value="5"> Annuel(le 30 novembre) </option>
							</select>
						</div>
						<br>
						<br>	
						<div id="bloque">
							<input type="submit" name="supprimer" value="Supprimer"/>&nbsp;
							<a href="marque.php?as=fait&fre=<?php echo $res['frequence'];?>&dd=<?php echo $res['datet'];?>&tache=<?php echo $res['id'];?>" class="bouton-effectué">
							<input type="button" value="Fait"/></a>&nbsp;
							<input type="submit" value="Passer"/>&nbsp;
							<input type="submit" name="modifier" value="Modifier"/>
						</div> 

					</form>
			</div>
		</div>
	</div>
<?php require('Require/bas.php');?>